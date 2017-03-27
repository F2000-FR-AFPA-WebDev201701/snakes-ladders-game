<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="SnakeNLader_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User {

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
     * @ORM\Column(name="emailLogin", type="string", length=255, unique=true)
     * @Assert\Email(
     *     message = "l'email '{{ value }}' n'est pas un email valide",
     *     checkMX = true
     * )
     *
     */
    private $emailLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 6,
     * max = 255,
     * minMessage = "le mot de passe doit avoir au moins {{ limit }} caractères",
     * maxMessage = "le mot de passe doit avoir plus de  {{ limit }} caractères"
     * )
     *
     *
     *
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="icone", type="string", length=255)
     * @Assert\File(
     *   maxSize = "1024k",
     *   mimeTypes = {"image/gif", "image/jpeg", "image/png"},
     *   mimeTypesMessage = "SVP restez correct et téléchargez une image correct. Merci!"
     * )
     *
     */
    private $icone;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 6,
     * max = 30,
     * minMessage = "le pseudo doit avoir au moins {{ limit }} caractères",
     * maxMessage = "le pseudo doit avoir plus de  {{ limit }} caractères"
     * )
     *
     *
     *
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 2,
     * max = 255,
     * minMessage = "le prénom doit avoir au moins {{ limit }} caractères",
     * maxMessage = "le prénom doit avoir plus de  {{ limit }} caractères"
     * )
     *
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 2,
     * max = 50,
     * minMessage = "le nom doit avoir au moins {{ limit }} caractères",
     * maxMessage = "le nom doit avoir plus de  {{ limit }} caractères"
     * )
     *
     *
     */
    private $lastname;

    /**
     * in a relation manytoOne means that user can be correalted to only one game. So users is the one which will contzin the information
     * Then in this relation a column game_id will be created in the users database and will automatically complete the information of players in Game
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="players")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game;

    /** SetId temporaire pour test
     *
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
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
     * Set emailLogin
     *
     * @param string $emailLogin
     *
     * @return User
     */
    public function setEmailLogin($emailLogin) {
        $this->emailLogin = $emailLogin;

        return $this;
    }

    /**
     * Get emailLogin
     *
     * @return string
     */
    public function getEmailLogin() {
        return $this->emailLogin;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set icone
     *
     * @param string $icone
     *
     * @return User
     */
    public function setIcone($icone) {
        $this->icone = $icone;

        return $this;
    }

    /**
     * Get icone
     *
     * @return string
     */
    public function getIcone() {
        return $this->icone;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return User
     */
    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo() {
        return $this->pseudo;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return User
     */
    public function setGame(\AppBundle\Entity\Game $game = null) {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppBundle\Entity\Game
     */
    public function getGame() {
        return $this->game;
    }

}
