<?php
namespace R2Cms\Entity\Post\Survey;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_cms_post_survey_answer")
 * @ORM\Entity
 */
class Answer {
	/**
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	private $participant;

	private $question;

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
	public function getParticipant() {
		return $this->participant;
	}

	/**
	 * @param mixed $participant
	 * @return AnswerWithUser
	 */
	public function setParticipant($participant) {
		$this->participant = $participant;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @param mixed $question
	 * @return AnswerWithUser
	 */
	public function setQuestion($question) {
		$this->question = $question;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getChoice() {
		return $this->choice;
	}

	/**
	 * @param mixed $choice
	 * @return AnswerWithUser
	 */
	public function setChoice($choice) {
		$this->choice = $choice;
		return $this;
	}

}