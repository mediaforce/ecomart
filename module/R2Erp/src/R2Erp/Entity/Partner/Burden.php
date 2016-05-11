<?php
namespace R2Erp\Entity\Partner;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="r2_erp_staff_burdens")
 * @ORM\Entity
 */
class Burden {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	public $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=50, nullable=false)
	 */
	public $name;

	public function __construct($name) {
		$this->name = $name;
	}

}