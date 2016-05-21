<?php
namespace R2Acl\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="r2_acl_privileges")
 * @ORM\Entity(repositoryClass="R2Acl\Entity\Repository\Privilege")
 */
class Privilege {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Acl\Entity\Role")
	 * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
	 */
	protected $role;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Acl\Entity\Resource")
	 * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
	 */
	protected $resource;
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
	public function getRole() {
		return $this->role;
	}
	public function setRole($role) {
		$this->role = $role;
		return $this;
	}
	public function getResource() {
		return $this->resource;
	}
	public function setResource($resource) {
		$this->resource = $resource;
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
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'role' => $this->role->getId(),
			'resource' => $this->resource->getId(),
		);
	}
}