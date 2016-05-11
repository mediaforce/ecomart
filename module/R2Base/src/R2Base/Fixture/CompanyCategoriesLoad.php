<?php
namespace R2Erp\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyCategoriesLoad extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {
		$categorias = [
			'Distribuidor Alimentício',
		];
		/*$manager->persist($matrixEntity);
		$manager->flush();*/
	}

	public function getOrder() {
		return 1;
	}
}