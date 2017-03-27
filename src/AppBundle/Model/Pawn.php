<?php

namespace AppBundle\Model;

/**
 * Description of Pawn
 *
 * @author FORMATEUR
 */
class Pawn {

    private $pawnColor;
    private $position;
    private $user;

    public function casePosition($oUser) {

// si le jeu démarre : Pion sur la position 0 (correspond à la case 1)
    }

    public function getPawnColor() {
        return $this->pawnColor;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getUser() {
        return $this->user;
    }

    public function setPawnColor($pawnColor) {
        $this->pawnColor = $pawnColor;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function setUser($user) {
        $this->user = $user;
    }

}
