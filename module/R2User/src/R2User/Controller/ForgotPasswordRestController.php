<?php
namespace R2User\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Stdlib\Hydrator;
use Zend\View\Model\JsonModel;

use R2Base\Mail\Mail;

class ForgotPasswordRestController extends AbstractRestfulController {

	private $em;
	private $transport;
	private $view;

	public function __construct($em, $transport, $view) {
		$this->em = $em;
		$this->transport = $transport;
		$this->view = $view;

		$this->repository = "R2User\Entity\User";

		$this->serializer = \JMS\Serializer\SerializerBuilder::create()
			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))
			->build();
	}

	// Listar - GET
	public function getList() {

		return new JsonModel(array('success' => false, 'get' => $_GET));
	}

	// Retornar o registro especifico - GET
	public function get($user) {

		$repo = $this->em->getRepository($this->repository);

		$data = $repo->findOneBy(array('user' => $user));

		if ($data) {
			$data = json_decode($this->serializer->serialize($data, 'json'), true);

			$dataEmail = array('nome' => $data['person']['name'], 'activationKey' => $data['activationKey']);

			try {
				$mail = new Mail($this->transport, $this->view, 'forgot-password');

				$mail->setSubject('testando recadastro senha')
					->setTo($data['user'])
					->setData($dataEmail)
					->prepare()
					->send();	

			} catch(\Exception $e) {
				return new JsonModel(array('success' => false, 'data' => $data, 'error' => $e->getMessage()));
			}
			

			return new JsonModel(array('success' => true, 'data' => $data));
		}

		return new JsonModel(array('data' => false));

	}

	// Insere registro - POST
	public function create($data) {
		
	}

	// alteracao - PUT
	public function update($id, $data) {

	}

	// delete - DELETE
	public function delete($id) {

	}

}