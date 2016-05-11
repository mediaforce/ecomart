<?php

namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Person extends EntityRepository {

	public function findArray() {

		$people = $this->findAll();
		$a = array();
		foreach ($people as $person) {
			$a[$person->getId()]['id'] = $person->getId();
/*			$a[$user->getId()]['name'] = $user->getName();
$a[$user->getId()]['sobrename'] = $user->getSobrename();
$a[$user->getId()]['sexo'] = $user->getSexo();
$a[$user->getId()]['nacionalidade'] = $user->getNacionalidade();
$a[$user->getId()]['foto'] = $user->getFoto();
$a[$user->getId()]['documentos'] = $user->getDocumentos();
$a[$user->getId()]['redesSociais'] = $user->getRedesSociais();
$a[$user->getId()]['emails'] = $user->getEmails();
$a[$user->getId()]['telefones'] = $user->getTelefones();
$a[$user->getId()]['pais'] = $user->getPais();
$a[$user->getId()]['estado'] = $user->getEstado();
$a[$user->getId()]['cidade'] = $user->getCidade();
$a[$user->getId()]['bairro'] = $user->getBairro();
$a[$user->getId()]['cep'] = $user->getCep();
$a[$user->getId()]['logradouro'] = $user->getLogradouro();
$a[$user->getId()]['complemento'] = $user->getComplemento();
$a[$user->getId()]['numero'] = $user->getNumero();
$a[$user->getId()]['cartoesCredito'] = $user->getCartoesCredito();
$a[$user->getId()]['user'] = $user->getuser();
$a[$user->getId()]['password'] = $user->getPassword();
$a[$user->getId()]['salt'] = $user->getSalt();
$a[$user->getId()]['active'] = $user->getActive();
$a[$user->getId()]['activationKey'] = $user->getActivationKey();
$a[$user->getId()]['createdAt'] = $user->getCreatedAt();
$a[$user->getId()]['updatedAt'] = $user->getUpdatedAt();*/

		}

		return $a;
	}

}
