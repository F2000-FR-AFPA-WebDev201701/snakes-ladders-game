<?php

namespace AppBundle\Model;

class Board {

    private $backgroundImage;
    private $cells;
    private $pawns;
    private $dice;
    private $playerTurn;

    // setup du jeu se fait avec le constructeur (car le plateau ne va se construire qu'une fois):
    public function __construct($aoUsers) {
        $this->cells = [];
        $this->pawns = [];

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

}
