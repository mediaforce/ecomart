<?php
namespace R2Erp\Controller\Checkout;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Cielo\Cielo;
use Cielo\CieloException;
use Cielo\Transaction;
use Cielo\Holder;
use Cielo\PaymentMethod;
use Cielo\Consultation;

use Cielo\Cancellation;


class CieloRestController extends AbstractRestfulController
{

    protected $em;
    protected $ecommSrv;

    public function __construct($em, $ecommSrv)
    {
        $this->em = $em;
        $this->ecommSrv = $ecommSrv;
        $this->serializer = \JMS\Serializer\SerializerBuilder::create()
            ->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
            ->build();
    }

    // Listar - GET
    public function getList()
    {


        $mid = '1047048431'; //seu merchant id
        $key = 'e48b6a4c35a46abce84c282d409edf06d2903f7addaebfd3e7dc474b2c28fee3'; //sua chave

        $cielo = new Cielo($mid, $key, Cielo::PRODUCTION);

$cancellation = $cielo->Cancellation('104704843100000040BA'); //tid da transação

  try {

      $cancellationResponse = $cielo->cancellationRequest($cancellation);

        if (is_object($cancellationResponse)){

          printf("TID=%s\n", $cancellationResponse->getTid());
          printf("STATUS=%s\n", $cancellationResponse->getStatus());
          printf("PAN=%s\n", $cancellationResponse->getPan());

          printf("STATUS CODE=%s\n", $cancellationResponse->getCancellationInformation()->getCode());
          printf("CACELLATION MESSAGE=%s\n", $cancellationResponse->getCancellationInformation()->getMessage());
          printf("CACELLATION DATE=%s\n", $cancellationResponse ->getCancellationInformation()->getDateTime());
          printf("CACELLATION VALUE=%s\n", $cancellationResponse->getCancellationInformation()->getValue());

        }


  } catch (CieloException $e) {

      printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

  }

  die;



        $cielo = new Cielo($mid, $key, Cielo::PRODUCTION);

        $consultation = $cielo->consultation('104704843100000040BA'); //tid da transação

        try {

              $consultationResponse = $cielo->consultationRequest($consultation);

                if (is_object($consultationResponse)){

                    print_r($consultationResponse->getStatus());

                  /*printf("TID=%s\n", $consultationResponse->getTid());
                  printf("STATUS=%s\n", $consultationResponse->getStatus());
                  printf("PAN=%s\n", $consultationResponse->getPan());

                  printf("AUTORIZATION CODE=%s\n", $consultationResponse->getAuthorization()->getCode());
                  printf("AUTORIZATION MESSAGE=%s\n", $consultationResponse->getAuthorization()->getMessage());
                  printf("AUTORIZATION DATE=%s\n", $consultationResponse ->getAuthorization()->getDateTime());*/

                }


          } catch (CieloException $e) {

              printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

          }

          die;
    }

    // Retornar o registro especifico - GET
    public function get($id)
    {
        /*
        $repo = $this->em->getRepository($this->repository);

        $data = $repo->find($id)->toArray();*/

        return new JsonModel(array('data' => 'get'));
    }

