<?php 
namespace R2Erp\Controller\Checkout;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class TestReturnRestController extends AbstractRestfulController
{
	public function getList() {
		if (file_exists('testreturn.data')) {
			try {
				$data = implode(",", $_GET['transaction_id']);
				$fileData = fopen('testreturn.data', 'a+');
				fwrite($fileData, $data."\n");
				fclose($fileData);
			} catch(\Exception $e) {
				return new JsonModel(array('success' => false));	
			}
			return new JsonModel(array('success' => true));	
		}

		return new JsonModel(array('success' => false, 'dir' => getcwd()));		
	}

	// Retornar o registro especifico - GET
	public function get($id) {
		return new JsonModel(array('success' => false));
	}

	// Insere registro - POST
	public function create($data) {
		try {
			$data = implode(",", $data);
			$fileData = fopen('testreturn.data', 'a+');
			fwrite($fileData, $data."\n");
			fclose($fileData);
		} catch(\Exception $e) {
			return new JsonModel(array('success' => false));	
		}


		
		return new JsonModel(array('success' => true));	

	}

	// alteracao - PUT
	public function update($id, $data) {

		return new JsonModel(array('success' => false));
	}

	// delete - DELETE
	public function delete($id) {
		return new JsonModel(array('success' => false));
	}
}