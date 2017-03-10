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

    function getPawnColor() {
        return $this->pawnColor;
    }

    function getPosition() {
        return $this->position;
    }

    function getUser() {
        return $this->user;
    }

    function setPawnColor($pawnColor) {
        $this->pawnColor = $pawnColor;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function setUser($user) {
        $this->user = $user;
    }

}
