<?php
namespace R2Erp\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_erp_product_departments")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ProductDepartment {
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
	 * @ORM\Column(name="name", type="string", length=30, nullable=false)
	 */
	private $name;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Erp\Entity\Product\ProductCategory", cascade={"persist", "remove"}, orphanRemoval=true)
	 * @ORM\JoinTable(name="r2_erp_product_product_categories",
	 *      joinColumns={@ORM\JoinColumn(name="department_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $categories;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_description", type="string", length=255, nullable=true)
	 */
	private $seoDescription;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_disabled", type="boolean", nullable=true)
	 */
	private $isDisabled;
	public function __construct(array $options = array()) {
		$this->categories = new ArrayCollection();
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * @param int $id
	 * @return ProductCategory
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 * @return ProductCategory
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCategories() {
		return $this->categories;
	}
	/**
	 * @param mixed $categories
	 * @return ProductCategory
	 */
	public function setCategories(ArrayCollection $categories) {
		$this->categories = $categories;
		return $this;
	}
	public function addCategory(\R2Erp\Entity\Product\ProductCategory $category) {
		$this->categories->add($category);
		return $this;
	}
	/**
	 * @return string
	 */
	public function getSeoDescription() {
		return $this->seoDescription;
	}
	/**
	 * @param string $seoDescription
	 * @return ProductCategory
	 */
	public function setSeoDescription($seoDescription) {
		$this->seoDescription = $seoDescription;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getIsDisabled() {
		return $this->isDisabled;
	}
	/**
	 * @param string $isDisabled
	 * @return ProductCategory
	 */
	public function setIsDisabled($isDisabled) {
		$this->isDisabled = $isDisabled;
		return $this;
	}
}