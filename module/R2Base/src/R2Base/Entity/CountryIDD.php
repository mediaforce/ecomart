<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_base_countries_IDD")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\CountryIDD")
 */
class CountryIDD {

	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(name="country_IDD", type="string", length=75, nullable=false)
	 */
	private $countryIDD;

	public function __construct($countryIDD) {
		$this->countryIDD = $countryIDD;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getCountryIDD() {
		return $this->countryIDD;
	}

	/**
	 * @param mixed $countryIDD
	 * @return CountryIDD
	 */
	public function setCountryIDD($countryIDD) {
		$this->countryIDD = $countryIDD;
		return $this;
	}

	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}
}