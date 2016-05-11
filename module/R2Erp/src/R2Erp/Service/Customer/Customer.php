<?php

namespace R2Erp\Service\Customer;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class Customer extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Customer\Customer";
	}

	// TODO FAZER FILTROS E VALIDAÇÕES!!!!!!!!!!!!!!!!!!!!
	public function insert(array $data) {
		$entity = parent::insert($data);

		return $entity;

	}

	public function update(array $data) {
		$entity = parent::update($data);

		return $data;

	}

}