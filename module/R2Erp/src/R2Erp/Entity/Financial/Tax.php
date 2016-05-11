<?php
namespace R2Erp\Entity\Financial;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_erp_financial_taxes")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Tax {
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
	 * @ORM\Column(name="name", type="string", length=60, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="rate_type", type="string", length=60, nullable=false)
	 */
	private $rateType;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="rate", type="decimal", precision=4, nullable=false)
	 */
	private $rate;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\State")
	 * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=true)
	 **/
	private $state;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\City")
	 * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
	 **/
	private $city;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="info", type="text", nullable=true)
	 */
	private $info;

	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}