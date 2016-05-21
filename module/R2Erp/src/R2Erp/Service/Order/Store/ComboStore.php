<?php

namespace R2Erp\Service\Order\Store;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class ComboStore extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Order\Store\ComboStore";
	}

}