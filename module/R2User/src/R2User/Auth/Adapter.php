<?php

namespace R2User\Auth;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class Adapter implements AdapterInterface {
	protected $em;
	protected $username;
	protected $password;
	protected $role;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getRole() {
		return $this->role;
	}

	public function setRole() {
		$this->role = $role;
	}

	public function authenticate() {
		$repository = $this->em->getRepository("R2User\Entity\User");
		$response = $repository->findByUserAndPassword($this->getUsername(), $this->getPassword());

		if ($response['result']) {
			return new Result(Result::SUCCESS, array('user' => $response['user']), array('OK'));
		} else {
			return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('error' => $response['error']));
		}

	}

}
