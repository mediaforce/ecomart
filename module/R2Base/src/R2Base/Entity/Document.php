<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use R2Base\Type\DocumentTypeInterface;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_documents")
 * @ORM\Entity
 */
class Document {
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
	 * @ORM\Column(name="document_type", type="string", length=50, nullable=false)
	 */
	private $documentType;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="field1", type="string", length=25, nullable=false)
	 */
	private $field1;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="field2", type="string", length=25, nullable=true)
	 */
	private $field2;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="field3", type="string", length=25, nullable=true)
	 */
	private $field3;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="field4", type="string", length=25, nullable=true)
	 */
	private $field4;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="field5", type="string", length=25, nullable=true)
	 */
	private $field5;
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
	 * @return string
	 */
	public function getDocumentType() {
		return $this->documentType;
	}
	/**
	 * @param string $documentType
	 * @return Document
	 */
	public function setDocumentType($documentType) {
		$this->documentType = $documentType;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getField1() {
		return $this->field1;
	}
	/**
	 * @param string $field1
	 * @return Document
	 */
	public function setField1($field1) {
		$this->field1 = $field1;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getField2() {
		return $this->field2;
	}
	/**
	 * @param string $field2
	 * @return Document
	 */
	public function setField2($field2) {
		$this->field2 = $field2;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getField3() {
		return $this->field3;
	}
	/**
	 * @param string $field3
	 * @return Document
	 */
	public function setField3($field3) {
		$this->field3 = $field3;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getField4() {
		return $this->field4;
	}
	/**
	 * @param string $field4
	 * @return Document
	 */
	public function setField4($field4) {
		$this->field4 = $field4;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getField5() {
		return $this->field5;
	}
	/**
	 * @param string $field5
	 * @return Document
	 */
	public function setField5($field5) {
		$this->field5 = $field5;
		return $this;
	}
	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}
}