<?php
namespace R2Erp\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_erp_product_discount_coupons")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class DiscountCoupon {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="coupon", type="string", length=50, nullable=false)
	 */
	private $coupon;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="discount", type="float", nullable=false)
	 */
	private $discount;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="start_date", type="datetime", nullable=false)
	 */
	private $startDate;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="finish_date", type="datetime", nullable=true)
	 */
	private $finishDate;

	/**
	 * @var Booleam
	 *
	 * @ORM\Column(name="ilimited_date", type="boolean", nullable=true)
	 */
	private $ilimitedDate;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="quantity", type="integer", nullable=true)
	 */
	private $quantity;

	/**
	 * @var Booleam
	 *
	 * @ORM\Column(name="ilimited_quantity", type="boolean", nullable=true)
	 */
	private $ilimitedQuantity;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Product\Product")
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
	 **/
	private $product;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Product\ProductDepartment")
	 * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=true)
	 **/
	private $department;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="couponType", type="string", length=50, nullable=false)
	 */
	private $couponType;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="to_all", type="boolean", nullable=true)
	 */
	private $toAll;

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
	 * @return DiscountCoupon
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCoupon() {
		return $this->coupon;
	}

	/**
	 * @param string $coupon
	 * @return DiscountCoupon
	 */
	public function setCoupon($coupon) {
		$this->coupon = $coupon;
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
	 * @return DiscountCoupon
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDiscount() {
		return $this->discount;
	}

	/**
	 * @param string $discount
	 * @return DiscountCoupon
	 */
	public function setDiscount($discount) {
		$this->discount = $discount;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @param \DateTime $startDate
	 * @return DiscountCoupon
	 */
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getFinishDate() {
		return $this->finishDate;
	}

	/**
	 * @param \DateTime $finishDate
	 * @return DiscountCoupon
	 */
	public function setFinishDate($finishDate) {
		$this->finishDate = $finishDate;
		return $this;
	}

	/**
	 * @return Booleam
	 */
	public function getIlimitedDate() {
		return $this->ilimitedDate;
	}

	/**
	 * @param Booleam $ilimitedDate
	 * @return DiscountCoupon
	 */
	public function setIlimitedDate($ilimitedDate) {
		$this->ilimitedDate = $ilimitedDate;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * @param string $quantity
	 * @return DiscountCoupon
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return Booleam
	 */
	public function getIlimitedQuantity() {
		return $this->ilimitedQuantity;
	}

	/**
	 * @param Booleam $ilimitedQuantity
	 * @return DiscountCoupon
	 */
	public function setIlimitedQuantity($ilimitedQuantity) {
		$this->ilimitedQuantity = $ilimitedQuantity;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * @param mixed $product
	 * @return DiscountCoupon
	 */
	public function setProduct($product) {
		$this->product = $product;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDepartment() {
		return $this->department;
	}

	/**
	 * @param mixed $department
	 * @return DiscountCoupon
	 */
	public function setDepartment($department) {
		$this->department = $department;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCouponType() {
		return $this->couponType;
	}

	/**
	 * @param string $couponType
	 * @return DiscountCoupon
	 */
	public function setCouponType($couponType) {
		$this->couponType = $couponType->value();
		return $this;
	}

	/**
     * Gets the value of toAll.
     *
     * @return boolean
     */
    public function getToAll()
    {
        return $this->toAll;
    }

    /**
     * Sets the value of toAll.
     *
     * @param boolean $toAll the to all
     *
     * @return self
     */
    public function setToAll($toAll)
    {
        $this->toAll = $toAll;

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
	 * @return DiscountCoupon
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
	 * @return Product
	 *
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt() {
		$this->updatedAt = new \Datetime("now");
		return $this;
	}

}