<?php

namespace R2Base\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class StatesRestController extends AbstractRestfulController {
	public function __construct(\Doctrine\ORM\EntityManager $em) {
		$this->em = $em;
		$this->repository = "R2Base\Entity\State";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	// Listar - GET
	public function getList() {

		$repo = $this->em->getRepository($this->repository);

		$data = $repo->findAll();

		if ($data) {
			$data = json_decode($this->serializer->serialize($data, 'json'), true);

			return new JsonModel(array('data' => $data, 'success' => true));
		}

		return new JsonModel(array('success' => false));

	}

	// Retornar o registro especifico - GET
	public function get($id) {

		$repo = $this->em->getRepository($this->repository);

		$data = $repo->find($id);

		if ($data) {
			$data = json_decode($this->serializer->serialize($data, 'json'), true);

			return new JsonModel(array('data' => $data, 'success' => true));
		}

		return new JsonModel(array('success' => false));
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