<?php
namespace R2Erp\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Table(name="r2_erp_combo_products")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ComboProduct {
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
	 * @ORM\Column(name="reference", type="string", length=60, unique=true, nullable=true)
	 */
	private $reference;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=60, nullable=false)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="subtitle", type="string", length=60, nullable=true)
	 */
	private $subtitle;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Erp\Entity\Product\Product")
	 * @ORM\JoinTable(name="r2_erp_combo_product_products",
	 *      joinColumns={@ORM\JoinColumn(name="combo_product_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
	 *      )
	 */
	private $products;

    /**
     * @ORM\ManyToOne(targetEntity="R2Base\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="thumbnail_id", referencedColumnName="id")
     */
    private $thumbnail;

    /**
     * @ORM\OneToOne(targetEntity="R2Erp\Entity\Order\Store\ComboStore", mappedBy="comboProduct", orphanRemoval=true)
     */
    private $comboStore;

	public function __construct(array $options = array()) {
		$this->updatedAt = new \DateTime("now");

		$this->products = new ArrayCollection();

		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param integer $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets the value of reference.
     *
     * @param string $reference the reference
     *
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Gets the value of title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param string $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the value of subtitle.
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Sets the value of subtitle.
     *
     * @param string $subtitle the subtitle
     *
     * @return self
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Sets the joinColumns={@ORM\JoinColumn(name="combo_product_id", referencedColumnName="id")},
inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", unique=true)}
).
     *
     * @param mixed $products the products
     *
     * @return self
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Gets the value of thumbnail.
     *
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Sets the value of thumbnail.
     *
     * @param mixed $thumbnail the thumbnail
     *
     * @return self
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Gets the value of comboStore.
     *
     * @return mixed
     */
    public function getComboStore()
    {
        return $this->comboStore;
    }

    /**
     * Sets the value of comboStore.
     *
     * @param mixed $comboStore the combo store
     *
     * @return self
     */
    public function setComboStore($comboStore)
    {
        $this->comboStore = $comboStore;

        return $this;
    }



    
}