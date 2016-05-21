<?php

namespace R2Erp\Service\Financial;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class Payment extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Financial\Payment";
	}


}