<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="SnakeNLadder_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="wording", type="string", length=255, unique=true)
     */
    private $wording;

    /**
     * @var int
     *
     * @ORM\Column(name="difficulty", type="integer")
     */
    private $difficulty;

    /**
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="questions")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity="Reply", mappedBy="question")
     */
    private $replies;

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
     * @return Question
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
     * Set difficulty
     *
     * @param integer $difficulty
     *
     * @return Question
     */
    public function setDifficulty($difficulty) {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return int
     */
    public function getDifficulty() {
        return $this->difficulty;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->replies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set theme
     *
     * @param \AppBundle\Entity\Theme $theme
     *
     * @return Question
     */
    public function setTheme(\AppBundle\Entity\Theme $theme = null) {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return \AppBundle\Entity\Theme
     */
    public function getTheme() {
        return $this->theme;
    }

    /**
     * Add reply
     *
     * @param \AppBundle\Entity\Reply $reply
     *
     * @return Question
     */
    public function addReply(\AppBundle\Entity\Reply $reply) {
        $this->replies[] = $reply;

        return $this;
    }

    /**
     * Remove reply
     *
     * @param \AppBundle\Entity\Reply $reply
     */
    public function removeReply(\AppBundle\Entity\Reply $reply) {
        $this->replies->removeElement($reply);
    }

    /**
     * Get replies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplies() {
        return $this->replies;
    }

}
