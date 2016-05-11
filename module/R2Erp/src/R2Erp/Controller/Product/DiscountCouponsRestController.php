<?php

namespace R2Erp\Controller\Product;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class DiscountCouponsRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Erp\Entity\Product\DiscountCoupon";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	// Listar - GET
	public function getList() {
		//return new JsonModel(array('TESTE' => 'OK', 'success' => false));
		$uniques = [];

		$repo = $this->em->getRepository($this->repository);
		$data = $repo->findAll();

		if (isset($_GET['uniques'])) {

			$getUniques = json_decode($_GET['uniques'], true);

			if (isset($getUniques['coupon'])) {
				$uniques['coupon'] = [];
			}

			foreach ($data as $coupon) {
				if (array_key_exists('coupon', $uniques)) {
					array_push($uniques['coupon'], $coupon->getCoupon());
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
		//return new JsonModel(array('raw data' => $data, 'success' => false));

		try {
			$data = $this->prepareDataToInsert($data);
			$entity = $this->service->insert($data);
		} catch (\Exception $e) {
			return new JsonModel(array('error' => $e->getMessage(), 'success' => false));
		}
		

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
		$entity = $this->service->delete($id);

		if ($entity) {
			return new JsonModel(array('data' => $id, 'success' => true));
		}

		return new JsonModel(array('success' => false));
	}

	private function prepareDataToInsert($data) {
		if (isset($data['department'])) {
			$data['couponType'] = new \R2Erp\Enum\DiscountCouponType("DEPARTMENT");
			if ($data['department'] === 'ALL') {
				$data['toAll'] = true;
				unset($data['department']);
			} else {
				$data['toAll'] = false;
				$data['department'] = $this->em->getRepository('R2Erp\Entity\Product\ProductDepartment')->find($data['department']);
			}

		} else {
			$data['couponType'] = new \R2Erp\Enum\DiscountCouponType("PRODUCT");	
		}

		$data['startDate'] = new \DateTime(date('Y-m-d H:i:s', strtotime($data['startDate'])));
		$data['finishDate'] = new \DateTime(date('Y-m-d H:i:s', strtotime($data['finishDate'])));
		
		return $data;
	}

	private function prepareDataToUpdate($data) {

		return $data;
	}
}