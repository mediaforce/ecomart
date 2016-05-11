<?php

namespace R2Tracker\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserTrackerRestController extends AbstractRestfulController {

	// Listar - GET
	public function getList() {

		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

		$repo = $em->getRepository("R2User\Entity\User");

		$data = $repo->findArray();

		return new JsonModel(array('data' => $data));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		$em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

		$repo = $em->getRepository("R2User\Entity\User");

		$data = $repo->find($id)->toArray();

		return new JsonModel(array('data' => $data));

	}

	// Insere registro - POST
	public function create($data) {
		$userService = $this->getServiceLocator()->get("R2User\Service\User");

		$request = $this->getRequest();
		$server = $request->getServer();

		$data['server'] = array(
			'siteUri' => $server->get('REQUEST_URI'),
			'userIp' => $server->get('REMOTE_ADDR'),
			'userBrowser' => $server->get('HTTP_USER_AGENT'),
			'userBrowserLanguage' => $server->get('HTTP_ACCEPT_LANGUAGE'),
		);

		return new JsonModel(array('input' => $data));

		try {
			$entity = $userService->insert($data);
		} catch (\Exception $e) {
			return new JsonModel(array('msg' => $e->getMessage(), 'success' => false));
		}

		return new JsonModel(array('entity' => $entity));

	}

	// alteracao - PUT
	public function update($id, $data) {
		$data['id'] = $id;
		$userService = $this->getServiceLocator()->get("R2User\Service\User");

		if ($data) {
			$user = $userService->update($data);
			if ($user) {
				return new JsonModel(array('data' => array('user' => $user->toConfirmCreate(), 'success' => true)));
			} else {
				return new JsonModel(array('data' => array('success' => false)));
			}
		} else {
			return new JsonModel(array('data' => array('success' => false)));
		}

	}

	// delete - DELETE
	public function delete($id) {
		$userService = $this->getServiceLocator()->get("R2User\Service\User");
		$res = $userService->delete($id);

		if ($res) {
			return new JsonModel(array('data' => array('success' => true)));
		} else {
			return new JsonModel(array('data' => array('success' => false)));
		}

	}
}