<?php

namespace AppBundle\Model;

class Cell {

    const LEVEL_EASY = 0;
    const LEVEL_MEDIUM = 1;
    const LEVEL_HARD = 2;

    private $num;  // cela va être le numéro de case Twig
    private $level;
    private $pawns = [];

    public function getNum() {
        return $this->num;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getPawns() {
        return $this->pawns;
    }

    function setNum($num) {
        $this->num = $num;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function addPawn(Pawn $pawn) {
        $this->pawns[] = $pawn;
    }

    function removePawn(Pawn $pawn) {

        $idxPawn = array_search($pawn, $this->pawns);

        unset($this->pawns[$idxPawn]); // unset va supprimer l'index d'un tableau ou une variable
    }

}
