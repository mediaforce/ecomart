<?php
namespace R2Erp\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_erp_mix_products")
 * @ORM\Entity
 */
class MixProduct {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Product\Product")
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
	 **/
	private $product;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="minimum_quantity", type="float", nullable=true)
	 */
	private $minimumQuantity;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="maximum_quantity", type="float", nullable=true)
	 */
	private $maximumQuantity;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="rate_type", type="string", length=20, nullable=false)
	 */
	private $rateType;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="discount", type="decimal", precision=8, scale=2, nullable=false)
	 */
	private $discount;
	public function __construct(array $options = array()) {
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
	 * @return MixProduct
	 */
	public function setId($id) {
		$this->id = $id;
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
	 * @return MixProduct
	 */
	public function setProduct($product) {
		$this->product = $product;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getMinimumQuantity() {
		return $this->minimumQuantity;
	}
	/**
	 * @param string $minimumQuantity
	 * @return MixProduct
	 */
	public function setMinimumQuantity($minimumQuantity) {
		$this->minimumQuantity = $minimumQuantity;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getMaximumQuantity() {
		return $this->maximumQuantity;
	}
	/**
	 * @param string $maximumQuantity
	 * @return MixProduct
	 */
	public function setMaximumQuantity($maximumQuantity) {
		$this->maximumQuantity = $maximumQuantity;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getRateType() {
		return $this->rateType;
	}
	/**
	 * @param string $rateType
	 * @return MixProduct
	 */
	public function setRateType($rateType) {
		$this->rateType = $rateType->value();
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
	 * @return MixProduct
	 */
	public function setDiscount($discount) {
		$this->discount = $discount;
		return $this;
	}
}