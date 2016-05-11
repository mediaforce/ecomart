<?php
namespace R2Crm\Entity;

class Trade {
	private $id;

	private $title;
	private $description;

	private $company;
	private $contact;
	private $responsible;
	private $totalValue;
	private $probability;
	private $endDate;

	private $products;
	private $services;
	private $sourceTags;

	private $stage;
	private $status;

	private $fact;
	private $type;

	private $createdBy;
	private $modifiedBy;

	private $permitedUsers;

	private $standardRoles;

	private $createdAt;
	private $updatedAt;
}