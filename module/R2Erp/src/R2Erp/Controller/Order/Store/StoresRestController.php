<?php

namespace R2Erp\Controller\Order\Store;



use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;

use Doctrine\Common\Collections\Criteria;



class StoresRestController extends AbstractRestfulController {



	public function __construct($em, $service) {

		$this->em = $em;

		$this->service = $service;

		$this->repository = "R2Erp\Entity\Order\Store\Store";

		$this->serializer = \JMS\Serializer\SerializerBuilder::create()

			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))

			->build();

	}



	// Listar - GET

	public function getList() {

		//return new JsonModel(array('success' => false, 'error' => 'WTF'));

		if (isset($_GET['title'])) {

			$result = $this->em->getRepository($this->repository)->createQueryBuilder('s')

				->innerJoin('s.product', 'p')

				->where('p.title LIKE :title')

				->setParameter('title', '%' . $_GET['title'] . '%')

				->getQuery()

				->getResult();



			$data = json_decode($this->serializer->serialize($result, 'json'), true);



			return new JsonModel(array('success' => true, 'data' => $data));

		}



		if (isset($_GET['launchs'])) {

			$repo = $this->em->getRepository($this->repository);



			if (isset($_GET['toSell'])) {



			} else {

				

			}



			$stores = $repo->findAll();



			$launchsStores = [];



			foreach($stores as $store) {

				if ($store->getProduct()->getIsLaunch()) {

					array_push($launchsStores, $store);

				}

			}



			$data = json_decode($this->serializer->serialize($launchsStores, 'json'), true);

			return new JsonModel(array('success' => true, 'data' => $data));



		}



		if (isset($_GET['departmentName'])) {

			$department = $this->em->getRepository('R2Erp\Entity\Product\ProductDepartment')->findOneBy(array('name' => $_GET['departmentName']));

			if ($department) {

				$repo = $this->em->getRepository($this->repository);

				try {

					if (isset($_GET['toSell'])) {

					} else {

					}

					$stores = $repo->findAll();



					$deptStores = [];



					foreach($stores as $store) {

						if ($store->getProduct()->getDepartment()->getId() == $department->getId()) {

							array_push($deptStores, $store);

						}

					}



				} catch (\Exception $e) {

					return new JsonModel(array('success' => false, 'error' => $e->getMessage()));

				}




				return new JsonModel(array('success' => true, 'department id' =>$department->getId(), 'count' => count($data), 'data' => $data));

			}



			return new JsonModel(array('success' => false));

		}



		try {

			$repo = $this->em->getRepository($this->repository);



			if (isset($_GET['toSell'])) {



			} else {

				

			}

			$data = $repo->findAll();

		} catch (\Exception $e) {

			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));

		}

		if ($data) {

			try {

				$data = json_decode($this->serializer->serialize($data, 'json'), true);	

			} catch(\Exception $e) {

				return new JsonModel(array('error' => $e->getMessage(), 'success' => false));

			}

			return new JsonModel(array('data' => $data, 'success' => true));

		}



		return new JsonModel(array('success' => false));

	}



	// Retornar o registro especifico - GET

	public function get($id) {

		//



		$repo = $this->em->getRepository($this->repository);

		try {

			$data = $repo->find((int) $id);

		} catch (\Exception $e) {

			return new JsonModel(array('error' => $e->getMessage(), 'success' => false));

		}



		if ($data) {

			$data = json_decode($this->serializer->serialize($data, 'json'), true);



			return new JsonModel(array('data' => $data, 'success' => true));

		}



		return new JsonModel(array('success' => false));

	}



	// Insere registro - POST

	public function create($data) {

		return new JsonModel(array('success' => false, 'raw data' => $data));



	}



	// alteracao - PUT

	public function update($id, $data) {



		//return new JsonModel(array('success' => false, 'raw data' => $data));

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



	private function prepareDataToUpdate($data) {

		unset($data['product']);



		if ($data['storeStatus']) {

			$data['storeStatus'] = new \R2Erp\Enum\StoreStatus('VENDA');

		} else {

			$data['storeStatus'] = new \R2Erp\Enum\StoreStatus('MANTER');

		}



		return $data;

	}



	// delete - DELETE

	public function delete($id) {

		return new JsonModel(array('success' => false, 'id' => $id));



	}

}