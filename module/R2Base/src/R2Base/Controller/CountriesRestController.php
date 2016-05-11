<?php

namespace R2Base\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CountriesRestController extends AbstractRestfulController {

	// Listar - GET
	public function getList() {

		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

		$repo = $em->getRepository("R2Base\Entity\Caountry");

		$data = $repo->findArray();

		return new JsonModel(array('data' => $data, 'success' => true));
	}

	// Retornar o registro especifico - GET
	public function get($enum) {
		// TODO fazer
		$data = array();

		return new JsonModel(array('data' => $data));

	}

	// Insere registro - POST
	public function create($data) {

		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not permitted!'));

	}

	// alteracao - PUT
	public function update($id, $data) {
		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not permitted!'));
	}

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not permitted!'));
	}
}