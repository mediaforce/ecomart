<?php
namespace R2Erp\Controller\Order\Sale;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class SalesRestController extends AbstractRestfulController {

	public function __construct($em) {
		$this->em = $em;
		$this->repository = "R2Erp\Entity\Order\Sale\Sale";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	// Listar - GET
	public function getList() {

		//return new JsonModel(array('success' => false, 'data' => $ids));
		if (isset($_GET['_storeIds'])) {
			$ids = json_decode($_GET['_storeIds'], true);
			try {
				$results = [];
				foreach($ids as $id) {
					$item = [];
					$item['id'] = $id;
					$result = $this->em->getRepository($this->repository)->createQueryBuilder('o')
						->innerJoin('o.store', 's')
						->where('s.id = :storeId')
						->setParameter('storeId', $id)
						->getQuery()
						->getResult();

					$totalVenda = 0;
					if ($result) {
						foreach($result as $sale) {
							$totalVenda += $sale->getQuantity();
						}
					}

					$item['qtdeVendida'] = $totalVenda;

					array_push($results, $item);
				}
			} catch(\Exception $e) {
				return new JsonModel(array('success' => true, 'error' => $e->getMessage()));
			}
			

			$data = json_decode($this->serializer->serialize($results, 'json'), true);

			return new JsonModel(array('success' => true, 'data' => $data));
		}

		$repo = $this->em->getRepository($this->repository);
		$data = $repo->findAll();
		return new JsonModel(array('data' => 'SHIT'));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		return new JsonModel(array('data' => 'SHIT'));
/*
$repo = $this->em->getRepository($this->repository);

$data = $repo->find($id)->toArray();*/

		return new JsonModel(array('data' => $data));
	}

	// Insere registro - POST
	public function create($data) {
		return new JsonModel(array('data' => 'SHIT'));
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
		return new JsonModel(array('data' => 'SHIT'));
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
		return new JsonModel(array('data' => 'SHIT'));
		/*$userService = $this->getServiceLocator()->get("R2User\Service\User");
			$res = $userService->delete($id);

			if ($res) {
				return new JsonModel(array('data' => array('success' => true)));
			} else {
				return new JsonModel(array('data' => array('success' => false)));
		*/

	}
}