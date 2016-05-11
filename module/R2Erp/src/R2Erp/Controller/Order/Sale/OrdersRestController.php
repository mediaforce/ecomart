<?php
namespace R2Erp\Controller\Order\Sale;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class OrdersRestController extends AbstractRestfulController {

	public function __construct($em, $service, $ecommSrv) {
		$this->em = $em;
		$this->service = $service;
		$this->ecommSrv = $ecommSrv;
		$this->repository = "R2Erp\Entity\Order\Sale\Order";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
            ->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
            ->build();
	}

	// Listar - GET
	public function getList() {
		// return new JsonModel(array('get' => $_GET['customerId']));

		$repo = $this->em->getRepository($this->repository);

		$data = null;

		if (isset($_GET['customerId'])) {
			try {
				$data = $repo->findBy(array('customer' => $_GET['customerId']));
			} catch(\Excpetion $e) {
				return new JsonModel(array('error' => $e->getMessage()));
			}
			
		} else {
			$data = $repo->findAll();

			foreach($data as $order) {
				if ($order->getPayments()->count() === 0) {
					$this->ecommSrv->setOrder($order->getId())
						->removeOrder();
				}
			}

			$data = $repo->findAll();
		}
		if ($data) {
			$orders = json_decode($this->serializer->serialize($data, 'json'), true);
			return new JsonModel(array('success' => true, 'data' => $orders));	
		}

		return new JsonModel(array('success' => false));
		
	}

	// Retornar o registro especifico - GET
	public function get($id) {
/*
$repo = $this->em->getRepository($this->repository);

$data = $repo->find($id)->toArray();*/

		return new JsonModel(array('data' => $data));
	}

	// Insere registro - POST
	public function create($data) {
/*		return new JsonModel(array('data' => $data));

if ($data) {
$entity = $this->service->insert($data);

if ($entity) {
return new JsonModel(array('data' => array(
'entityId' => $entity->getId(),
'success' => true)));
} else {
return new JsonModel(array('data' => array('success' => false)));
}
} else {
return new JsonModel(array('data' => array('success' => false)));
}*/

	}

	// alteracao - PUT
	public function update($id, $data) {
		//return new JsonModel(array('raw data' => $data['data']['dateDelivery'], 'id' => $id, 'post' => $_POST));

		if (isset($data['data']['boleto']['status']) ) {

			$order = $this->em->getReference('R2Erp\Entity\Order\OrderSuperClass', $id);
            $payment = $order->getPayments()->get(0);
            $statusPayment = $data['data']['boleto']['status'];
            $payment->setStatus($statusPayment);
            $this->em->persist($payment);
            $this->em->flush();
            $order = $this->em->getReference('R2Erp\Entity\Order\Sale\Order', $id);
            $data = json_decode($this->serializer->serialize($order, 'json'), true);

			return new JsonModel(array('success' => true, 'order' => $data));
		}

		if (isset($data['data']['dateDelivery']) ) {
			$orderToSave = [];

			$orderToSave['id'] = $id;
			
			if ($data['data']['order']['dateShipped'] != null ) {
				$orderToSave['dateShipped'] = new \DateTime(date('Y-m-d H:i:s', strtotime($data['data']['order']['dateShipped'])));
			}

			if ($data['data']['order']['expectedDeliveryDate'] != null ) {
				$orderToSave['expectedDeliveryDate'] = new \DateTime(date('Y-m-d H:i:s', strtotime($data['data']['order']['expectedDeliveryDate'])));
			}

			if ($data['data']['order']['dateDelivered'] != null) {
				$orderToSave['dateDelivered'] = new \DateTime(date('Y-m-d H:i:s', strtotime($data['data']['order']['dateDelivered'])));	
			}

			$order = $this->service->update($orderToSave);
			$data = json_decode($this->serializer->serialize($order, 'json'), true);

			return new JsonModel(array('success' => true, 'order' => $data));
		}

		/*if ($data) {
			$user = $userService->update($data['user']);
			return new JsonModel(array('data' => $user));

			if ($user) {
				return new JsonModel(array('data' => array(
					'userId' => $user->getId(),
					'success' => true)));
			} else {
				return new JsonModel(array('data' => array('success' => false)));
			}
		}
			*/	
		
		
	}

	// delete - DELETE
	public function delete($id) {
		try {
			$order = $this->em->getReference($this->repository, $id);

			foreach($order->getSales() as $sale) {
				$this->em->remove($sale);
				$order->getSales()->removeElement($sale);
			}
			$this->em->remove($order);

			$this->em->flush();

			//$res = $this->service->delete($id);	
			$res = true;
	
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
		}
		

		if ($res) {
			return new JsonModel(array('success' => true));
		} else {
			return new JsonModel(array('success' => false));
		}

	}
}