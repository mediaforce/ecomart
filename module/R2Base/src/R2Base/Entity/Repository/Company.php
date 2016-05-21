<?php
namespace R2Base\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Company extends EntityRepository {
	public function findArray() {
		$companies = $this->findAll();
		$a = array();
		foreach ($companies as $company) {
			$a[$company->getId()]['companyType'] = $company->getCompanyType();
			$a[$company->getId()]['tradingName'] = $company->getTradingName();
			$a[$company->getId()]['companyName'] = $company->getCompanyName();
			$a[$company->getId()]['category'] = $company->getCategory()->toArray();
			$a[$company->getId()]['website'] = $company->getWebsite();
			$a[$company->getId()]['documents'] = $company->getDocuments();
			$a[$company->getId()]['emails'] = $company->getEmails();
			$a[$company->getId()]['socialNetworks'] = $company->getSocialNetworks();
			$a[$company->getId()]['telephones'] = $company->getTelephones();
			$a[$company->getId()]['address'] = $company->getAddress();
			$a[$company->getId()]['description'] = $company->getDescription();
			$a[$company->getId()]['logo'] = $company->getLogo();
			$a[$company->getId()]['goodTags'] = $company->getGoodTags();
			$a[$company->getId()]['notes'] = $company->getNotes();
			$a[$company->getId()]['foundationDate'] = $company->getFoundationDate();
			$a[$company->getId()]['createdAt'] = $company->getCreatedAt();
			$a[$company->getId()]['updatedAt'] = $company->getUpdatedAt();
		}

		return $a;
	}
}