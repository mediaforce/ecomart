<?php

namespace R2Acl\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RolesRestController extends AbstractRestfulController {

	// Listar - GET
	public function getList() {

		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

		$repo = $em->getRepository("R2Acl\Entity\Role");

		$data = $repo->findArray();

		return new JsonModel(array('data' => $data));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

		$repo = $em->getRepository("R2Acl\Entity\Role");

		$data = $repo->find($id)->toArray();

		return new JsonModel(array('data' => $data));

	}

	// Insere registro - POST
	public function create($data) {

	}

	// alteracao - PUT
	public function update($id, $data) {

	}

	// delete - DELETE
	public function delete($id) {

	}
}