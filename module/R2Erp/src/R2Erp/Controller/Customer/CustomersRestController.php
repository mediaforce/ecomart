<?php
namespace R2Erp\Controller\Customer;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CustomersRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Erp\Entity\Customer\Customer";
	}

	// Listar - GET
	public function getList() {
		$repo = $this->em->getRepository($this->repository);
		$data = $repo->findAll();
		return new JsonModel(array('data' => 'SHIT'));
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