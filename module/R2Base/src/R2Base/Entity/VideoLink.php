<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_video_links")
 * @ORM\Entity
 */
class VideoLink {
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
	 * @ORM\Column(name="title", type="string", length=255, nullable=false)
	 */
	private $title;
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
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	/**
	 * @param int $id
	 * @return VideoLink
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	/**
	 * @param string $title
	 * @return VideoLink
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address;
	}
	/**
	 * @param string $address
	 * @return VideoLink
	 */
	public function setAddress($address)
	{
		$this->address = $address;
		return $this;
	}
}