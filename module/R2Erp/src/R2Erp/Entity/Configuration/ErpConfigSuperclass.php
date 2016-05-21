<?php
namespace R2Erp\Entity\Configuration;
use Doctrine\ORM\Mapping as ORM;
use R2Base\Type\ConfigInterface;
use Zend\Stdlib\Hydrator;
/**
 * @ORM\Table(name="r2_erp_configs")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Erp\Entity\Configuration\Repository\ErpConfigSuperclass")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * 		{
 *   		"ErpConfigSuperclass" = "ErpConfigSuperclass",
 *     		"ArrayConfig" = "R2Erp\Entity\Configuration\Type\ArrayConfig",
 *     		"BooleanConfig" = "R2Erp\Entity\Configuration\Type\BooleanConfig",
 *     		"FloatConfig" = "R2Erp\Entity\Configuration\Type\FloatConfig",
 *     		"IntegerConfig" = "R2Erp\Entity\Configuration\Type\IntegerConfig",
 *     		"StringConfig" = "R2Erp\Entity\Configuration\Type\StringConfig",
 *     		"TextConfig" = "R2Erp\Entity\Configuration\Type\TextConfig",
 *      })
 */
class ErpConfigSuperclass implements ConfigInterface {
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
	 * @ORM\Column(name="name", type="string", length=20, nullable=true)
	 */
	private $name;
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
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 * @return ErpConfigSuperclass
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getValue() {
		return null;
	}
	public function toArray() {
		$entity = (new Hydrator\ClassMethods())->extract($this);
		return $entity;
	}
}