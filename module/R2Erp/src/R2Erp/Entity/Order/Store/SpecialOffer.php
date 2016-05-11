<?php
namespace R2Erp\Entity\Order\Store;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="r2_erp_product_special_offers")
 * @ORM\Entity
 */
class SpecialOffer {
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
	 * @ORM\Column(name="title", type="string", length=100, nullable=false)
	 */
	private $title;

	/**
	 *
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=false)
	 */
	private $description;

	/**
	 *
	 * @var string
	 *
	 * @ORM\Column(name="rules", type="array", nullable=true)
	 */
	private $rules;

	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}