<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="SnakeNLader_game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game {

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPlayerMax", type="integer")
     */
    private $nbPlayerMax;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", nullable=true)
     */
    private $data;    // contiens les données de tout la plateau de jeu C'EST A DIRE : une variable sérialisé du plateau de jeu oBoard (qui pourra être restitué a chaque demande)

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;
//
    /**
     * in oneToMany relation via doctrine, it's the attribute which should contain one information in which we will create the table
     * In this situation players can contain multiple user and user can only have one game. So the information of the relation will be stock in the attribute game de user
     * and not in players de game. The information in players will be automatically uptodate when something is add in user.
     * Doctrine created automatically a getPLayers a removePlayers and AddPlayers  but not set playes for this reason
     * @var int
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="game")
     */
    private $players;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="games")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id")
     */
    private $theme;

    /**
     *
     * @var type
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $gameCreator;

    /**
     * Constructor
     */
    public function __construct() {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();  // création du tableau de joueurs
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Game
     */
    public function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate() {
        return $this->createdDate;
    }

    /**
     * Set nbPlayerMax
     *
     * @param integer $nbPlayerMax
     *
     * @return Game
     */
    public function setNbPlayerMax($nbPlayerMax) {
        $this->nbPlayerMax = $nbPlayerMax;

        return $this;
    }

    /**
     * Get nbPlayerMax
     *
     * @return integer
     */
    public function getNbPlayerMax() {
        return $this->nbPlayerMax;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Game
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Add player
     *
     * @param \AppBundle\Entity\User $player
     *
     * @return Game
     */
    public function addPlayer(\AppBundle\Entity\User $player) {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \AppBundle\Entity\User $player
     */
    public function removePlayer(\AppBundle\Entity\User $player) {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers() {
        return $this->players;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Game
     */
    public function setData($data) {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set theme
     *
     * @param \AppBundle\Entity\Theme $theme
     *
     * @return Game
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
     * Set gameCreator
     *
     * @param \AppBundle\Entity\User $gameCreator
     *
     * @return Game
     */
    public function setGameCreator(\AppBundle\Entity\User $gameCreator = null) {
        $this->gameCreator = $gameCreator;

        return $this;
    }

    /**
     * Get gameCreator
     *
     * @return \AppBundle\Entity\User
     */
    public function getGameCreator() {
        return $this->gameCreator;
    }

}
