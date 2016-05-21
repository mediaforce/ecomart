<?php
namespace R2Base\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_ratings")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\Product")
 */
class Rating {
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
	 * @ORM\Column(name="rating", type="float", nullable=true)
	 */
	private $rating;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="max_rating", type="float", nullable=true)
	 */
	private $maxRating;
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
	 * @return Rating
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getRating()
	{
		return $this->rating;
	}
	/**
	 * @param string $rating
	 * @return Rating
	 */
	public function setRating($rating)
	{
		$this->rating = $rating;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getMaxRating()
	{
		return $this->maxRating;
	}
	/**
	 * @param string $maxRating
	 * @return Rating
	 */
	public function setMaxRating($maxRating)
	{
		$this->maxRating = $maxRating;
		return $this;
	}
}