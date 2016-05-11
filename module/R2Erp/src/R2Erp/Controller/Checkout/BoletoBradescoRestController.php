<?php 
namespace R2Erp\Controller\Checkout;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\View\Model\ViewModel;

class BoletoBradescoRestController extends AbstractRestfulController {

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
	public function getList() {
		return new JsonModel(array('method' => 'getList'));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		return new JsonModel(array('method' => 'get'));
	}

	// Insere registro - POST
	public function create($data) {
        //return new JsonModel(array('success' => false, 'raw_data' => $data));
        
		$currency = 986; // moeda brasileira

        $items = $data['items'];

        $customer = $this->em->getReference('R2User\Entity\User', $data['customer']);
        

        if ($data['servicoFrete'] == '40010') {
            $shippingType = 'SEDEX';    
        } else {
            $shippingType = 'PAC';
        }
        $shippingCost = $data['shipping'];
        $totalOrder = $data['totalAmount'];

        $paymentType = 'BOLETO';
        $paymentMethod = $paymentType;
        $discount = 0;
        $coupon = null;
        /*if (isset($data['discount'])) {
            $discount = $totalOrder * ($data['discount']/100);
        }
        
        if (isset($data['coupon'])) {
            $coupon = $data['coupon'];
        }*/
        $amount = $totalOrder;
        $invoiceDate = new \DateTime("now");;

        //return new JsonModel(array('success' => false, 'raw_data' => $data));

        try {

            $this->ecommSrv->setItems($items)
                ->createOrder($customer, $shippingType, $shippingCost, $totalOrder, $paymentType, $discount, $coupon)
                ->createSales()
                ->createPayment($totalOrder, 'Aguardando Pagamento', $paymentMethod);

                //return new JsonModel(array('success' => false, 'erro' => 'teste'));


            $customer = json_decode($this->serializer->serialize($customer, 'json'), true);
        } catch (\Exception $e) {
            return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));
            $this->ecommSrv->removeOrder();
            return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));
        }

        return new JsonModel(array('success' => true, 'pedidoId' => $this->ecommSrv->getOrderId(), 'customer' => $customer));

	}

	// alteracao - PUT
	public function update($id, $data) {

		return new JsonModel(array('method' => 'update'));
	}

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array('method' => 'delete'));

	}
}