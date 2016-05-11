<?php

namespace R2Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Acl\Entity\Privilege;

class LoadPrivilege extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {

		$role1 = $manager->getReference('R2Acl\Entity\Role', 1);
		$resource1 = $manager->getReference('R2Acl\Entity\Resource', 1);

		$role2 = $manager->getReference('R2Acl\Entity\Role', 2);
		$resource2 = $manager->getReference('R2Acl\Entity\Resource', 2);

		$privilege = new Privilege;
		$privilege->setName("Visualizar")
			->setRole($role1)
			->setResource($resource1);
		$manager->persist($privilege);

		$manager->flush();

	}

	public function getOrder() {
		return 3;
	}
}
