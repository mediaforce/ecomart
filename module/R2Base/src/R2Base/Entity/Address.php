<?php
namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_base_addresses")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\Address")
 */
class Address {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\Country")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
	 **/
	private $country;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\State")
	 * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=false)
	 **/
	private $state;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Base\Entity\City")
	 * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
	 **/
	private $city;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="neighborhood", type="string", length=50, nullable=false)
	 */
	private $neighborhood;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="postcode", type="string", length=15, nullable=false)
	 */
	private $postcode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="address1", type="string", length=255, nullable=false)
	 */
	private $address1;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="address2", type="string", length=50, nullable=true)
	 */
	private $address2;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="number",  type="integer", length=15, nullable=true)
	 */
	private $number;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description",  type="string", length=50, nullable=true)
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="address_lat",  type="string", length=15, nullable=true)
	 */
	private $addressLat;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="address_long",  type="string", length=15, nullable=true)
	 */
	private $addressLong;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_address_delivery",  type="boolean", nullable=true)
	 */
	private $isAddressDelivery;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_dddress_invoice",  type="boolean", nullable=true)
	 */
	private $isAddressInvoice;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="notes",  type="text", nullable=true)
	 */
	private $notes;

	/**
	 * @param array $options
	 */
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
	 * @return mixed
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @param mixed $country
	 * @return Address
	 */
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param mixed $state
	 * @return Address
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @param mixed $city
	 * @return Address
	 */
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNeighborhood() {
		return $this->neighborhood;
	}

	/**
	 * @param string $neighborhood
	 * @return Address
	 */
	public function setNeighborhood($neighborhood) {
		$this->neighborhood = $neighborhood;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPostcode() {
		return $this->postcode;
	}

	/**
	 * @param string $postcode
	 * @return Address
	 */
	public function setPostcode($postcode) {
		$this->postcode = $postcode;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddress1() {
		return $this->address1;
	}

	/**
	 * @param string $address1
	 * @return Address
	 */
	public function setAddress1($address1) {
		$this->address1 = $address1;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddress2() {
		return $this->address2;
	}

	/**
	 * @param string $address2
	 * @return Address
	 */
	public function setAddress2($address2) {
		$this->address2 = $address2;
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
	 * @return Address
	 */
	public function setNumber($number) {
		$this->number = $number;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return Address
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddressLat() {
		return $this->addressLat;
	}

	/**
	 * @param string $addressLat
	 * @return Address
	 */
	public function setAddressLat($addressLat) {
		$this->addressLat = $addressLat;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddressLong() {
		return $this->addressLong;
	}

	/**
	 * @param string $addressLong
	 * @return Address
	 */
	public function setAddressLong($addressLong) {
		$this->addressLong = $addressLong;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * @param string $notes
	 * @return Address
	 */
	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function toArray() {

		$address = (new Hydrator\ClassMethods())->extract($this);

		foreach ($address as $key => $value) {
			if ($value instanceOf \Doctrine\Common\Persistence\Proxy) {
				$address[$key] = $value->toArray();
			}
		}
		return $address;
	}

}