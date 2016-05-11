<?php
namespace R2Erp\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Erp\Entity\Product\ProductCategory;
use R2Erp\Entity\Product\ProductDepartment;

class DepartmentsLoad extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {
		$departments = [
			'PEÇAS DE REPOSIÇÃO' => [
				'PARA ROBÔS',
			],
			'ROBÔS DE LIMPEZA' => [
				'ROBÔ ASPIRADOR',
				'ROBÔ PARA LIMPAR VIDROS',
			],
			'ELETRODOMÉSTICOS' => [
				'COZINHA',
			],
			'FERRAMENTAS',
		];

		foreach ($departments as $key => $department) {

			if (is_int($key)) {
				$productDepartment = new ProductDepartment(array('name' => $department));
			} else {
				$productDepartment = new ProductDepartment(array('name' => $key));
				foreach ($department as $category) {
					$productCategory = new ProductCategory(array('name' => $category));
					$productDepartment->addCategory($productCategory);
				}

			}

			$manager->persist($productDepartment);
		}

		$manager->flush();

	}

	public function getOrder() {
		return 1;
	}
}