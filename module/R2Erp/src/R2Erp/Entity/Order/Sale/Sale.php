<?php
namespace R2Erp\Entity\Order\Sale;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_erp_sale_sales")
 * @ORM\Entity
 */
class Sale {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Erp\Entity\Order\Sale\Order", mappedBy="sales")
	 **/
	private $saleOrder;
	 

	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Order\Store\Store")
	 * @ORM\JoinColumn(name="store_id", referencedColumnName="id", nullable=true)
	 **/
	private $store;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Order\Store\ComboStore")
	 * @ORM\JoinColumn(name="combo_store_id", referencedColumnName="id", nullable=true)
	 **/
	private $comboStore;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="quantity", type="float", nullable=false)
	 */
	private $quantity;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="unit_price", type="decimal", precision=8, scale=2, nullable=false)
	 */
	private $unitPrice;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="total_price", type="decimal", precision=8, scale=2, nullable=false)
	 */
	private $totalPrice;

	public function __construct(array $options = array()) {
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
	 * @return Sale
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStore()
	{
		return $this->store;
	}

	/**
	 * @param mixed $store
	 * @return Sale
	 */
	public function setStore($store)
	{
		$this->store = $store;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getComboStore()
	{
		return $this->comboStore;
	}

	/**
	 * @param mixed $comboStore
	 * @return Sale
	 */
	public function setComboStore($comboStore)
	{
		$this->comboStore = $comboStore;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param string $quantity
	 * @return Sale
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUnitPrice()
	{
		return $this->unitPrice;
	}

	/**
	 * @param string $unitPrice
	 * @return Sale
	 */
	public function setUnitPrice($unitPrice)
	{
		$this->unitPrice = $unitPrice;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTotalPrice()
	{
		return $this->totalPrice;
	}

	/**
	 * @param string $totalPrice
	 * @return Sale
	 */
	public function setTotalPrice($totalPrice)
	{
		$this->totalPrice = $totalPrice;
		return $this;
	}




    /**
     * Gets the value of saleOrder.
     *
     * @return mixed
     */
    public function getSaleOrder()
    {
        return $this->saleOrder;
    }

    /**
     * Sets the value of saleOrder.
     *
     * @param mixed $saleOrder the sale order
     *
     * @return self
     */
    public function setSaleOrder($saleOrder)
    {
        $this->saleOrder = $saleOrder;

        return $this;
    }
}