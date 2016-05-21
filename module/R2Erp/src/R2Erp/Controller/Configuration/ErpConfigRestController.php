<?php
namespace R2Erp\Controller\Configuration;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ErpConfigRestController extends AbstractRestfulController {
	public function getList() {
		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

		$repo = $em->getRepository("R2Erp\Entity\Configuration\ErpConfigSuperclass");

		$data = $repo->findArray();

		return new JsonModel(array('data' => $data));
	}

	// check Identity - GET
	public function get($id) {
		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
		$config = $em->find("R2Erp\Entity\Configuration\ErpConfigSuperclass", $id);

		if (!is_null($config)) {
			return new JsonModel(array('data' => $config->toArray(), 'success' => true));
		}
		return new JsonModel(array('data' => 'ID ' . $id . ' NOT FOUND!', 'success' => false));
	}

	// logar - POST
	public function create($data) {
		return new JsonModel(array());
	}

	// update - PUT
	public function update($id, $data) {
		return new JsonModel(array());
	}

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array());
	}
}
