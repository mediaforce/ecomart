<?php
namespace R2Cms\Entity\Post\Survey;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_cms_post_survey_question")
 * @ORM\Entity
 */
class Question {
	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @ORM\Column(name="question", type="text", nullable=false)
	 */
	private $question;

	private $choices;

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
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @param mixed $question
	 * @return Question
	 */
	public function setQuestion($question) {
		$this->question = $question;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getChoices() {
		return $this->choices;
	}

	/**
	 * @param mixed $choices
	 * @return Question
	 */
	public function setChoices($choices) {
		$this->choices = $choices;
		return $this;
	}

}