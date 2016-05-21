<?php
namespace R2Erp\Entity\Configuration\Type;
use Doctrine\ORM\Mapping as ORM;
use R2Base\Type\ConfigInterface;
use R2Erp\Entity\Configuration\ErpConfigSuperclass;
/**
 *
 * @ORM\Table(name="r2_erp_string_configs")
 * @ORM\Entity
 */
class StringConfig extends ErpConfigSuperclass implements ConfigInterface {
	/**
	 * @var string
	 *
	 * @ORM\Column(name="value", type="string", nullable=true)
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