<?php
namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Address extends EntityRepository {
	public function findArray() {
		$addresses = $this->findAll();
		$a = array();
		foreach ($addresses as $address) {
			$a[$address->getId()]['country'] = $address->getCountry();
			$a[$address->getId()]['state'] = $address->getState()->toArray();
			$a[$address->getId()]['city'] = $address->getCity()->toArray();
			$a[$address->getId()]['neighborhood'] = $address->getNeighborhood();
			$a[$address->getId()]['postcode'] = $address->getPostcode();
			$a[$address->getId()]['address1'] = $address->getAddress1();
			$a[$address->getId()]['address2'] = $address->getAddress2();
			$a[$address->getId()]['number'] = $address->getNumber();
			$a[$address->getId()]['description'] = $address->getDescription();
			$a[$address->getId()]['addressLat'] = $address->getAddressLat();
			$a[$address->getId()]['addressLong'] = $address->getAddressLong();
		}

		return $a;
	}
}