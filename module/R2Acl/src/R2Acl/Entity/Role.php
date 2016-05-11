<?php

namespace R2Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="r2_acl_roles")
 * @ORM\Entity(repositoryClass="R2Acl\Entity\Repository\Role")
 */

class Role {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Acl\Entity\Role")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	protected $parent;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $name;

	/**
	 * @ORM\Column(type="boolean", name="is_admin")
	 * @var boolean
	 */
	protected $isAdmin;

	/**
	 * @ORM\Column(type="datetime", name="created_at")
	 */
	protected $createdAt;

	/**
	 * @ORM\Column(type="datetime", name="updated_at")
	 */
	protected $updatedAt;

	public function __construct($options = array()) {
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
		$this->isAdmin = 0;
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getParent() {
		return $this->parent;
	}

	public function setParent($parent) {
		$this->parent = $parent;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function getIsAdmin() {
		return $this->isAdmin;
	}

	public function isAdmin() {
		return $this->isAdmin;
	}

	public function setIsAdmin($isAdmin) {
		$this->isAdmin = $isAdmin;
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

	public function __toString() {
		return $this->name;
	}

	public function toArray() {
		if (isset($this->parent)) {
			$parent = $this->parent->getId();
		} else {
			$parent = false;
		}

		return array(
			'id' => $this->id,
			'name' => $this->name,
			'isAdmin' => $this->isAdmin,
			'parent' => $parent,
		);
	}

}
