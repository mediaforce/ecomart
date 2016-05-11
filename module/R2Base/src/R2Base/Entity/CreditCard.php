<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use R2Base\Enum\CardBrand;
use Zend\Crypt\PublicKey\Rsa;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_base_credit_cards")
 * @ORM\Entity
 */
class CreditCard {
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
	 * @ORM\Column(name="brand", type="string", nullable=false)
	 */
	private $brand;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="number",  type="string", nullable=false)
	 */
	private $number;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="holder", type="string", nullable=false)
	 */
	private $holder;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="validity", type="string", nullable=false)
	 */
	private $validity;

	private $rsa;

	public function __construct() {
		$this->rsa = self::_getRsa();
	}

	private static function _getRsa() {
		return Rsa::factory(array(
			'public_key' => 'public_key.pub',
			'private_key' => 'private_key.pem',
			'pass_phrase' => 'One look could kill',
			'binary_output' => false,
		));
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
	public function getBrand() {
		$rsa = self::_getRsa();
		return $rsa->decrypt($this->brand);
	}

	/**
	 * @param string $brand
	 * @return CreditCard
	 */
	public function setBrand(CardBrand $brand) {
		$this->brand = $this->rsa->encrypt($brand->value());
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNumber() {
		$rsa = self::_getRsa();
		return $rsa->decrypt($this->number);
	}

	/**
	 * @param string $number
	 * @return CreditCard
	 */
	public function setNumber($number) {
		$this->number = $this->rsa->encrypt($number);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHolder() {
		$rsa = self::_getRsa();
		return $rsa->decrypt($this->holder);
	}

	/**
	 * @param string $holder
	 * @return CreditCard
	 */
	public function setHolder($holder) {
		$this->holder = $this->rsa->encrypt($holder);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getValidity() {
		$rsa = self::_getRsa();
		return $rsa->decrypt($this->validity);
	}

	/**
	 * @param string $validity
	 * @return CreditCard
	 */
	public function setValidity($validity) {
		$this->validity = $this->rsa->encrypt($validity->format('Y-m-d H:i:s'));
		return $this;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}
}