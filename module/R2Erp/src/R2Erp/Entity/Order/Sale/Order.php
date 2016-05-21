<?php
namespace R2Erp\Entity\Order\Sale;
use Doctrine\ORM\Mapping as ORM;
use R2Erp\Entity\Order\OrderSuperClass;
use Doctrine\Common\Collections\ArrayCollection;
/**
 *
 * @ORM\Table(name="r2_erp_sale_orders")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Order extends OrderSuperClass {
	/**
	 * @ORM\ManyToMany(targetEntity="R2Erp\Entity\Order\Sale\Sale", inversedBy="saleOrder", cascade={"persist","remove"})
	 * @ORM\JoinTable(name="r2_erp_sale_order_sales",
	 *   joinColumns={@ORM\JoinColumn(name="order_sale_id", referencedColumnName="id", onDelete="CASCADE")},
	 *   inverseJoinColumns={@ORM\JoinColumn(name="sale_id",
	 *                        referencedColumnName="id", onDelete="cascade")})
	 **/
	private $sales;
	/**
	 * @ORM\ManyToOne(targetEntity="R2User\Entity\User")
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)
	 **/
	private $customer;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Product\DiscountCoupon")
	 * @ORM\JoinColumn(name="coupon_id", referencedColumnName="id", nullable=true)
	 */
	private $coupon;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="tid", type="string", length=255, nullable=true)
	 */
	private $tid;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="pan", type="string", length=255, nullable=true)
	 */
	private $pan;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="authorizationCode", type="string", length=255, nullable=true)
	 */
	private $authorizationCode;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="authorizationMessage", type="string", length=255, nullable=true)
	 */
	private $authorizationMessage;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="authorizationDate", type="string", length=255, nullable=true)
	 */
	private $authorizationDate;
	public function __construct(array $options = array()) {
		$this->sales = new ArrayCollection();
		parent::__construct($options);
	}
	/**
	 * @return mixed
	 */
	public function getSales()
	{
		return $this->sales;
	}
	/**
	 * @param mixed $sales
	 * @return Order
	 */
	public function setSales($sales)
	{
		$this->sales = $sales;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCustomer()
	{
		return $this->customer;
	}
	/**
	 * @param mixed $customer
	 * @return Order
	 */
	public function setCustomer($customer)
	{
		$this->customer = $customer;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCoupon()
	{
		return $this->coupon;
	}
	/**
	 * @param mixed $coupon
	 * @return Order
	 */
	public function setCoupon($coupon)
	{
		$this->coupon = $coupon;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getTid()
	{
		return $this->tid;
	}
	/**
	 * @param string $tid
	 * @return Order
	 */
	public function setTid($tid)
	{
		$this->tid = $tid;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getPan()
	{
		return $this->pan;
	}
	/**
	 * @param string $pan
	 * @return Order
	 */
	public function setPan($pan)
	{
		$this->pan = $pan;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getAuthorizationCode()
	{
		return $this->authorizationCode;
	}
	/**
	 * @param string $authorizationCode
	 * @return Order
	 */
	public function setAuthorizationCode($authorizationCode)
	{
		$this->authorizationCode = $authorizationCode;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getAuthorizationMessage()
	{
		return $this->authorizationMessage;
	}
	/**
	 * @param string $authorizationMessage
	 * @return Order
	 */
	public function setAuthorizationMessage($authorizationMessage)
	{
		$this->authorizationMessage = $authorizationMessage;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getAuthorizationDate()
	{
		return $this->authorizationDate;
	}
	/**
	 * @param string $authorizationDate
	 * @return Order
	 */
	public function setAuthorizationDate($authorizationDate)
	{
		$this->authorizationDate = $authorizationDate;
		return $this;
	}
}