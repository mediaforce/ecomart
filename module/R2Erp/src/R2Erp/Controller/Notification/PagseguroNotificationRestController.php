<?php
namespace R2Erp\Controller\Notification;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Cielo\Cielo;
use Cielo\CieloException;
use Cielo\Consultation;

class PagseguroNotificationRestController extends AbstractRestfulController
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
        die('shit');

    }

    // Retornar o registro especifico - GET
    public function get($id)
    {
        $paymentRequest = new \PagSeguroPaymentRequest();
        
        try {  
          
            $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
            $response = \PagSeguroTransactionSearchService::searchByCode(  
                $credentials,  
                $id
              ); 

            $arrConsult = [
                        'tid' => $response->getCode(),
                        'status' => $response->getStatus()->getValue(),
                        'orderId' => $response->getReference(),
                        'payment_method' => $response->getPaymentMethod()->getType()->getTypeFromValue()
                    ];

            //$data = json_decode($this->serializer->serialize($response, 'json'), true);
            //var_dump($response->getInstallmentCount()); die;
            $statusPayment =  null;
            $removeSales = false;
            switch($response->getStatus()->getValue()) {
                case 0:
                    $statusPayment =  'Criada';
                    $removeSales = true;
                    break;
                case 1:
                    $statusPayment =  'Aguardando pagamento';
                    break;
                case 2:
                    $statusPayment =  'Em análise';
                    break;
                case 3:
                    $statusPayment = 'Pago';
                    break;
                case 4:
                    $statusPayment = 'Disponível';
                    break;
                case 5:
                    $statusPayment = 'Em disputa';
                    break;
                case 6:
                    $statusPayment = 'Devolvida';
                    $removeSales = true;
                    break;
                case 7:
                    $statusPayment = 'Cancelada';
                    $removeSales = true;
                    break;
                case 8:
                    $statusPayment = 'SELLER_CHARGEBACK';
                    $removeSales = true;
                    break;
                case 9:
                    $statusPayment = 'Contestada';
                    $removeSales = true;
                    break;
            }

            $paymentMethod = null;
            switch($response->getPaymentMethod()->getType()->getValue()) {
                case 1: 
                    if ($response->getInstallmentCount() > 1) {
                        $paymentMethod = 'PARCELADO PAGSEGURO';
                    } else {
                        $paymentMethod = 'CREDITO À VISTA';
                    }
                    break;
                case 2:
                    $paymentMethod = 'BOLETO';
                    break;
                case 3:
                    $paymentMethod = 'TRANSFERENCIA ONLINE';
                    break;
                case 4:
                    $paymentMethod = 'BALANÇO PAGSEGURO';
                    break;
                case 5:
                    $paymentMethod = 'OI PAGGO';
                    break;
                case 7:
                    $paymentMethod = 'DEPÓSITO';
                    break;
            }

            try {

                

                $ecomm = $this->ecommSrv->setOrder((int) $response->getReference());

                if ($ecomm->getOrder()->getPayments()->count() == 0) {
                    $ecomm->updateTid($response->getCode())
                    ->createPayment($response->getGrossAmount(), $statusPayment, $paymentMethod);
                } else {
                    return new JsonModel(array('success' => false));
                }
                
            } catch(\Exception $e) {
                return new JsonModel(array('success' => false, 'erro_asdas' => $e->getMessage()));
            }
            
                
            if ($removeSales) {
                $this->ecommSrv->removeSales();
            }


            $data = json_decode($this->serializer->serialize($ecomm->getOrder(), 'json'), true);

            return new JsonModel(array('success' => true, 'pagamentoStatus' => $statusPayment, 'order' => $data));  
          
        } catch (\Exception $e) {  
            return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));  
        }  

    }

    // alteracao - PUT
    public function update($id, $data)
    {
        $paymentRequest = new \PagSeguroPaymentRequest();

        try {
            $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
            $response = \PagSeguroTransactionSearchService::searchByCode(  
                $credentials,  
                $id
              );

            $statusPayment =  null;
            $removeSales = false;
            
            switch($response->getStatus()->getValue()) {
                case 0:
                    $statusPayment =  'Criada';
                    $removeSales = true;
                    break;
                case 1:
                    $statusPayment =  'Aguardando pagamento';
                    break;
                case 2:
                    $statusPayment =  'Em análise';
                    break;
                case 3:
                    $statusPayment = 'Pago';
                    break;
                case 4:
                    $statusPayment = 'Disponível';
                    break;
                case 5:
                    $statusPayment = 'Em disputa';
                    break;
                case 6:
                    $statusPayment = 'Devolvida';
                    $removeSales = true;
                    break;
                case 7:
                    $statusPayment = 'Cancelada';
                    $removeSales = true;
                    break;
                case 8:
                    $statusPayment = 'SELLER_CHARGEBACK';
                    $removeSales = true;
                    break;
                case 9:
                    $statusPayment = 'Contestada';
                    $removeSales = true;
                    break;
            }

            $this->ecommSrv->setOrder((int) $response->getReference())
                ->updatePayment($statusPayment);

            return new JsonModel(array('success' => true, 'pagamento status' => $statusPayment, 'transactionId' => $id)); 

        } catch(\Exception $e) {
            return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));
        }
    }


    // delete - DELETE
    public function delete($id)
    {
        return new JsonModel(array('success' => false));

    }
}