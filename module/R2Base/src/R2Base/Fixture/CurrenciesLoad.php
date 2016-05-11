<?php
namespace R2Base\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Base\Entity\Currency;

class CurrenciesLoad extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {

		$currency = new Currency(array('id' => 986, 'name' => 'Real/BRL', 'symbol' => 'R$', 'rate' => 1));

		$manager->persist($currency);

		$manager->flush();

	}

	public function getOrder() {
		return 1;
	}
}