<?php
namespace R2Cms\Entity\Post\Survey;

use Doctrine\ORM\Mapping as ORM;
use R2Cms\Entity\Post\Post;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="r2_cms_post_survey")
 * @ORM\Entity
 */
class Survey extends Post {
	/**
	 * @ORM\Column(name="description", type="text", nullable=false)
	 */
	private $description;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Cms\Entity\Post\Survey\Question")
	 * @ORM\JoinTable(name="r2_cms_survey_questions",
	 *      joinColumns={@ORM\JoinColumn(name="survey_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $questions;

	/**
	 * @ORM\ManyToMany(targetEntity="R2Cms\Entity\Post\Survey\Answer")
	 * @ORM\JoinTable(name="r2_cms_survey_answers",
	 *      joinColumns={@ORM\JoinColumn(name="survey_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="answer_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $answers;

	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 * @return Survey
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getQuestions() {
		return $this->questions;
	}

	/**
	 * @param mixed $questions
	 * @return Survey
	 */
	public function setQuestions($questions) {
		$this->questions = $questions;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAnswers() {
		return $this->answers;
	}

	/**
	 * @param mixed $answers
	 * @return Survey
	 */
	public function setAnswers($answers) {
		$this->answers = $answers;
		return $this;
	}
}