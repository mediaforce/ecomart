<?php
namespace R2User\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Stdlib\Hydrator;
use Zend\View\Model\JsonModel;

class UsersRestController extends AbstractRestfulController {

	public function __construct($em, $service) {
		$this->em = $em;
		$this->service = $service;
		$this->repository = "R2User\Entity\User";
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
		//return new JsonModel(array('success' => false, 'data' => $data['person']['documents']));
		try {
			$data['active'] = true;
			$data = $this->prepareDataToInsert($data);
			//return new JsonModel(array('success' => false));
			$entity = $this->service->insert($data);
		} catch (\Exception $e) {
			return new JsonModel(array('success' => false, 'error' => $e->getMessage()));
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
		//return new JsonModel(array('raw data' => $data) );

		if (isset($data['onlyPassword'])) {
			$dataToUpdate = [
				'id' => $data['data']['id'],
				'password' => $data['data']['password'],
			];

			$entity = $this->service->update($dataToUpdate);

			if ($entity) {
				return new JsonModel(array('data' => array(
					'id' => $entity->getId(), 'password' => $data['data']['password']
				), 'success' => true));
			} else {
				return new JsonModel(array('success' => false));
			}
		}
		//return new JsonModel(array('raw data' => $data) );
		$data = $this->prepareDataToUpdate($data);
		$entity = $this->service->update($data);

		if ($entity) {
			return new JsonModel(array('data' => array(
				'entityId' => $entity->getId(),
			), 'success' => true));
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
		$data['role'] = $this->em->getReference('R2Acl\Entity\Role', 1);

		$data['user'] = new \R2Base\Entity\Email(array('address' => $data['user']));

		$data['customerType'] = new \R2Erp\Enum\CustomerType($data['customerType']);
		$getDocType = $data['customerType']->value();

		$person = $data['person'];

		$documents = new ArrayCollection();
		if (count($person['documents']) > 0) {
			foreach ($person['documents'] as $document) {
				$document['documentType'] = new \R2Base\Enum\DocumentType($document['documentType']);
				$documents->add(new \R2Base\Entity\Document($document));
			}
		}
		$person['documents'] = $documents;

		$addresses = new ArrayCollection();
		if (count($person['addresses']) > 0) {
			foreach ($person['addresses'] as $address) {
				$address['state'] = $this->em->getReference('R2Base\Entity\State', $address['state']);
				$address['city'] = $this->em->getReference('R2Base\Entity\City', $address['city']);
				$addresses->add(new \R2Base\Entity\Address($address));
			}
		}
		$person['addresses'] = $addresses;

		$telephones = new ArrayCollection();
		if (count($person['telephones']) > 0) {
			foreach ($person['telephones'] as $telephone) {

				$telephone['telephoneType'] = new \R2Base\Enum\TelephoneType($telephone['telephoneType']);

				$telephones->add(new \R2Base\Entity\Telephone($telephone));
			}
		}
		$person['telephones'] = $telephones;



		$data['person'] = new \R2Base\Entity\Person($person);

		return $data;
	}

	private function prepareDataToUpdate($data) {
		unset($data['createdAt']);
		unset($data['updatedAt']);
		unset($data['role']);
		unset($data['user']);
		unset($data['customerType']);
		unset($data['salt']);
		unset($data['activationKey']);
		unset($data['password']);


		$person = $data['person'];

		unset($person['createdAt']);
		unset($person['emails']);
		unset($person['creditCards']);
		unset($person['socialNetworks']);
		unset($person['updatedAt']);

		$documents = new ArrayCollection();
		if (count($person['documents']) > 0) {
			foreach ($person['documents'] as $document) {
				$document['documentType'] = new \R2Base\Enum\DocumentType('CPF');
				$documents->add(new \R2Base\Entity\Document($document));
			}
		}
		$person['documents'] = $documents;

		$addresses = new ArrayCollection();
		if (count($person['addresses']) > 0) {
			foreach ($person['addresses'] as $address) {
				$address['state'] = $this->em->getReference('R2Base\Entity\State', $address['state']);
				$address['city'] = $this->em->getReference('R2Base\Entity\City', $address['city']);
				$addresses->add(new \R2Base\Entity\Address($address));
			}
		}
		$person['addresses'] = $addresses;



		$telephones = new ArrayCollection();
		if (count($person['telephones']) > 0) {
			foreach ($person['telephones'] as $telephone) {

				$telephone['telephoneType'] = new \R2Base\Enum\TelephoneType($telephone['telephoneType']);

				$telephones->add(new \R2Base\Entity\Telephone($telephone));
			}
		}
		$person['telephones'] = $telephones;

		$data['person'] = new \R2Base\Entity\Person($person);

		return $data;
	}
}