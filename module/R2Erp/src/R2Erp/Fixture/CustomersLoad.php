<?php

namespace R2Base\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use R2Base\Entity\Address;
use R2Base\Entity\Telephone;
use R2Base\Entity\Person;
use R2Base\Entity\Email;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use R2Erp\Enum\CustomerType;

class CustomersLoad extends AbstractFixture implements OrderedFixtureInterface {

	/**
	 * Load data fixtures with the passed EntityManager
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager) {
		// $city = $this->em->getRepository($this->repository)->findOneBy(array('name' => $this->removeAccents('SÃO PAULO') ));
		// $data = json_decode($this->serializer->serialize($city, 'json'), true);
		// return new JsonModel(array('data' => $data, 'success' => true));
		//
		// $state = $this->em->getRepository($this->repository)->findOneBy(array('code' => 'RS'));
		// $data = json_decode($this->serializer->serialize($state, 'json'), true);
		// return new JsonModel(array('data' => $data, 'success' => true));

		$csvData = file_get_contents("C:/DESENVOLVIMENTO/sites/ecomart/queries/clientes.csv");
		$lines = explode(PHP_EOL, $csvData);
		$enderecos = [];

		$arrayClientes = [];
		$array = [];
		foreach ($lines as $line) {
			$array[] = str_getcsv($line, ';');
		}

		unset($array[0]);

		$usersArray = [];

		foreach($array as $user) {

			if (isset($user[9])) {

				if ($this->validarCPF($user[6])) {
					$documentType = 'CPF';
				} else if ($this->validarCnpj($user[6])) {
					$documentType = 'CNPJ';
				} else {
					$documentType = 'GENÉRICO';
				}

				$estadoCidade = array_map('trim', explode('-', $user[0]));

				$userArray = [
					'user' => new Email(array('address' => $user[7] ) ),
					'password' => $user[8],
					'customerType' => new CustomerType('PHYSICAL'),
					'person' => [
						'name' => $user[1],
						'addresses' => [
							0 => [
								'neighborhood' => $user[3],
								'postcode' => str_pad($user[2], 8, '0', STR_PAD_LEFT),
								'address1' => $user[4],
								'state' => $estadoCidade[0],
								'city' => $estadoCidade[1]
							]
						],
						'telephones' => [
							0 => [
								'number' => preg_replace('/[^0-9]/', '', $user[5])
							]
						]
					],
					'notes' => 'Data Antiga de Cadastro ' . $user[9]
				];

				$addresses = new ArrayCollection();
				foreach ($userArray['person']['addresses'] as $address) {
					$address['state'] = $manager->getRepository('R2Base\Entity\State')->findOneBy(array('code' => $address['state']));
					$address['city'] = $manager->getRepository('R2Base\Entity\City')->findOneBy(array('name' => strtoupper($this->removeAccents($address['city']) )));
					$addresses->add(new Address($address));
				}
				$userArray['person']['addresses'] = $addresses;

				$userArray['role'] = $manager->getReference('R2Acl\Entity\Role', 1);

				$telephones = new ArrayCollection();
				foreach ($userArray['person']['telephones'] as $telephone) {
					$telephones->add(new Telephone($telephone));
				}
				$userArray['person']['telephones'] = $telephones;

				$userArray['person'] = new Person($userArray['person']);

				$entity = new \R2User\Entity\User($userArray);

				$manager->persist($entity);

			}

		}

		$manager->flush();
	}

	private function validarCPF($cpf = null) {

		// Verifica se um número foi informado
		if (empty($cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

		// Verifica se o numero de digitos informados é igual a 11
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' ||
			$cpf == '11111111111' ||
			$cpf == '22222222222' ||
			$cpf == '33333333333' ||
			$cpf == '44444444444' ||
			$cpf == '55555555555' ||
			$cpf == '66666666666' ||
			$cpf == '77777777777' ||
			$cpf == '88888888888' ||
			$cpf == '99999999999') {
			return false;
			// Calcula os digitos verificadores para verificar se o
			// CPF é válido
		} else {

			for ($t = 9; $t < 11; $t++) {

				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}

			return true;
		}
	}

	private function validarCnpj($cnpj) {
		$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		// Valida tamanho
		if (strlen($cnpj) != 14) {
			return false;
		}

		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) {
			return false;
		}

		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
	}

	public function removeAccents($string) {
		$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
		$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
		return str_replace($a, $b, $string);
	}

	public function getOrder() {
		return 3;
	}
}