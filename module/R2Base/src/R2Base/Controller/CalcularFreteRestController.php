<?php



namespace R2Base\Controller;



use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;



class CalcularFreteRestController extends AbstractRestfulController {

	private $em;



	public function __construct($em) {

		$this->em = $em;

		$this->serializer = \JMS\Serializer\SerializerBuilder::create()

			->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))

			->build();

	}



	// Listar - GET

	public function getList() {



	}





	// Retornar o registro especifico - GET

	public function get($id) {



		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method GET is not permitted!'));

	}



	// Insere registro - POST

	public function create($data) {
		
		//return new JsonModel(array('success' => true, 'data' => $data));


		$totalFrete = 0;

		$customer = $this->em->getReference('R2User\Entity\User', $data['_userId']);

		$customer = json_decode($this->serializer->serialize($customer, 'json'), true);

		$CEPorigem = '07140003';

		$CEPdestino = $customer['person']['addresses'][0]['postcode'];

		$servico = $data['_servico'];



		foreach($data['_items'] as $item) {
			if (!$item['_data']['frete']) {

				$peso = $item['_data']['product']['weight'];

				$altura = $item['_data']['product']['dimensionHeight'];

				$largura = $item['_data']['product']['dimensionWidth'];

				$comprimento = $item['_data']['product']['dimensionLength'];



				if ($altura < 2) {

					$altura = 2;

				}

				if ($largura < 11) {

					$largura = 11;

				}

				if ($comprimento < 16) {

					$comprimento = 16;

				}



				if ($peso > 30) {

					$peso = 30;

				}



				$frete = $this->calcFrete($CEPorigem, $CEPdestino, $peso, $comprimento, $altura, $largura, $servico);

				if ($frete) {

					$totalFrete += (float) str_replace(',', '.', $frete->Valor) * $item['_quantity'];

				}

			}

		}


		return new JsonModel(array('success' => true, 'data' => $totalFrete, 'frete' => $frete));



	}



	// alteracao - PUT

	public function update($id, $data) {

		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not permitted!'));

	}



	// delete - DELETE

	public function delete($id) {

		return new JsonModel(array('data' => array(), 'success' => false, 'error_msg' => 'Method POST is not permitted!'));

	}



	private function calcFrete($CEPorigem, $CEPdestino, $peso, $comprimento, $altura, $largura, $servico) {

		$correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$CEPorigem."&sCepDestino=".$CEPdestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&sCdAvisoRecebimento=n&nCdServico=".$servico."&nVlDiametro=0&StrRetorno=xml";

	    try {

	    	$xml = simplexml_load_file($correios);

	    } catch(\Exception $e) {

	    	return new JsonModel(array('success' => false, 'erro' => $e->getMessage() ));

	    }



	    if($xml->cServico->Erro == '0' || $xml->cServico->Erro == '010'){

	        return $xml->cServico;

	    }else{

	        return false;

	    }

	}



}





/*"http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=07140003&sCepDestino=04664020&nVlPeso=15&nCdFormato=1&nVlComprimento=20&nVlAltura=20&nVlLargura=20&sCdMaoPropria=n&sCdAvisoRecebimento=n&nCdServico=40010&nVlDiametro=0&StrRetorno=xml"*/