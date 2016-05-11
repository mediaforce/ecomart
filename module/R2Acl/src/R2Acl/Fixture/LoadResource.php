<?php

namespace R2Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Acl\Entity\Resource;

class LoadResource extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {

		$resource = new Resource;
		$resource->setName("Posts");

		$manager->persist($resource);

		$resource = new Resource;
		$resource->setName("Páginas");

		$manager->persist($resource);

		$manager->flush();

	}

	public function getOrder() {
		return 2;
	}
}
