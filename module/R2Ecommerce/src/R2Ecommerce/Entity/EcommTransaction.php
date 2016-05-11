<?php
namespace R2Ecommerce\Entity;

/**
 * R2Users
 *
 * @ORM\Table(name="r2_carts")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2Ecommerce\Entity\Repository\Cart")
 */
class EcommTransaction {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\OneToOne(targetEntity="R2Erp\Entity\Cart")
	 * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", nullable=true)
	 **/
	private $cart;

	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Address")
	 * @ORM\JoinColumn(name="address_delivery_id", referencedColumnName="id", nullable=true)
	 **/
	private $addressDelivery;

	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Address")
	 * @ORM\JoinColumn(name="address_invoice_id", referencedColumnName="id", nullable=true)
	 **/
	private $addressInvoice;

	/**
	 * @ORM\OneToOne(targetEntity="R2Erp\Entity\Sale\FactSale")
	 * @ORM\JoinColumn(name="order_sale", referencedColumnName="id", nullable=true)
	 **/
	private $orderSale;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="status", type="string", length=100, nullable=false)
	 */
	private $status;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_started", type="datetime", nullable=false)
	 */
	private $dateStarted;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_completed", type="datetime", nullable=false)
	 */
	private $dateCompleted;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="discount_cupom_code", type="string", length=255, nullable=false)
	 */
	private $discountCupomCode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="notes", type="text", nullable=true)
	 */
	private $notes;

	public function __construct(array $options = array()) {

	}
}