<?php

namespace R2Erp\Controller\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Stdlib\Hydrator;
use Zend\View\Model\JsonModel;

class CategoriesRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Erp\Entity\Product\ProductCategory";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	// Listar - GET
	public function getList() {
		$uniques = [];

		$repo = $this->em->getRepository($this->repository);
		$data = $repo->findAll();

		if (isset($_GET['uniques'])) {

			$getUniques = json_decode($_GET['uniques'], true);

			if (isset($getUniques['name'])) {
				$uniques['name'] = [];
			}

			foreach ($data as $department) {
				if (array_key_exists('name', $uniques)) {
					array_push($uniques['name'], $department->getName());
				}
			}

			return new JsonModel(array('data' => $uniques));

		}

		if ($data) {
			$data = json_decode($this->serializer->serialize($data, 'json'), true);

			return new JsonModel(array('data' => $data, 'success' => true));
		}

		return new JsonModel(array('success' => false));
	}

	// Retornar o registro especifico - GET
	public function get($id) {

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

		try {
			$data = $this->prepareDataToInsert($data);
			$entity = $this->service->insert($data);
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));
		}

		if ($entity) {
			return new JsonModel(array('data' => array(
				'entityId' => $entity->getId()), 'success' => true));
		} else {
			return new JsonModel(array('success' => false));
		}

		return new JsonModel(array('success' => false));
	}

	// alteracao - PUT
	public function update($id, $data) {
		//return new JsonModel(array('success' => false, 'raw_data' => $data['subcategories']));
		//return new JsonModel(array('raw data' => $data));
		//
		try {
			$data = $this->prepareDataToUpdate($data);
			$entity = $this->service->update($data);

			//return new JsonModel(array('success' => false, 'erro' => $entity));
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'erro' => $e->getMessage()));
		}

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
		//return new JsonModel(array('id delete' => $id, 'success' => false));
		try {
			$entity = $this->service->delete($id);
		} catch (\Exception $e) {
			return new JsonModel(array('erro' => $e->getMessage(), 'success' => false));
		}

		return new JsonModel(array('data' => $id, 'success' => true));

		return new JsonModel(array('success' => false));
	}

	private function prepareDataToInsert($data) {

		$subcategories = new ArrayCollection();
		if (isset($data['subcategories'])) {
			if (count($data['subcategories']) > 0) {
				foreach ($data['subcategories'] as $subcategory) {
					$entity = new \R2Erp\Entity\Product\ProductSubcategory($subcategory);
					$subcategories->add($entity);
				}
				$data['subcategories'] = $subcategories;
			} else {
				$data['subcategories'] = new \Doctrine\Common\Collections\ArrayCollection();
			}
		}

		return $data;
	}

	private function prepareDataToUpdate($data) {
		$subcategories = new ArrayCollection();
		if (isset($data['subcategories'])) {
			if (count($data['subcategories']) > 0) {
				foreach ($data['subcategories'] as $subcategory) {
					if (isset($subcategory['id'])) {
						$entity = $this->em->getRepository('R2Erp\Entity\Product\ProductSubcategory')->find($subcategory['id']);
						(new Hydrator\ClassMethods)->hydrate($subcategory, $entity);
					} else {
						$entity = new \R2Erp\Entity\Product\ProductSubcategory($subcategory);
					}

					$subcategories->add($entity);
				}
				$data['subcategories'] = $subcategories;
			} else {
				$data['subcategories'] = new \Doctrine\Common\Collections\ArrayCollection();
			}
		} else {
			$data['subcategories'] = new \Doctrine\Common\Collections\ArrayCollection();
		}

		return $data;
	}
}