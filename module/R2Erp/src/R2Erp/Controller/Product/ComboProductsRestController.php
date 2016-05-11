<?php
namespace R2Erp\Controller\Product;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\Common\Collections\ArrayCollection;

class ComboProductsRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Erp\Entity\Product\ComboProduct";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
		$this->imagePath = BUILD_PATH . './public/img/uploads/products/';
	}

	// Listar - GET
	public function getList() {


		try {
			$repo = $this->em->getRepository($this->repository);
			$data = $repo->findAll();
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
		}

		if ($data) {
			try {
				$data = json_decode($this->serializer->serialize($data, 'json'), true);

				return new JsonModel(array('data' => $data, 'success' => true));
			} catch(\Exception $e) {
				return new JsonModel(array('data' => $data, 'error' => $e->getMessage()));
			}
			
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

		$arrayComboStore = $data['data']['comboStore'];
		unset($data['data']['comboStore']);

		$imageToUpload = $_FILES['file'];

		try {	
			$data = $this->prepareDataToInsert($data['data']);
			$entity = $this->service->insert($data);
		} catch(\Exception $e) {
			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
		}

		if ($entity) {
			$arrayComboStore['comboProduct'] = $entity;
			if ( isset($arrayComboStore['sellDiscountPrice']) ) {
				$arrayComboStore['sellDiscountPrice'] = $arrayComboStore['sellDiscountPrice'] === 'true' ? true: false;
			}
			if ( isset($arrayComboStore['sellNoShipping']) ) {
				$arrayComboStore['sellNoShipping'] = $arrayComboStore['sellNoShipping'] === 'true' ? true: false;
			}
			if ( isset($arrayComboStore['toSell']) ) {
				$arrayComboStore['toSell'] = $arrayComboStore['toSell'] === 'true' ? true: false;
			}
			$imageEntity = new \R2Base\Entity\Image();

			if ($imageToUpload['error'] == 0) {

				
				$imageName = 'combo_product_' . $entity->getId() . '_thumbnail.' . pathinfo($imageToUpload['name'], PATHINFO_EXTENSION);
				$imageEntity->setPath('/img/uploads/products/' . $imageName);

				if (move_uploaded_file($imageToUpload["tmp_name"], $this->imagePath . $imageName)) {

					$entity->setThumbnail($imageEntity);
					$this->em->persist($entity);
					$this->em->flush();
				}
			}

			try {
				$comboStore = new \R2Erp\Entity\Order\Store\ComboStore($arrayComboStore);
				$this->em->persist($comboStore);
				$this->em->flush();
			} catch(\Exception $e) {
				return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
			}
			
			$data = json_decode($this->serializer->serialize($entity, 'json'), true);

			return new JsonModel(array('data' => $data, 'success' => true));
		}

		return new JsonModel(array('success' => false, 'error' => 'No entity!'));

	}

	private function prepareDataToInsert ($data) {
		if (isset($data['products']) && count($data['products']) > 0) {
			$products = new ArrayCollection();
			foreach ($data['products'] as $product) {
				$product = $this->em->getRepository('R2Erp\Entity\Product\Product')->find($product['id']);
				$products->add($product);
			}
			$data['products'] = $products;
		}

		return $data;
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

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array('success' => false, 'id' => $id));

	}
}