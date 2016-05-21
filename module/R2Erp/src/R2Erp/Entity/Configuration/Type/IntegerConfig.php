<?php
namespace R2Erp\Entity\Configuration\Type;
use Doctrine\ORM\Mapping as ORM;
use R2Base\Type\ConfigInterface;
use R2Erp\Entity\Configuration\ErpConfigSuperclass;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_erp_integer_configs")
 * @ORM\Entity
 */
class IntegerConfig extends ErpConfigSuperclass implements ConfigInterface {
	/**
	 * @var string
	 *
	 * @ORM\Column(name="value", type="integer", nullable=true)
	 */
	private $value;
	public function __construct(array $options = array()) {
		parent::__construct($options);
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
	/**
	 * Gets the value of value.
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
	/**
	 * Sets the value of value.
	 *
	 * @param string $value the value
	 *
	 * @return self
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}
}