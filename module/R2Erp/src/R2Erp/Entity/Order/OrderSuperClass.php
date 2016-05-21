<?php
namespace R2Erp\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 * @ORM\Table(name="r2_erp_super_orders")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * 		{
 *   		"OrderSuperClass" = "OrderSuperClass",
 *     		"StoreOrder" = "R2Erp\Entity\Order\Store\Order",
 *     		"SaleOrder" = "R2Erp\Entity\Order\Sale\Order",
 *     		"ExpenseOrder" = "R2Erp\Entity\Order\Expense\Order",
 *       	"RentalOrder" = "R2Erp\Entity\Order\Rental\Order",
 *       	"ProductionOrder" = "R2Erp\Entity\Order\Production\Order",
 *      })
 */
class OrderSuperClass {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="R2User\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 **/
	private $user;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Shipper\Shipper")
	 * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id", nullable=true)
	 **/
	private $shipper;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="cod_rastreio", type="string", length=255, nullable=true)
	 */
	private $codRastreio;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="shipping_type", type="string", length=15, nullable=true)
	 */
	private $shippingType;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="shipping_cost", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $shippingCost;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Order\Expense\Expense")
	 * @ORM\JoinColumn(name="shipping_expense_id", referencedColumnName="id", nullable=true)
	 **/
	private $shippingExpense;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_shipped", type="datetime", nullable=true)
	 */
	private $dateShipped;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="expected_delivery_date", type="datetime", nullable=true)
	 */
	private $expectedDeliveryDate;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_delivered", type="datetime", nullable=true)
	 */
	private $dateDelivered;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="total_order_cost", type="decimal", precision=8, scale=2, nullable=false)
	 */
	private $totalOrderCost;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="discount", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $discount;
	/**
	 * @ORM\OneToMany(targetEntity="R2Erp\Entity\Financial\Payment", mappedBy="superOrder", cascade={"remove"})
	 */
	public $payments;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="payment_type", type="string", length=30, nullable=false)
	 */
	private $paymentType;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="order_reason", type="text", nullable=true)
	 */
	private $orderReason;
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
		$this->payments = new ArrayCollection();
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	/**
	 * @param int $id
	 * @return OrderSuperClass
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}
	/**
	 * @param mixed $user
	 * @return OrderSuperClass
	 */
	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getShipper()
	{
		return $this->shipper;
	}
	/**
	 * @param mixed $shipper
	 * @return OrderSuperClass
	 */
	public function setShipper($shipper)
	{
		$this->shipper = $shipper;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getShippingType()
	{
		return $this->shippingType;
	}
	/**
	 * @param string $shippingType
	 * @return OrderSuperClass
	 */
	public function setShippingType($shippingType)
	{
		$this->shippingType = $shippingType;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getShippingCost()
	{
		return $this->shippingCost;
	}
	/**
	 * @param string $shippingCost
	 * @return OrderSuperClass
	 */
	public function setShippingCost($shippingCost)
	{
		$this->shippingCost = $shippingCost;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getShippingExpense()
	{
		return $this->shippingExpense;
	}
	/**
	 * @param mixed $shippingExpense
	 * @return OrderSuperClass
	 */
	public function setShippingExpense($shippingExpense)
	{
		$this->shippingExpense = $shippingExpense;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getDateShipped()
	{
		return $this->dateShipped;
	}
	/**
	 * @param \DateTime $dateShipped
	 * @return OrderSuperClass
	 */
	public function setDateShipped($dateShipped)
	{
		$this->dateShipped = $dateShipped;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getExpectedDeliveryDate()
	{
		return $this->expectedDeliveryDate;
	}
	/**
	 * @param \DateTime $expectedDeliveryDate
	 * @return OrderSuperClass
	 */
	public function setExpectedDeliveryDate($expectedDeliveryDate)
	{
		$this->expectedDeliveryDate = $expectedDeliveryDate;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getDateDelivered()
	{
		return $this->dateDelivered;
	}
	/**
	 * @param \DateTime $dateDelivered
	 * @return OrderSuperClass
	 */
	public function setDateDelivered($dateDelivered)
	{
		$this->dateDelivered = $dateDelivered;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getTotalOrderCost()
	{
		return $this->totalOrderCost;
	}
	/**
	 * @param string $totalOrderCost
	 * @return OrderSuperClass
	 */
	public function setTotalOrderCost($totalOrderCost)
	{
		$this->totalOrderCost = $totalOrderCost;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getDiscount()
	{
		return $this->discount;
	}
	/**
	 * @param string $discount
	 * @return OrderSuperClass
	 */
	public function setDiscount($discount)
	{
		$this->discount = $discount;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getPaymentType()
	{
		return $this->paymentType;
	}
	/**
	 * @param string $paymentType
	 * @return OrderSuperClass
	 */
	public function setPaymentType($paymentType)
	{
		$this->paymentType = $paymentType;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getOrderReason()
	{
		return $this->orderReason;
	}
	/**
	 * @param string $orderReason
	 * @return OrderSuperClass
	 */
	public function setOrderReason($orderReason)
	{
		$this->orderReason = $orderReason;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
	/**
	 * @param \DateTime $createdAt
	 * @return OrderSuperClass
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
	/**
	 * @param \DateTime $updatedAt
	 * @return OrderSuperClass
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}
    /**
     * Gets the value of payments.
     *
     * @return mixed
     */
    public function getPayments()
    {
        return $this->payments;
    }
    /**
     * Sets the value of payments.
     *
     * @param mixed $payments the payments
     *
     * @return self
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
        return $this;
    }
    /**
     * Gets the value of codRastreio.
     *
     * @return string
     */
    public function getCodRastreio()
    {
        return $this->codRastreio;
    }
    /**
     * Sets the value of codRastreio.
     *
     * @param string $codRastreio the cod rastreio
     *
     * @return self
     */
    public function setCodRastreio($codRastreio)
    {
        $this->codRastreio = $codRastreio;
        return $this;
    }
}