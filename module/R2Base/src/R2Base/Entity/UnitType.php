<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_unit_types")
 * @ORM\Entity
 */
class UnitType {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\Column(name="unit", type="string", length=15, nullable=false)
	 */
	private $unit;
	/**
	 * @ORM\Column(name="type", type="string", length=15, nullable=false)
	 */
	private $type;
	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}