<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_base_countries")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\Country")
 */
class Country {

	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(name="name", type="string", length=60, nullable=false)
	 */
	private $name;

	/**
	 * @ORM\Column(name="code", type="string", length=10, nullable=false)
	 */
	private $code;

	public function __construct($name, $code) {
		$this->name = $name;
		$this->code = $code;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return Country
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param mixed $code
	 * @return Country
	 */
	public function setCode($code) {
		$this->code = $code;
		return $this;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}
}