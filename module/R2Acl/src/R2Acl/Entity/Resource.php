<?php

namespace R2Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="r2_acl_resources")
 * @ORM\Entity(repositoryClass="R2Acl\Entity\Repository\Resource")
 */

class Resource {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $name;

	/**
	 * @ORM\Column(type="datetime", name="created_at")
	 */
	protected $createdAt;

	/**
	 * @ORM\Column(type="datetime", name="updated_at")
	 */
	protected $updatedAt;

	public function __construct($options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function getCreatedAt() {
		return $this->createdAt;
	}

	public function setCreatedAt() {
		$this->createdAt = new \Datetime("now");
		return $this;
	}

	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt() {
		$this->createdAt = new \Datetime("now");
		return $this;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods)->extract($this);
	}

}
