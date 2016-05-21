<?php

namespace R2Erp\Service\Product;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class DiscountCoupon extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Product\DiscountCoupon";
	}

}