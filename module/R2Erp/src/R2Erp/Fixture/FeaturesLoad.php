<?php
namespace R2Erp\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Erp\Entity\Product\FeatureGroup;
use R2Erp\Entity\Product\FeatureTag;

class FeaturesLoad extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {
		$featuresGroup = [
			'VOLTAGEM' => [
				'110v',
				'220v',
				'Bivolt',
			],
			'COR' => [
				'AZUL',
				'VERDE',
				'AMARELO',
				'VERMELHO',
				'BRANCO',
				'CINZA',
				'PRETO',
			],
			'TIPO' => [
				'PAR',
				'UNITÁRIO',
			],
		];

		foreach ($featuresGroup as $key => $features) {
			$featureGroup = new FeatureGroup(array('name' => $key));
			$manager->persist($featureGroup);

			foreach ($features as $value) {
				$feature = new FeatureTag(array('group' => $featureGroup, 'value' => $value));
				$manager->persist($feature);
			}

		}

		$manager->flush();

	}

	public function getOrder() {
		return 1;
	}
}