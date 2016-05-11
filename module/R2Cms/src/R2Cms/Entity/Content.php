<?php
namespace R2Cms\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_cms_contents")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Content {

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\OneToOne(targetEntity="R2Cms\Entity\Post\Post")
	 * @ORM\JoinColumn(name="body_id", referencedColumnName="id", nullable=true)
	 **/
	private $post;

	/**
	 * @ORM\OneToOne(targetEntity="R2User\Entity\User")
	 * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
	 **/
	private $author;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content_status", type="string", length=10, nullable=true)
	 */
	private $contentStatus;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content_type", type="string", length=20, nullable=true)
	 */
	private $contentType;

	public function __construct($options = array()) {
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
	public function getPost() {
		return $this->post;
	}

	/**
	 * @param mixed $post
	 * @return Content
	 */
	public function setPost($post) {
		$this->post = $post;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @param mixed $author
	 * @return Content
	 */
	public function setAuthor($author) {
		$this->author = $author;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentStatus() {
		return $this->contentStatus;
	}

	/**
	 * @param string $contentStatus
	 * @return Content
	 */
	public function setContentStatus($contentStatus) {
		$this->contentStatus = $contentStatus;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 * @param string $contentType
	 * @return Content
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
		return $this;
	}

}
