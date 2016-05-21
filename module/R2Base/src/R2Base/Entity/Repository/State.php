<?php
namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class State extends EntityRepository {
	public function findArray() {
		$states = $this->findAll();
		$a = array();
		foreach ($states as $state) {
			$a[$state->getId()]['id'] = $state->getId();
			$a[$state->getId()]['ibgeCode'] = $state->getIbgeCode();
			$a[$state->getId()]['name'] = $state->getName();
			$a[$state->getId()]['code'] = $state->getCode();
			$a[$state->getId()]['country'] = $state->getCountry()->toArray();
		}

		return $a;
	}
}