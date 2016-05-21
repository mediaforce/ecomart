<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_company_categories")
 * @ORM\Entity
 */
class CompanyCategory {
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
	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\CompanyCategory")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 **/
	private $parent;
	public function __construct(array $options = array()) {
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
	 * @return CompanyCategory
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
	 * @return CompanyCategory
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getParent() {
		return $this->parent;
	}
	/**
	 * @param mixed $parent
	 * @return CompanyCategory
	 */
	public function setParent($parent) {
		$this->parent = $parent;
		return $this;
	}
	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}
}