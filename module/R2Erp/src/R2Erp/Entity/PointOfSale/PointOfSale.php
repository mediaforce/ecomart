<?php
namespace R2Erp\Entity\PointOfSale;

class PointOfSale {
	private $id;
	private $sessions; // sale_orders...total of each method of paymment
	private $startedCheckOut; // contagem inicial
	private $finishedCheckOut; // contagem final
	private $withdraw; //transference
	private $income;
}