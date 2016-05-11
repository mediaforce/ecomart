<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_base_cities")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\City")
 */
class City {

	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 */
	private $id;

	/**
	 * @ORM\Column(name="name", type="string", length=120, nullable=false)
	 */
	private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\State")
	 * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
	 **/
	private $state;

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
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
	 * @return City
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param mixed $state
	 * @return City
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

}