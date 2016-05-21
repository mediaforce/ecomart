<?php

namespace R2Base\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class PaisesEstadosCidadesDDILoad extends AbstractFixture {

	/**
	 * Load data fixtures with the passed EntityManager
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager) {

		$sql = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/queryCountries.sql');
		$stmt = $manager->getConnection()->prepare($sql);
		$stmt->execute();

		$sql = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/queryStates.sql');
		$stmt = $manager->getConnection()->prepare($sql);
		$stmt->execute();

		$sql = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/queryCities01.sql');
		$stmt = $manager->getConnection()->prepare($sql);
		$stmt->execute();

		$sql = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/queryCities02.sql');
		$stmt = $manager->getConnection()->prepare($sql);
		$stmt->execute();

		$sql = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/queryCities03.sql');
		$stmt = $manager->getConnection()->prepare($sql);
		$stmt->execute();

		$sql = file_get_contents('C:/DESENVOLVIMENTO/sites/ecomart/queries/queryCities04.sql');
		$stmt = $manager->getConnection()->prepare($sql);
		$stmt->execute();

	}

	public function getOrder() {
		return 1;
	}
}