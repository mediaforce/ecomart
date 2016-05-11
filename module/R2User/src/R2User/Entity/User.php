<?php

namespace R2User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use R2Base\Entity\Email;
use Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Math\Rand;
use Zend\Stdlib\Hydrator;

/**
 * R2Users
 *
 * @ORM\Table(name="r2_users")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2User\Entity\Repository\User")
 */
class User {

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Person", cascade={"persist"})
	 * @ORM\JoinColumn(name="person", referencedColumnName="id", nullable=true)
	 **/
	public $person;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user", type="string", length=255, unique=true, nullable=false)
	 */
	private $user;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="customer_type", type="string", length=20, nullable=false)
	 */
	private $customerType;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=255, nullable=false)
	 */
	private $password;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Acl\Entity\Role")
	 * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
	 **/
	private $role;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="salt", type="string", length=255, nullable=true)
	 */
	private $salt;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="active", type="boolean", nullable=true)
	 */
	private $active;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="activationKey", type="string", length=255, nullable=true)
	 */
	private $activationKey;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="createdAt", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
	 */
	private $updatedAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="notes", type="text", nullable=true)
	 */
	private $notes;

	public function __construct(array $options = array()) {

		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");

		$this->salt = base64_encode(Rand::getBytes(8, true));
		$this->activationKey = md5($this->user . $this->salt);

		(new Hydrator\ClassMethods)->hydrate($options, $this);

	}

	/**
	 * Gets the value of id.
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	public function setPerson(\R2Base\Entity\Person $person) {
		$this->person = $person;
		return $this;
	}

	public function getPerson() {
		return $this->person;
	}

	/**
	 * Gets the value of user.
	 *
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the value of user.
	 *
	 * @param string $user the user
	 *
	 * @return self
	 */
	public function setUser(Email $user) {
		$this->user = $user->getAddress();

		return $this;
	}

	/**
	 * Gets the value of password.
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Sets the value of password.
	 *
	 * @param string $password the password
	 *
	 * @return self
	 */
	public function setPassword($password) {
		$this->password = $this->encryptPassword($password);

		return $this;
	}

	/**
	 * Gets the value of role.
	 *
	 * @return ArrayCollection
	 */
	public function getRole() {
		return $this->role;
	}

	/**
	 * Sets the value of role.
	 *
	 * @param ArrayCollection $role the role
	 *
	 * @return self
	 */
	public function setRole($role) {
		$this->role = $role;

		return $this;
	}


	/**
	 * Gets the value of salt.
	 *
	 * @return string
	 */
	public function getSalt() {
		return $this->salt;
	}

	/**
	 * Gets the value of active.
	 *
	 * @return boolean
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Sets the value of active.
	 *
	 * @param boolean $active the active
	 *
	 * @return self
	 */
	public function setActive($active) {
		$this->active = $active;

		return $this;
	}

	/**
	 * Gets the value of activationKey.
	 *
	 * @return string
	 */
	public function getActivationKey() {
		return $this->activationKey;
	}

	/**
	 * Gets the value of createdAt.
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * Sets the value of createdAt.
	 *
	 * @param \DateTime $createdAt the created at
	 *
	 * @return self
	 */
	public function setCreatedAt(\DateTime $createdAt) {
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Gets the value of updatedAt.
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * Sets the value of updatedAt.
	 *
	 * @param \DateTime $updatedAt the updated at
	 *
	 * @return self
	 *
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt($updatedAt) {
		$this->createdAt = new \Datetime("now");

		return $this;
	}

	/**
	 * Gets the value of notes.
	 *
	 * @return string
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * Sets the value of notes.
	 *
	 * @param string $notes the notes
	 *
	 * @return self
	 */
	public function setNotes($notes) {
		$this->notes = $notes;

		return $this;
	}

	public function encryptPassword($password) {
		return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, strlen($password * 2)));
	}


    /**
     * Gets the value of customerType.
     *
     * @return string
     */
    public function getCustomerType()
    {
        return $this->customerType;
    }

    /**
     * Sets the value of customerType.
     *
     * @param string $customerType the customer type
     *
     * @return self
     */
    public function setCustomerType($customerType)
    {
        $this->customerType = $customerType;

        return $this;
    }
}
