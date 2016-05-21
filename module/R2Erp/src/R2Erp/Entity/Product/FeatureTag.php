<?php
namespace R2Erp\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_erp_product_feature_tags")
 * @ORM\Entity
 */
class FeatureTag {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Product\FeatureGroup")
	 * @ORM\JoinColumn(name="feature_group_id", referencedColumnName="id", nullable=false)
	 **/
	private $group;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="value", type="string", length=50, nullable=false)
	 */
	private $value;
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
	 * @return FeatureTag
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getGroup()
	{
		return $this->group;
	}
	/**
	 * @param mixed $group
	 * @return FeatureTag
	 */
	public function setGroup(\R2Erp\Entity\Product\FeatureGroup $group)
	{
		$this->group = $group;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
	/**
	 * @param string $value
	 * @return FeatureTag
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}
}