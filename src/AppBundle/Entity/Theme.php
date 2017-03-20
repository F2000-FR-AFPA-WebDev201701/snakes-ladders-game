<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ThemeRepository")
 */
class Theme {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="Game", mappedBy="theme")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="wording", type="string", length=50, unique=true)
     */
    private $wording;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="theme")
     */
    private $questions;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set wording
     *
     * @param string $wording
     *
     * @return Theme
     */
    public function setWording($wording) {
        $this->wording = $wording;

        return $this;
    }

    /**
     * Get wording
     *
     * @return string
     */
    public function getWording() {
        return $this->wording;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Theme
     */
    public function addQuestion(\AppBundle\Entity\Question $question) {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\Question $question
     */
    public function removeQuestion(\AppBundle\Entity\Question $question) {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions() {
        return $this->questions;
    }

}
