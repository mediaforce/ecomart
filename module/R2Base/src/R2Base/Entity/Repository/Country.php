<?php
namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Country extends EntityRepository {
	public function findArray() {
		$countries = $this->findAll();
		$a = array();
		foreach ($countries as $country) {
			$a[$country->getId()]['id'] = $country->getId();
			$a[$country->getId()]['name'] = $country->getName();
			$a[$country->getId()]['code'] = $country->getCode();
		}

		return $a;
	}
}