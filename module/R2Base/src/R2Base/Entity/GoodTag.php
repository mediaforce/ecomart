<?php
namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_base_good_tags")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class GoodTag {
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
	 * @ORM\Column(name="name", type="string", length=30, nullable=true)
	 */
	private $name;

	public function __construct($name) {
		$this->name = $name;
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
	 */
	public function setName($name) {
		$this->name = $name;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}

}