<?php
namespace R2Erp\Entity\Order\Store;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_erp_combo_products_stores")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ComboStore {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\OneToOne(targetEntity="R2Erp\Entity\Product\ComboProduct", inversedBy="comboStore")
	 * @ORM\JoinColumn(name="combo_product_id", referencedColumnName="id")
	 */
	private $comboProduct;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="quantity", type="float", nullable=true)
	 */
	private $quantity;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="minimal_qtde_on_stock", type="float", nullable=true)
	 */
	private $minimalQtdeOnStock;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="unit_cost", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $unitCost;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="unit_price", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $unitPrice;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="unit_discount_price", type="decimal", precision=8, scale=2, nullable=true)
	 */
	private $unitDiscountPrice;
	/**
	 * If value is true to sell with the discount price
	 * @var Boolean
	 *
	 * @ORM\Column(name="sell_discount_price", type="boolean", nullable=true)
	 */
	private $sellDiscountPrice;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="sell_no_shipping", type="boolean", nullable=true)
	 */
	private $sellNoShipping;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="to_sell", type="boolean", nullable=true)
	 */
	private $toSell;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;
	public function __construct(array $options = array()) {
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
	 * @return Store
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getComboProduct() {
		return $this->comboProduct;
	}
	/**
	 * @param mixed $comboProduct
	 * @return Store
	 */
	public function setComboProduct($comboProduct) {
		$this->comboProduct = $comboProduct;
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
	 * @return Store
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getMinimalQtdeOnStock() {
		return $this->minimalQtdeOnStock;
	}
	/**
	 * @param string $minimalQtdeOnStock
	 * @return Store
	 */
	public function setMinimalQtdeOnStock($minimalQtdeOnStock) {
		$this->minimalQtdeOnStock = $minimalQtdeOnStock;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getInventory() {
		return $this->inventory;
	}
	/**
	 * @param mixed $inventory
	 * @return Store
	 */
	public function setInventory($inventory) {
		$this->inventory = $inventory;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getUnitCost() {
		return $this->unitCost;
	}
	/**
	 * @param string $unitCost
	 * @return Store
	 */
	public function setUnitCost($unitCost) {
		$this->unitCost = $unitCost;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getUnitPrice() {
		return $this->unitPrice;
	}
	/**
	 * @param string $unitPrice
	 * @return Store
	 */
	public function setUnitPrice($unitPrice) {
		$this->unitPrice = $unitPrice;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getUnitDiscountPrice() {
		return $this->unitDiscountPrice;
	}
	/**
	 * @param string $unitDiscountPrice
	 * @return Store
	 */
	public function setUnitDiscountPrice($unitDiscountPrice) {
		$this->unitDiscountPrice = $unitDiscountPrice;
		return $this;
	}
	/**
	 * @return boolean
	 */
	public function isSellDiscountPrice() {
		return $this->sellDiscountPrice;
	}
	/**
	 * @param boolean $sellDiscountPrice
	 * @return Store
	 */
	public function setSellDiscountPrice($sellDiscountPrice) {
		$this->sellDiscountPrice = $sellDiscountPrice;
		return $this;
	}
	/**
     * Gets the value of sellNoShipping.
     *
     * @return string
     */
    public function getSellNoShipping()
    {
        return $this->sellNoShipping;
    }
    /**
     * Sets the value of sellNoShipping.
     *
     * @param string $sellNoShipping the sell no shipping
     *
     * @return self
     */
    public function setSellNoShipping($sellNoShipping)
    {
        $this->sellNoShipping = $sellNoShipping;
        return $this;
    }
	/**
	 * @return string
	 */
	public function getToSell() {
		return $this->ToSell;
	}
	/**
	 * @param string $storeStatus
	 * @return Store
	 */
	public function setToSell($ToSell) {
		$this->ToSell = $ToSell;
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
	public function setUpdatedAt() {
		$this->updatedAt = new \Datetime("now");
		return $this;
	}
}