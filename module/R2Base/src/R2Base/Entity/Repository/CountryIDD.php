<?php
namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CountryIDD extends EntityRepository {
	public function findArray() {
		$countriesIDD = $this->findAll();
		$a = array();
		foreach ($countriesIDD as $countryIDD) {
			$a[$countryIDD->getId()]['id'] = $countryIDD->getId();
			$a[$countryIDD->getId()]['countryIDD'] = $countryIDD->getCountryIDD();
		}

		return $a;
	}
}