<?php
namespace R2Erp\Entity\Financial;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_erp_financial_transferences")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Transference {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Financial\AccountSuperClass")
	 * @ORM\JoinColumn(name="from_account", referencedColumnName="id", nullable=false)
	 **/
	private $fromAccount;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Financial\AccountSuperClass")
	 * @ORM\JoinColumn(name="to_account", referencedColumnName="id", nullable=false)
	 **/
	private $toAccount;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="amount", type="decimal", precision=8, scale=2, nullable=false)
	 */
	private $amount;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="reason", type="text", nullable=false)
	 */
	private $reason;
	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}