<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_base_states")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\State")
 */
class State {

	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(name="ibge_code", type="integer", nullable=false)
	 */
	private $ibgeCode;

	/**
	 * @ORM\Column(name="name", type="string", length=75, nullable=false)
	 */
	private $name;

	/**
	 * @ORM\Column(name="code", type="string", length=5, nullable=false)
	 */
	private $code;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\Country")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
	 **/
	private $country;

	public function __construct() {

	}

	/**
	 * Gets the value of id.
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Gets the value of ibgeCode.
	 *
	 * @return mixed
	 */
	public function getIbgeCode() {
		return $this->ibgeCode;
	}

	/**
	 * Sets the value of ibgeCode.
	 *
	 * @param mixed $ibgeCode the ibge code
	 *
	 * @return self
	 */
	public function setIbgeCode($ibgeCode) {
		$this->ibgeCode = $ibgeCode;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return State
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
	 * @return State
	 */
	public function setCode($code) {
		$this->code = $code;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @param mixed $country
	 * @return State
	 */
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}

}