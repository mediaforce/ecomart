<?php

namespace R2Base\Controller;



use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;



class CompaniesRestController extends AbstractRestfulController {



	public function __construct(\Doctrine\ORM\EntityManager $em) {

		$this->em = $em;

		$this->repository = "R2Base\Entity\Company";

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



			if (isset($getUniques['companyName'])) {

				$uniques['companyName'] = [];

			}



			if (isset($getUniques['website'])) {

				$uniques['website'] = [];

			}



			foreach ($data as $company) {

				if (array_key_exists('companyName', $uniques)) {

					array_push($uniques['companyName'], $company->getCompanyName());

				}



				if (array_key_exists('website', $uniques)) {

					array_push($uniques['website'], $company->getWebsite());

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



		$data = $repo->find($id);



		if ($data) {

			$data = json_decode($this->serializer->serialize($data, 'json'), true);



			return new JsonModel(array('data' => $data, 'success' => true));

		}



		return new JsonModel(array('success' => false));

	}



	// Insere registro - POST

	public function create($data) {



	}



	// alteracao - PUT

	public function update($state_id, $data) {



	}



	// delete - DELETE

	public function delete($id) {



	}

}