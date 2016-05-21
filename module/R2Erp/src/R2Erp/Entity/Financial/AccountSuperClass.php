<?php
namespace R2Erp\Entity\Financial;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 * @ORM\Table(name="r2_erp_financial_accounts")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * 		{
 *   		"AccountSuperClass" = "AccountSuperClass",
 *     		"BankAccount" = "R2Erp\Entity\Financial\Accounts\Bank",
 *     		"CashierAccount" = "R2Erp\Entity\Financial\Accounts\Cashier",
 *     		"ComissionAccount" = "R2Erp\Entity\Financial\Accounts\Comission",
 *     		"LoanAccount" = "R2Erp\Entity\Financial\Accounts\Loan",
 *     		"FundAccount" = "R2Erp\Entity\Financial\Accounts\Fund",
 *     		"InvestimentAccount" = "R2Erp\Entity\Financial\Accounts\Investiment",
 *      })
 */
class AccountSuperClass {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\OneToOne(targetEntity="R2Erp\Entity\Partner\PartnerSuperClass")
	 * @ORM\JoinColumn(name="partner_id", referencedColumnName="id", nullable=false)
	 **/
	private $partner;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\Currency")
	 * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
	 */
	private $currency;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="amount", type="decimal", precision=8, scale=2, nullable=false)
	 */
	private $amount;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=false)
	 */
	private $description;
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
	 * @return AccountSuperClass
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getPartner() {
		return $this->partner;
	}
	/**
	 * @param mixed $partner
	 * @return AccountSuperClass
	 */
	public function setPartner(\R2Erp\Entity\Partner\PartnerSuperClass $partner) {
		$this->partner = $partner;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCurrency() {
		return $this->currency;
	}
	/**
	 * @param mixed $currency
	 * @return AccountSuperClass
	 */
	public function setCurrency(\R2Base\Entity\Currency $currency) {
		$this->currency = $currency;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getAmount() {
		return $this->amount;
	}
	/**
	 * @param string $amount
	 * @return AccountSuperClass
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	/**
	 * @param string $description
	 * @return AccountSuperClass
	 */
	public function setDescription($description) {
		$this->description = $description;
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
	 * @return AccountSuperClass
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
	 * @return AccountSuperClass
	 *
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt() {
		$this->updatedAt = new \DateTime("now");
		return $this;
	}
}