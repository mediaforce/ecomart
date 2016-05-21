<?php



namespace R2User\Controller;



use Zend\Authentication\AuthenticationService;

use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;



class AuthRestController extends AbstractRestfulController {

	protected $authService;

	protected $adapter;



	public function __construct($adapter) {

		$this->adapter = $adapter;

		$this->serializer = \JMS\Serializer\SerializerBuilder::create()

			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))

			->build();

	}



	public function getAuthService() {

		return $this->authService;

	}



	//  check Identity - GET

	public function getList() {

		$sessionStorage = new SessionStorage();

		$this->authService = new AuthenticationService;

		$this->authService->setStorage($sessionStorage);

		try {

			if ($this->getAuthService()->hasIdentity()) {

				$user = json_decode($this->serializer->serialize($this->getAuthService()->getIdentity(), 'json'), true);

				return new JsonModel(array('data' => array('user' => $user, 'success' => true)));

			} else {

				$this->getResponse()->setStatusCode(401);

				return new JsonModel(array('data' => array('success' => false)));

			}

		} catch (\Exception $e) {

			$this->getResponse()->setStatusCode(401);

			return new JsonModel(array('data' => array('success' => false, 'error' => $e->getMessage())));

		}



	}



	// check Identity - GET

	public function get($id) {

		return null;



	}



	// logar - POST

	public function create($data) {



		$error = false;

		$sessionStorage = new SessionStorage();

		$auth = new AuthenticationService;

		$auth->setStorage($sessionStorage);



		$authAdapter = $this->adapter;



		$authAdapter->setUsername($data['user']);

		$authAdapter->setPassword($data['password']);



		$result = $auth->authenticate($authAdapter);



		if ($result->isValid()) {



			$user = $auth->getIdentity();

			$user = $user['user'];

			$sessionStorage->write($user, null);



			$user = json_decode($this->serializer->serialize($user, 'json'), true);

			return new JsonModel(array('data' => array('user' => $user, 'success' => true)));

		} else {

			$this->getResponse()->setStatusCode(401);

			return new JsonModel(array('data' => array('success' => false, 'result' => $result->getMessages())));

		}



	}



	// update - PUT

	public function update($id, $data) {

		return new JsonModel(array('data' => array('success' => false)));



	}



	// delete - DELETE

	public function delete($id) {

		$auth = new AuthenticationService;

		$auth->setStorage(new SessionStorage());

		$auth->clearIdentity();

		return new JsonModel(array('data' => array('success' => true)));

	}

}