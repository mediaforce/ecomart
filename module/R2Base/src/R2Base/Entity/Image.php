<?php

namespace R2Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_base_images")
 * @ORM\Entity
 */
class Image {
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
	 * @ORM\Column(name="path", type="string", length=255, nullable=true)
	 */
	private $path;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_cover", type="boolean", length=255, nullable=true)
	 */
	private $isCover;

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
	 * @return Image
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * @param string $path
	 * @return Image
	 */
	public function setPath($path) {
		$this->path = $path;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getIsCover() {
		return $this->isCover;
	}

	/**
	 * @param string $isCover
	 * @return Image
	 */
	public function setIsCover($isCover) {
		$this->isCover = $isCover;
		return $this;
	}

}