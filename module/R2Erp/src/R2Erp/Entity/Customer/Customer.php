<?php
namespace R2Erp\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use R2Erp\Enum\CustomerType;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_erp_customers")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Erp\Entity\Customers\Repository\Customer")
 * @ORM\HasLifecycleCallbacks
 */
class Customer {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\Person")
	 * @ORM\JoinColumn(name="$person_id", referencedColumnName="id", nullable=false)
	 */
	private $person;

	/**
	 * @ORM\ManyToOne(targetEntity="R2User\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\Company")
	 * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
	 */
	private $company;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="credit", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $credit;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="current_credit", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $currentCredit;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="preferred_pay_day", type="datetime", nullable=true)
	 */
	private $preferredPayDay;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="customer_type", type="string", nullable=true)
	 */
	private $customerType;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="notes", type="text", nullable=true)
	 */
	private $notes;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

	public function __construct(array $options = array()) {
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Customer
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPerson() {
		return $this->person;
	}

	/**
	 * @param mixed $person
	 * @return Customer
	 */
	public function setPerson(\R2Base\Entity\Person $person) {
		$this->person = $person;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param mixed $user
	 * @return Customer
	 */
	public function setUser(\R2User\Entity\User $user) {
		$this->user = $user;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * @param mixed $company
	 * @return Customer
	 */
	public function setCompany(\R2Base\Entity\Company $company) {
		$this->company = $company;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCredit() {
		return $this->credit;
	}

	/**
	 * @param string $credit
	 * @return Customer
	 */
	public function setCredit($credit) {
		$this->credit = $credit;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrentCredit() {
		return $this->currentCredit;
	}

	/**
	 * @param string $currentCredit
	 * @return Customer
	 */
	public function setCurrentCredit($currentCredit) {
		$this->currentCredit = $currentCredit;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getPreferredPayDay() {
		return $this->preferredPayDay;
	}

	/**
	 * @param \DateTime $preferredPayDay
	 * @return Customer
	 */
	public function setPreferredPayDay(\DateTime $preferredPayDay) {
		$this->preferredPayDay = $preferredPayDay;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCustomerType() {
		return $this->customerType;
	}

	/**
	 * @param string $customerType
	 * @return Customer
	 */
	public function setCustomerType(CustomerType $customerType) {
		$this->customerType = $customerType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * @param string $notes
	 * @return Customer
	 */
	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 * @return Customer
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * @param \DateTime $updatedAt
	 * @return Customer
	 *
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt() {
		$this->updatedAt = new \DateTime("now");
		return $this;
	}

}
