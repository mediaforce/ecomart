<?php
namespace R2Base\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_base_video_galeries")
 * @ORM\Entity
 */
class VideoGallery {
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
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Image")
	 * @ORM\JoinTable(name="r2_base_gallery_videos",
	 *      joinColumns={@ORM\JoinColumn(name="video_gallery_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="video_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $videos;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

	public function __construct(array $options = array()) {
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");

		$this->videos = new ArrayCollection();

		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}