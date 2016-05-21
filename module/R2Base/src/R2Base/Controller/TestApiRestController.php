<?php

namespace R2Base\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class TestApiRestController extends AbstractRestfulController {

	// Listar - GET
	public function getList() {
		// TODO fazer
		$data = array();

		return new JsonModel(array('data' => $data, 'entity' => $entity, 'success' => true));
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		// TODO fazer
		$data = array(
			'id' => $id,
		);

		return new JsonModel(array('data' => $data));

	}

	// Insere registro - POST
	public function create($data) {
		$request = $this->getRequest();
		$server = $request->getServer();

		$data['server'] = array(
			'siteUri' => $server->get('REQUEST_URI'),
			'userIp' => $server->get('REMOTE_ADDR'),
			'userBrowser' => $server->get('HTTP_USER_AGENT'),
			'userBrowserLanguage' => $server->get('HTTP_ACCEPT_LANGUAGE'),
		);

		$usuarioService = $this->getServiceLocator()->get("R2Tracker\Service\UserTracker");

		try {
			$entity = $usuarioService->insert($data);
			return new JsonModel(array('entity' => $entity));
		} catch (\Exception $e) {
			return new JsonModel(array('msg' => $e->getMessage(), 'success' => false));
		}

		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not implemented!'));

	}

	// alteracao - PUT
	public function update($id, $data) {
		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not implemented!'));
	}

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not implemented!'));
	}
}

/*		$usuarioService = $this->getServiceLocator()->get("R2User\Service\Usuario");

$request = $this->getRequest();
$server = $request->getServer();

$arrServer = array(
'siteUri' => $server->get('REQUEST_URI'),
'userIp' => $server->get('REMOTE_ADDR'),
'userBrowser' => $server->get('HTTP_USER_AGENT'),
'userBrowserLanguage' => $server->get('HTTP_ACCEPT_LANGUAGE'),
);*/
/*		$usuarioService = $this->getServiceLocator()->get("R2User\Service\Usuario");
$entity = $usuarioService->insert($data);*/