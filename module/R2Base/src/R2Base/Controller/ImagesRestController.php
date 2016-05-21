<?php

namespace R2Base\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ImagesRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Base\Entity\Image";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	// Listar - GET
	public function getList() {
		return new JsonModel(array('success' => false, 'GET LIST' => ''));
		try {
			$repo = $this->em->getRepository($this->repository);
			$data = $repo->findAll();
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
		}

		if ($data) {
			$data = json_decode($this->serializer->serialize($data, 'json'), true);

			return new JsonModel(array('data' => $data, 'success' => true));
		}

		return new JsonModel(array('success' => false));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		return new JsonModel(array('success' => false, 'GET' => $id));

		$repo = $this->em->getRepository($this->repository);

		$data = $repo->find((int) $id);

		if ($data) {
			$data = json_decode($this->serializer->serialize($data, 'json'), true);

			return new JsonModel(array('data' => $data, 'success' => true));
		}

		return new JsonModel(array('success' => false));
	}

	// Insere registro - POST
	public function create($data) {

		foreach ($_FILES['files']['name'] as $f => $name) {
			if ($_FILES['files']['error'][$f] == 4) {
				continue; // Skip file if any error found
			}
			if ($_FILES['files']['error'][$f] == 0) {
				if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], BUILD_PATH . './public/upload/' . $_FILES['files']['name'][$f]));
			}
		}

		return new JsonModel(array('success' => false, 'TEST $_FILES' => $_FILES['files'], 'files count' => $count));

	}

	// alteracao - PUT
	public function update($id, $data) {
		return new JsonModel(array('success' => false, 'UPDATE' => $data));
		//return new JsonModel(array('raw data' => $data));
		//$data = $this->prepareDataToUpdate($data);
		$entity = $this->service->update($data);

		if ($entity) {
			return new JsonModel(array('data' => array(
				'entityId' => $entity->getId()), 'success' => true));
		} else {
			return new JsonModel(array('success' => false));
		}

		return new JsonModel(array('success' => false));
	}

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array('success' => false, 'DELETE' => $data));
		//return new JsonModel(array('id delete' => $id, 'success' => false));
		$entity = $this->service->delete($id);

		if ($entity) {
			return new JsonModel(array('data' => $id, 'success' => true));
		}

		return new JsonModel(array('success' => false));
	}

	private function prepareDataToInsert($data) {

		return $data;
	}

	private function prepareDataToUpdate($data) {

		return $data;
	}
}