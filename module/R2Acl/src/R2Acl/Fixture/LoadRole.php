<?php

namespace R2Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Acl\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {

		$role = new Role;
		$role->setName("Cliente");
		$manager->persist($role);

		$cliente = $manager->getReference('R2Acl\Entity\Role', 1);

		$role = new Role;
		$role->setName("Admin")
			->setParent($cliente);
		$manager->persist($role);

		$manager->flush();

	}

	public function getOrder() {
		return 1;
	}
}
