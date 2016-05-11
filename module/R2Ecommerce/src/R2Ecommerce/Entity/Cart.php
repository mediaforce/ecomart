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
class Cart {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Ecommerce\Entity\ProductCart")
	 * @ORM\JoinTable(name="r2_ecomm_cart_products",
	 *      joinColumns={@ORM\JoinColumn(name="cart_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="product_cart_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $productsCart;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

	public function __construct(array $options = array()) {
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");

		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}