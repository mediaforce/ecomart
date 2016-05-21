<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_currencies")
 * @ORM\Entity
 */
class Currency {
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
	 * @ORM\Column(name="name", type="string", nullable=false)
	 */
	private $name;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="symbol", type="string", nullable=false)
	 */
	private $symbol;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="rate", type="decimal", precision=8, nullable=false)
	 */
	private $rate;
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
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 * @return Currency
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getSymbol() {
		return $this->symbol;
	}
	/**
	 * @param string $symbol
	 * @return Currency
	 */
	public function setSymbol($symbol) {
		$this->symbol = $symbol;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getRate() {
		return $this->rate;
	}
	/**
	 * @param string $rate
	 * @return Currency
	 */
	public function setRate($rate) {
		$this->rate = $rate;
		return $this;
	}
	public function toArray() {
		$entity = (new Hydrator\ClassMethods())->extract($this);
		return $entity;
	}
}