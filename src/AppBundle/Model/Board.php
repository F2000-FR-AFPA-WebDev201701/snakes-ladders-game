<?php

namespace AppBundle\Model;

class Board {

    private $backgroundImage;
    private $aCorrespondances;
    private $cells;
    private $pawns;
    private $dice;
    private $playerTurn;

    // setup du jeu se fait avec le constructeur (car le plateau ne va se construire qu'une fois):
    public function __construct($aoUsers) {
        $this->cells = [];
        $this->pawns = [];
        $this->aCorrespondances = [
            56, 57, 58, 59, 60, 61, 62, 63,
            55, 54, 53, 52, 51, 50, 49, 48,
            40, 41, 42, 43, 44, 45, 46, 47,
            39, 38, 37, 36, 35, 34, 33, 32,
            24, 25, 26, 27, 28, 29, 30, 31,
            23, 22, 21, 20, 19, 18, 17, 16,
            8, 9, 10, 11, 12, 13, 14, 15,
            7, 6, 5, 4, 3, 2, 1, 0
        ];


        // init. du plateau
        // init. des joueurs
        foreach ($aoUsers as $oUser) {
            $aP = new Pawn($oUser);
            $aP->setPosition(0);

            $this->pawns[] = $aP;
        }
        shuffle($this->pawns);
    }

    public function selectPlayer($iLastPlayer, $iNbPlayer) {
//joueur+1 avec modulo pour gerer la fin du tableau
        if (!$sLastPlayer) { // si pas de LastPlayer nous sommes à la début de partie, définition aléatoire du premier joueur qui va jouer parmis le nombre de player
            $iPlayerMin = 1;
            $iPlayerMax = $iNbPlayer;
            $iPlayerTurn = rand($iPlayerMin, $iPlayerMax);
        } else {
            $iPlayerTurn = $iLastPlayer++;
        }

        return $iPlayerTurn;
    }

    public function checkEndGame($PosLastPlayer) {

        If ($PosLastPlayer == 63) { // jeu terminé
        } else {  // jeu continue
        }
    }

    /**
     * Lancement du dé (1-6)
     * @return int
     */
    public function launchDice() {
        return rand(1, 6);
    }

    public function movePawn() {

    }

    /**
     * @param int $num :   numéro de la case
     * @return int : numéro PHP de la case
     */
    public function getNumCell($num) {
        return array_search($num, $this->aCorrespondances);
    }

    /**
     * @param int $idx : numéro PHP de la case
     * @return int : numéro de la case
     */
    public function getIdxCell($idx) {
        return $this->cells[$idx];
    }

}
