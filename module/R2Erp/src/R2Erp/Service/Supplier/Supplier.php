<?php
namespace R2Erp\Service;

use R2Base\Service\AbstractService;

class Supplier extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em, SmtpTransport $transport, $view) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Supplier\Supplier";
		$this->transport = $transport;
		$this->view = $view;
	}

	public function insert(array $data) {

	}
}