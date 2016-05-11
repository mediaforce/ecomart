<?php

namespace R2User\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CheckUniqueUserRestController extends AbstractRestfulController {

	public function __construct($em) {
		$this->em = $em;
	}

	// null
	public function getList() {
		return new JsonModel(array('shit'));
	}

	// Check
	public function get($user) {

		$repo = $this->em->getRepository("R2User\Entity\User");

		$data = $repo->findOneBy(array('user' => $user));

		if ($data) {
			return new JsonModel(array('data' => true));
		}

		return new JsonModel(array('data' => false));

	}

	// null
	public function create($data) {

		return new JsonModel(array());

	}

	// null
	public function update($id, $data) {
		return new JsonModel(array());

	}

	// null
	public function delete($id) {
		return new JsonModel(array());

	}
}