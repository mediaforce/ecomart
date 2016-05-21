<?php

namespace R2Erp\Controller\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\Hydrator;

class ProductsRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2Erp\Entity\Product\Product";
		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
		$this->imagePath = BUILD_PATH . './public/img/uploads/products/';
		$this->filePath = BUILD_PATH . './public/files/uploads/products/';
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
		//return new JsonModel(array('success' => false, 'data' => $data['data'], 'FILES' => $_FILES['file'] ));
		
		if (isset($data['is_put']) && (boolean) $data['is_put']) {
			$response = $this->update($data['id'], $data);
			return $response;
		}

		$arrayStore = $data['data']['store'];

		unset($data['data']['store']);

		if (isset($data['data']['coverIndex'])) {
			$coverIndex = $data['data']['coverIndex'];
		}	

		if (isset($_FILES['files'])) {
			$imagesToUpload = $_FILES['files'];
		} else {
			$imagesToUpload = [];
		}

		if (isset($_FILES['file'])) {
			$guideToUpload = $_FILES['file'];
		} else {
			$guideToUpload = [];
		}

		try {
			$data = $this->prepareDataToInsert($data['data']);
			$entity = $this->service->insert($data);

		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error entity' => $e->getMessage()));
		}

		if ($entity) {
			try {
				$arrayStore['product'] = $entity;
				if ( isset($arrayStore['sellDiscountPrice']) ) {
					$arrayStore['sellDiscountPrice'] = $arrayStore['sellDiscountPrice'] === 'true' ? true: false;
				}
				if ( isset($arrayStore['sellNoShipping']) ) {
					$arrayStore['sellNoShipping'] = $arrayStore['sellNoShipping'] === 'true' ? true: false;
				}
				if ( isset($arrayStore['toSell']) ) {
					$arrayStore['toSell'] = $arrayStore['toSell'] === 'true' ? true: false;
				}

				$store = new \R2Erp\Entity\Order\Store\Store($arrayStore);
				$this->em->persist($store);

				$this->em->flush();
			} catch (\Exception $e) {
				return new JsonModel(array('success' => false, 'error inventory' => $e->getMessage()));
			}

			if (count($imagesToUpload) > 0) {

				$images = new ArrayCollection();

				for ($index = 0; $index < count($imagesToUpload['name']); $index++) {
					if ($imagesToUpload['error'][$index] == 4) {

						continue;
					}

					if ($imagesToUpload['error'][$index] == 0) {

						$imageEntity = new \R2Base\Entity\Image();
						$imageName = 'product_' . $entity->getId() . '_image_' . ($index + 1) . '.' . pathinfo($imagesToUpload['name'][$index], PATHINFO_EXTENSION);
						$imageEntity->setPath('/img/uploads/products/' . $imageName);

						if (move_uploaded_file($imagesToUpload["tmp_name"][$index], $this->imagePath . $imageName)) {

							if (isset($coverIndex) && $coverIndex == $index) {
								$imageEntity->setIsCover(true);
							}

							$this->em->persist($imageEntity);
							$images->add($imageEntity);
						}
					}
				}

				$entity->setImages($images);

				$this->em->persist($entity);
				$this->em->flush();
			}

			if (count($guideToUpload) > 0) {
				if ($guideToUpload['error'] == 0) {

					$guideEntity = new \R2Erp\Entity\Product\ProductGuide();
					
					$guideName = 'product_' . $entity->getId() . '_guide.' . pathinfo($guideToUpload['name'], PATHINFO_EXTENSION);

					$guideEntity->setPath('/files/uploads/products/' . $guideName);

					if (move_uploaded_file($guideToUpload["tmp_name"], $this->filePath . $guideName)) {

						$entity->setProductGuide($guideEntity);
						$this->em->persist($entity);
						$this->em->flush();
					}
				}
			}

			

			return new JsonModel(array('data' => array(
				'entityId' => $entity->getId()), 'success' => true));
		}

		return new JsonModel(array('success' => false));

	}

	public function prepareDataToInsert($data) {
		$data['manufacturer'] = $this->em->getReference('R2Erp\Entity\Manufacturer\Manufacturer', $data['manufacturer']);

		$data['department'] = $this->em->getReference('R2Erp\Entity\Product\ProductDepartment', $data['department']);

		if (isset($data['category'])) {
			$data['category'] = $this->em->getReference('R2Erp\Entity\Product\ProductCategory', $data['category']);
		}

		if (isset($data['features']) && count($data['features']) > 0) {
			$features = new ArrayCollection();
			foreach ($data['features'] as $feature) {
				$feature = $this->em->getRepository('R2Erp\Entity\Product\FeatureTag')->find($feature['id']);
				$features->add($feature);
			}
			$data['features'] = $features;
		}

		if (isset($data['alternativeProducts']) && count($data['alternativeProducts']) > 0) {
			$alternativeProducts = new ArrayCollection();
			foreach ($data['alternativeProducts'] as $alternativeProduct) {
				$alternativeProduct = $this->em->getRepository($this->repository)->find($alternativeProduct['id']);
				$alternativeProducts->add($alternativeProduct);
			}
			$data['alternativeProducts'] = $alternativeProducts;
		}

		if (isset($data['videos']) && count($data['videos']) > 0) {
			$videos = new ArrayCollection();
			foreach ($data['videos'] as $video) {
				$video = new \R2Base\Entity\VideoLink($video);
				$videos->add($video);
			}
			$data['videos'] = $videos;
		}

		if (isset($data['isHighlighted'])) {
			$data['isHighlighted'] = (boolean) $data['isHighlighted'];
		}

		if (isset($data['isLaunch'])) {
			$data['isLaunch'] = (boolean) $data['isLaunch'];
		}

		return $data;

	}

	// alteracao - PUT
	public function update($id, $data) {
		

		$arrayStore = $data['data']['store'];

		unset($data['data']['store']);


		if (isset($data['data']['coverIndex'])) {
			$coverIndex = $data['data']['coverIndex'];
		}


		//return new JsonModel(array('success' => false, 'data' => $_FILES));
		unset($data['data']['images']);
		unset($data['data']['productGuide']);

		if (isset($_FILES['files'])) {
			$imagesToUpload = $_FILES['files'];
		} else {
			$imagesToUpload = [];
		}

		if (isset($_FILES['file'])) {
			$guideToUpload = $_FILES['file'];
		} else {
			$guideToUpload = [];
		}

		try {
			$data = $this->prepareDataToUpdate($data['data']);
			
			$entity = $this->service->update($data);

		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error entity' => $e->getMessage()));
		}

		//return new JsonModel(array('success' => false, 'data' => 'shit'));

		if ($entity) {
			
			
			try {
				$arrayStore['product'] = $entity;
				if ( isset($arrayStore['sellDiscountPrice']) ) {
					$arrayStore['sellDiscountPrice'] = $arrayStore['sellDiscountPrice'] === 'true' ? true: false;
				}
				if ( isset($arrayStore['sellNoShipping']) ) {
					$arrayStore['sellNoShipping'] = $arrayStore['sellNoShipping'] === 'true' ? true: false;
				}
				if ( isset($arrayStore['toSell']) ) {
					$arrayStore['toSell'] = $arrayStore['toSell'] === 'true' ? true: false;
				}

				$store = $this->em->getReference('R2Erp\Entity\Order\Store\Store', $entity->getStore()->getId());;
				(new Hydrator\ClassMethods)->hydrate($arrayStore, $store);
				$this->em->persist($store);
				$this->em->flush();
			} catch (\Exception $e) {
				return new JsonModel(array('success' => false, 'error inventory' => $e->getMessage()));
			}

			if (count($imagesToUpload) > 0) {

				$images = new ArrayCollection();

				for ($index = 0; $index < count($imagesToUpload['name']); $index++) {
					if ($imagesToUpload['error'][$index] == 4) {

						continue;
					}

					if ($imagesToUpload['error'][$index] == 0) {

						$imageEntity = new \R2Base\Entity\Image();
						$imageName = 'product_' . $entity->getId() . '_image_' . ($index + 1) . '.' . pathinfo($imagesToUpload['name'][$index], PATHINFO_EXTENSION);
						$imageEntity->setPath('/img/uploads/products/' . $imageName);

						if (move_uploaded_file($imagesToUpload["tmp_name"][$index], $this->imagePath . $imageName)) {

							if (isset($coverIndex) && $coverIndex == $index) {
								$imageEntity->setIsCover(true);
							}

							$this->em->persist($imageEntity);
							$images->add($imageEntity);
						}
					}
				}
				if (count($imagesToUpload) > 0) {
					foreach($entity->getImages() as $image) {
						$this->em->remove($image);
						$entity->getImages()->removeElement($image);
					}
					$this->em->flush();
					$entity->setImages($images);

					$this->em->persist($entity);
					$this->em->flush();
				}				
			}

			if (count($guideToUpload) > 0) {
				if ($guideToUpload['error'] == 0) {

					$guideEntity = new \R2Erp\Entity\Product\ProductGuide();
					
					$guideName = 'product_' . $entity->getId() . '_guide.' . pathinfo($guideToUpload['name'], PATHINFO_EXTENSION);

					$guideEntity->setPath('/files/uploads/products/' . $guideName);

					if (move_uploaded_file($guideToUpload["tmp_name"], $this->filePath . $guideName)) {

						$entity->setProductGuide($guideEntity);
						$this->em->persist($entity);
						$this->em->flush();
					}
				}
			}

			return new JsonModel(array('data' => array(
				'entityId' => $entity->getId()), 'success' => true));
		} else {
			return new JsonModel(array('success' => false));
		}

		return new JsonModel(array('success' => false));

	}

	public function prepareDataToUpdate($data) {
		unset($data['data']['images']);
		unset($data['createdAt']);
		unset($data['updatedAt']);
		$data['manufacturer'] = $this->em->getReference('R2Erp\Entity\Manufacturer\Manufacturer', $data['manufacturer']);

		$data['department'] = $this->em->getReference('R2Erp\Entity\Product\ProductDepartment', $data['department']);

		if (isset($data['category'])) {
			$data['category'] = $this->em->getReference('R2Erp\Entity\Product\ProductCategory', $data['category']);
		}

		if (isset($data['features']) && count($data['features']) > 0) {
			$features = new ArrayCollection();
			foreach ($data['features'] as $feature) {
				$feature = $this->em->getRepository('R2Erp\Entity\Product\FeatureTag')->find($feature['id']);
				$features->add($feature);
			}
			$data['features'] = $features;
		}

		if (isset($data['alternativeProducts']) && count($data['alternativeProducts']) > 0) {
			$alternativeProducts = new ArrayCollection();
			foreach ($data['alternativeProducts'] as $alternativeProduct) {
				$alternativeProduct = $this->em->getRepository($this->repository)->find($alternativeProduct['id']);
				$alternativeProducts->add($alternativeProduct);
			}
			$data['alternativeProducts'] = $alternativeProducts;
		}

		if (isset($data['videos']) && count($data['videos']) > 0) {
			$videos = new ArrayCollection();
			foreach ($data['videos'] as $video) {
				$video = new \R2Base\Entity\VideoLink($video);
				$videos->add($video);
			}
			$data['videos'] = $videos;
		}

		if (isset($data['isHighlighted'])) {
			$data['isHighlighted'] = (boolean) $data['isHighlighted'];
		}

		if (isset($data['isLaunch'])) {
			$data['isLaunch'] = (boolean) $data['isLaunch'];
		}

		return $data;
	}

	// delete - DELETE
	public function delete($id) {
		//return new JsonModel(array('data' => array('success' => false)));

		try {
			$res = $this->service->delete($id);
			return new JsonModel( array('success' => true));
		} catch(\Exception $e) {
			return new JsonModel(array('success' => false));
		}
		/*$userService = $this->getServiceLocator()->get("R2User\Service\User");
			$res = $userService->delete($id);

			if ($res) {
				return new JsonModel(array('data' => array('success' => true)));
			} else {
				return new JsonModel(array('data' => array('success' => false)));
		*/

	}
}