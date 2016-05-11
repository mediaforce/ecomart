<?php

namespace R2Erp\Controller\Manufacturer;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Stdlib\Hydrator;
use Zend\View\Model\JsonModel;

class ManufacturersRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Erp\Entity\Manufacturer\Manufacturer";
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
		// return new JsonModel(array('id' => $id, 'success' => true));

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
		//return new JsonModel(array('raw data' => $data));

		$data = $this->prepareDataToInsert($data);
		$entity = $this->service->insert($data);

		if ($entity) {
			$data = json_decode($this->serializer->serialize($entity, 'json'), true);
			return new JsonModel(array('data' => $data, 'success' => true));
		} else {
			return new JsonModel(array('success' => false));
		}

		return new JsonModel(array('success' => false));
	}

	// alteracao - PUT
	public function update($id, $data) {
		//return new JsonModel(array('raw data' => $data));
		$data = $this->prepareDataToUpdate($data);
		$entity = $this->service->update($data);

		if ($entity) {
			$data = json_decode($this->serializer->serialize($entity, 'json'), true);
			return new JsonModel(array('data' => $data, 'success' => true));
		} else {
			return new JsonModel(array('success' => false));
		}

		return new JsonModel(array('success' => false));
	}

	// delete - DELETE
	public function delete($id) {
		//return new JsonModel(array('id delete' => $id, 'success' => false));
		try {
			$entity = $this->service->delete($id);
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
		}

		if ($entity) {
			return new JsonModel(array('data' => $id, 'success' => true));
		}

		return new JsonModel(array('success' => false));
	}

	private function prepareDataToInsert($data) {
		unset($data['company']['companyCategory']);
		unset($data['company']['contacts']);
		unset($data['company']['documents']);
		unset($data['company']['emails']);
		unset($data['company']['goodTags']);
		unset($data['company']['socialNetworks']);
		unset($data['company']['telephones']);

		$data['company']['companyType'] = new \R2Base\Enum\CompanyType('MANUFACTURER');
		$data['company'] = new \R2Base\Entity\Company($data['company']);

		return $data;
	}

	private function prepareDataToUpdate($data) {
		unset($data['company']['companyCategory']);
		unset($data['company']['contacts']);
		unset($data['company']['documents']);
		unset($data['company']['emails']);
		unset($data['company']['goodTags']);
		unset($data['company']['socialNetworks']);
		unset($data['company']['telephones']);

		unset($data['company']['createdAt']);
		unset($data['company']['updatedAt']);
		unset($data['company']['companyType']);
		//new \DateTime(date('Y-m-d H:i:s', strtotime($data['company']['updatedAt'])));

		$company = $this->em->getRepository('R2Base\Entity\Company')->find($data['company']['id']);
		(new Hydrator\ClassMethods)->hydrate($data['company'], $company);

		$data['company'] = $company;

		return $data;
	}
}