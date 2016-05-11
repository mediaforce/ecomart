<?php

namespace R2Acl\Service;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class Resource extends AbstractService {
	public function __construct(\Doctrine\ORM\EntityManager $em) {
		parent::__construct($em);
		$this->entity = "R2Acl\Entity\Resource";
	}

}
