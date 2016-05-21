<?php
namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class City extends EntityRepository {
	public function findArray() {
		$cities = $this->findAll();
		$a = array();
		foreach ($cities as $city) {
			$a[$city->getId()]['id'] = $city->getId();
			$a[$city->getId()]['name'] = $city->getName();
			$a[$city->getId()]['state'] = $city->getState()->toArray();
		}

		return $a;
	}

	public function findByState($state_id) {
		$cities = $this->findBy(array('state' => $state_id));
		$a = array();
		foreach ($cities as $city) {
			$a[$city->getId()]['id'] = $city->getId();
			$a[$city->getId()]['name'] = $city->getName();
			$a[$city->getId()]['state'] = $city->getState()->toArray();
		}

		return $a;
	}
}