    // Insere registro - POST
    public function create($data)
    {   

        $card = $data['transaction']['card'];
        $installments = json_decode($card['installments'], true);

        $cardNumber = $card['number'];
        $cardMonth = $card['exp_month'];
        $cardYear = $card['exp_year'];
        $cardHolder = '';

        switch($card['holder']) {
            case 'visa':
                $cardHolder = PaymentMethod::VISA;
                break;
            case 'mastercard':
                $cardHolder = PaymentMethod::MASTERCARD;
                break;
            case 'diners':
                $cardHolder = PaymentMethod::DINERS;
                break;
            case 'discover':
                $cardHolder = PaymentMethod::DISCOVER;
                break;
            case 'elo':
                $cardHolder = PaymentMethod::ELO;
                break;
            case 'amex':
                $cardHolder = PaymentMethod::AMEX;
                break;
            case 'jcb':
                $cardHolder = PaymentMethod::JCB;
                break;
            case 'aura':
                $cardHolder = PaymentMethod::AURA;
                break;
            case 'maestro':
                $cardHolder = PaymentMethod::ELO;
                break;
            default:
                break;
        }

        $cardCvv = $card['cvv'];

        if ($installments['quantity'] > 1) {
            $cardPaymentMethod = PaymentMethod::PARCELADO_LOJA;
            $cardPaymentMethod_MYENUM = 'PARCELADO LOJA';
        } else {
            $cardPaymentMethod = PaymentMethod::CREDITO_A_VISTA;
            $cardPaymentMethod_MYENUM = 'CREDITO À VISTA';
        }

        $currency = 986; // moeda brasileira

        $items = $data['items'];
        $customer = $this->em->getReference('R2User\Entity\User', $data['customer']);
        $shippingType ='SEDEX';
        $shippingCost = $data['shipping'];
        $totalOrder = $installments['totalAmount'];
        $totalOrderInt = intval($totalOrder * 100);
        $paymentType ='CIELO';
        $coupon = null;
        /*if (isset($data['discount'])) {
            $discount = $totalOrder * ($data['discount']/100);
            $coupon = $data['coupon'];
        } else {
            $discount = 0;
        }*/

        if ($data['servicoFrete'] === '41106') {
            $shippingType = 'PAC';
        }

        $amount = $totalOrder;       

        $mid = '1047048431'; //seu merchant id
        $key = 'e48b6a4c35a46abce84c282d409edf06d2903f7addaebfd3e7dc474b2c28fee3'; //sua chave

        try {
            $cielo = new Cielo($mid, $key, Cielo::PRODUCTION);

            $holder = $cielo->holder($cardNumber, $cardYear, $cardMonth, Holder::CVV_INFORMED, $cardCvv);

            $this->ecommSrv->setItems($items)
                    ->createOrder($customer, $shippingType, $shippingCost, $totalOrder, $paymentType, $discount, $coupon)
                    ->createSales();  

            

            $order = $cielo->order($this->ecommSrv->getOrderId(), $totalOrderInt);
            $paymentMethod = $cielo->paymentMethod($cardHolder, $cardPaymentMethod, $installments['quantity']);
            $transaction = $cielo->transaction($holder,
                $order,
                $paymentMethod,
                'https://www.dev.ecomart.com.br/api/erp/checkout/testreturn',
                Transaction::AUTHORIZE_WITHOUT_AUTHENTICATION,
                true);
        } catch(\Exception $e) {
            $this->ecommSrv->removeOrder();
            return new JsonModel(array('success' => false, 'erro_cielo' => $e->getMessage()));
        }
        
        try {

            $transaction = $cielo->transactionRequest($transaction);

            if ($transaction->getAuthorization()->getLR() == 0) {
                try {
                    $payment = $this->ecommSrv->updateTid($transaction->getTid())
                        ->createPayment($totalOrder, 'Transação em Andamento', $cardPaymentMethod_MYENUM);

                } catch (\Exception $e) {
                    $this->ecommSrv->removeOrder();
                    return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));
                }
                return new JsonModel(array('success' => true, 'msg' => 'TRANSAÇÃO ACEITA. TID = ' . $transaction->getTid(), 'pedidoId' => $this->ecommSrv->getOrderId()));
            } else {
                $this->ecommSrv->removeOrder();
                return new JsonModel(array('success' => false, 'code' => 'TRANSAÇÃO NÃO ACEITA. LR = ' . $transaction->getAuthorization()->getLR(), 'msg' => $transaction->getAuthorization()->getMessage()));
            }
            

        } catch (CieloException $e) {
            $this->ecommSrv->removeOrder();
            return new JsonModel(array('success' => false, 'erro' => $e->getMessage(), 'error_code' => $e->getCode()));

        }
        

    }

    // alteracao - PUT
    public function update($id, $data)
    {
        return new JsonModel(array('success' => false));

        /*$userService = $this->getServiceLocator()->get("R2User\Service\User");

            if ($data) {
                $user = $userService->update($data['user']);
                return new JsonModel(array('data' => $user));

                if ($user) {
                    return new JsonModel(array('data' => array(
                        'userId' => $user->getId(),
                        'success' => true)));
                } else {
                    return new JsonModel(array('data' => array('success' => false)));
                }
            } else {
                return new JsonModel(array('data' => array('success' => false)));
        */

    }

    // delete - DELETE
    public function delete($id)
    {
 

    }
}