<?php 
namespace R2Erp\Controller\Checkout;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class PagseguroRestController extends AbstractRestfulController {
	protected $authService;
	protected $em;
	protected $ecommSrv;

	public function __construct($em, $ecommSrv) {
		$this->em = $em;
		$this->ecommSrv = $ecommSrv;
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	public function getAuthService() {
		return $this->authService;
	}

	// Listar - GET
	public function getList() {
		/*$transactionCode = "6E951516-926C-4C56-BA58-BF77B9B7A055";  
  		
  		$paymentRequest = new \PagSeguroPaymentRequest();
  		
		try {  
		  
		    $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
		  
		    $response = \PagSeguroCancelService::requestCancel($credentials, $transactionCode);  
		  
		} catch (\Exception $e) {  
		    die($e->getMessage());  
		}  

		print_r($response->getErrors());

		die;
*/

/*
		$paymentRequest = new \PagSeguroPaymentRequest();

		$notificationCode = 'D484EE-BDCE54CE545E-5DD436BF8252-AB2D4E';

		try {
			$credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
			$response = \PagSeguroNotificationService::checkTransaction(  
				$credentials,  
				$notificationCode  
			);

		} catch(\Exception $e) {
			return new JsonModel(array('error' => $e->getMessage()));
		}
		print_r($response);
		die;
*/

		$paymentRequest = new \PagSeguroPaymentRequest();

		try {
		  $credentials = \PagSeguroConfig::getAccountCredentials();
		  $sessionId = \PagSeguroSessionService::getSession($credentials);
		} catch (\PagSeguroServiceException $e) {
		  return new JsonModel(array('error' => $e->getMessage()));
		}

		return new JsonModel(array('data' => $sessionId));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
/*
$repo = $this->em->getRepository($this->repository);

$data = $repo->find($id)->toArray();*/

		return new JsonModel(array('data' => 'get'));
	}

	// Insere registro - POST
	public function create($data) {
		//return new JsonModel(array('success' =>false, 'data' => $data));

			
		$items = $data['items'];

		$customer = $this->em->getReference('R2User\Entity\User', $data['customer']);
		$person = $customer->getPerson();
        $shippingType ='SEDEX';
        $shippingCost = number_format($data['shipping'], 2, '.', '');
        $totalOrder = number_format($data['totalAmount'], 2, '.', '');
        $paymentType ='PAGSEGURO';
        $invoiceDate = new \DateTime("now");
        $discount = 0;
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

		$paymentRequest = new \PagSeguroPaymentRequest();

		foreach($items as $item) {
			$total = $item['_quantity'] * $item['_price'];
			$total = number_format((float)$total, 2, '.', '');
			$paymentRequest->addItem($item['_id'], $item['_name'], $item['_quantity'], $total);	
			
		}

		$shippingAddress = $person->getAddresses()->get(0);

		$sedexCode = \PagSeguroShippingType::getCodeByType($shippingType);
		$paymentRequest->setShippingType($sedexCode);
		$paymentRequest->setShippingCost($shippingCost);

		$paymentRequest->setShippingAddress(
			$shippingAddress->getPostcode(), 
			$shippingAddress->getAddress1(), 
			$shippingAddress->getNumber(),
			$shippingAddress->getAddress2(),
			$shippingAddress->getNeighborhood(),
			$shippingAddress->getCity()->getName(),
			$shippingAddress->getState()->getCode(),
			"BRA"
		);

		$telephone = $person->getTelephones()->get(0);
		$document = $person->getDocuments()->get(0);

		$areaCode = substr($telephone->getNumber(), 0, 2);
		$telNumber = substr($telephone->getNumber(), 2);

		$paymentRequest->setSender(
			$person->getName(), 
			$customer->getUser(), 
			$areaCode, 
			$telNumber, 
			$document->getDocumentType(),
			$document->getField1()
		);

		try {
			$this->ecommSrv->setItems($items)
				->createOrder($customer, $shippingType, $shippingCost, $totalOrder, $paymentType, $discount, $coupon)
                ->createSales();
		} catch(\Exception $e) {
			$this->ecommSrv->removeOrder();
			return new JsonModel(array('success' =>false, 'error' => $e->getMessage()));
		}

		try {
			$paymentRequest->setCurrency("BRL");

			$paymentRequest->setReference($this->ecommSrv->getOrderId());

			$paymentRequest->setRedirectUrl("https://www.dev.ecomart.com.br/");

			$paymentRequest->addParameter('notificationURL', 'https://www.dev.ecomart.com.br/api/erp/checkout/testreturn');
		} catch(\Exception $e) {
			$this->ecommSrv->removeOrder();
			return new JsonModel(array('success' =>false, 'error' => $e->getMessage()));
		}
		

		try {  
		  
		  $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
		  $checkoutUrl = $paymentRequest->register($credentials);  
		  return new JsonModel(array('success' =>true, 'data' => $checkoutUrl, 'pedidoId' => $this->ecommSrv->getOrderId()));
		  
		} catch (\PagSeguroServiceException $e) {  
			$this->ecommSrv->removeOrder();
		    return new JsonModel(array('success' =>false, 'error' => $e->getMessage()));
		} 


	}

	// alteracao - PUT
	public function update($id, $data) {
		//return new JsonModel(array('raw data ' => $data));

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
	public function delete($id) {
		/*$userService = $this->getServiceLocator()->get("R2User\Service\User");
			$res = $userService->delete($id);

			if ($res) {
				return new JsonModel(array('data' => array('success' => true)));
			} else {
				return new JsonModel(array('data' => array('success' => false)));
		*/

	}
}