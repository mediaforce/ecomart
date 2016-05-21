<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_social_networks")
 * @ORM\Entity
 */
class SocialNetwork {
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
	 * @ORM\Column(name="address", type="string", length=255, nullable=false)
	 */
	private $address;
	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
	/**
	 * Gets the value of id.
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Gets the value of endereco.
	 *
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}
	/**
	 * Sets the value of endereco.
	 *
	 * @param string $address the endereco
	 *
	 * @return self
	 */
	public function setAddress($address) {
		$this->address = $address;
	}
	public function toArray() {
		return (new Hydrator\ClassMethods())->extract($this);
	}
}