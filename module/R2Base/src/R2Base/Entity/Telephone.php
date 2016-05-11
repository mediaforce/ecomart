<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use R2Base\Enum\MobileMNO;
use R2Base\Enum\TelephoneType;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_base_telephones")
 * @ORM\Entity
 */
class Telephone {
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
	 * @ORM\Column(name="telephone_type", type="string", length=50, nullable=true)
	 */
	private $telephoneType;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="number", type="string", length=50, nullable=false)
	 */
	private $number;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="mobile_MNO", type="string", length=50, nullable=true)
	 */
	private $mobileMNO;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="speak_with", type="string", length=50, nullable=true)
	 */
	private $speakWith;

	/**
	 * @var text
	 *
	 * @ORM\Column(name="notes", type="string", length=50, nullable=true)
	 */
	private $notes;

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
	public function getTelephoneType() {
		return $this->telephoneType;
	}

	/**
	 * @param string $telephoneType
	 * @return Telephone
	 */
	public function setTelephoneType(TelephoneType $telephoneType) {
		$this->telephoneType = $telephoneType->value();
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * @param string $number
	 * @return Telephone
	 */
	public function setNumber($number) {
		$this->number = $number;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMobileMNO() {
		return $this->mobileMNO;
	}

	/**
	 * @param string $mobileMNO
	 * @return Telephone
	 */
	public function setMobileMNO(MobileMNO $mobileMNO) {
		$this->mobileMNO = $mobileMNO->value();
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSpeakWith() {
		return $this->speakWith;
	}

	/**
	 * @param string $speakWith
	 * @return Telephone
	 */
	public function setSpeakWith($speakWith) {
		$this->speakWith = $speakWith;
		return $this;
	}

	/**
	 * @return text
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * @param text $notes
	 * @return Telephone
	 */
	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}

}