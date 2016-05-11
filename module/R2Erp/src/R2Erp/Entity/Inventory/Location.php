<?php
namespace R2Erp\Entity\Inventory;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="r2_erp_inventory_locations")
 * @ORM\Entity
 */
class Location {
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
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Inventory\Warehouse")
	 * @ORM\JoinColumn(name="warehouse_id", referencedColumnName="id", nullable=false)
	 **/
	private $warehouse;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Inventory\Location")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=false)
	 **/
	private $parent;

	public function __construct(array $options = array()) {

	}
}