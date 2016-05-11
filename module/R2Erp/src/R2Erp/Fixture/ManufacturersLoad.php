<?php
namespace R2Erp\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R2Base\Entity\Company;
use R2Base\Enum\CompanyType;
use R2Erp\Entity\Manufacturer\Manufacturer;

class ManufacturersLoad extends AbstractFixture implements OrderedFixtureInterface {

	public function load(ObjectManager $manager) {
		$manufacturers = [
			[
				'companyName' => 'Ecovacs',
				'companyType' => new CompanyType('MANUFACTURER'),
			],
			[
				'companyName' => 'Paint Zoom',
				'companyType' => new CompanyType('MANUFACTURER'),
			],
			[
				'companyName' => 'Yoda',
				'companyType' => new CompanyType('MANUFACTURER'),
			],
			[
				'companyName' => 'HomeUP',
				'companyType' => new CompanyType('MANUFACTURER'),
			],
			[
				'companyName' => 'Worx',
				'companyType' => new CompanyType('MANUFACTURER'),
			],
		];

		foreach ($manufacturers as $company) {

			$manufacturer = new Manufacturer(array('company' => new Company($company)));
			$manager->persist($manufacturer);
		}

		$manager->flush();

	}

	public function getOrder() {
		return 1;
	}
}