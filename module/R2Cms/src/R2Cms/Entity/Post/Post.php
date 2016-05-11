<?php
namespace R2Cms\Entity\Post;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_cms_post")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * 		{
 *   		"R2Cms\Entity\Post\Post" = "Post",
 *     		"R2Cms\Entity\Post\Survey\Survey" = "R2Cms\Entity\Post\Survey\Survey"
 *      })
 */
class Post {
	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="post_title", type="string", length=100, nullable=false)
	 */
	private $title;

	// TODO (retornar um json? Talvez. Precisa de analise...)
	/**
	 *
	 * @var string
	 *
	 * @ORM\Column(name="nome", type="text", nullable=false)
	 */
	private $content;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Cms\Entity\Post\PostMeta")
	 * @ORM\JoinTable(name="r2_cms_post_metas",
	 *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="meta_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $metas;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Cms\Entity\Post\Post")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	private $parent;

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

	/**
	 * @ORM\OneToOne(targetEntity="R2User\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 **/
	private $updatedLastBy;

	public function __construct($options = array()) {
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");

		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}

	public function getDiscriminator() {
		return get_class($this);
	}

	public function getType() {
		$type = explode('\\', get_class($this));

		return end($type);
	}

}