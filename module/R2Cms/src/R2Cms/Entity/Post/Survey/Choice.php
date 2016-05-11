<?php
namespace R2Cms\Entity\Post\Survey;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_cms_post_survey_choice")
 * @ORM\Entity
 */
class Choice {
	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(name="choice", type="text", nullable=false)
	 */
	private $choice;

	public function __construct($options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
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
	public function getChoice() {
		return $this->choice;
	}

	/**
	 * @param mixed $choice
	 * @return Choice
	 */
	public function setChoice($choice) {
		$this->choice = $choice;
		return $this;
	}

}