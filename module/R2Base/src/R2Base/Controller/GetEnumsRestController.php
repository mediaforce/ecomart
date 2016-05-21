<?php

namespace R2Base\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class GetEnumsRestController extends AbstractRestfulController {

	// Listar - GET
	public function getList() {

		$data = array();
		$telephoneTypes = \R2Base\Enum\TelephoneType::getFields();
		$data['telephoneTypes'] = $telephoneTypes;

		// return null;

		return new JsonModel(array('data' => $data, 'success' => true));
	}

	// Retornar o registro especifico - GET
	public function get($enum) {
		// TODO fazer
		$data = array();

		return new JsonModel(array('data' => $data, 'enum_tmp' => $enum));

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