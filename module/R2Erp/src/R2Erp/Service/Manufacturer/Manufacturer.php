<?php

namespace R2Erp\Service\Manufacturer;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class Manufacturer extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Manufacturer\Manufacturer";
	}
}