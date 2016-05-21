<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_articles")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\Product")
 */
class Article {
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
     * @ORM\ManyToOne(targetEntity="R2Base\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="thumbnail_id", referencedColumnName="id")
     */
	private $thumbnail;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="article", type="text", nullable=true)
	 */
	private $article;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo", type="text", nullable=true)
	 */
	private $seo;
	/**
	 * @ORM\ManyToOne(targetEntity="R2User\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 **/
	private $author;
	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}