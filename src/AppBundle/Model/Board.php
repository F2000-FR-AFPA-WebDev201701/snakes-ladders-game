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
        for ($i = 0; $i <= 63; $i++) {  // création des 64 cases objets
            $iNumCell = $this->getNumCell($i);  // $this->corr..[$i] // Verif fonction de Pierre

            $oCell = new Cell();
            $oCell->setNum($iNumCell);
            $oCell->setLevel(LEVEL_EASY);
            $oCell->setPawns('1');  // Pawns sert a savoir combien de pion se trouve sur une cellule

            $this->cells[] = $oCell;
        }

        // init. des joueurs
        foreach ($aoUsers as $oUser) {  // pour chaque utilisateur (qui joue?) creer un nouveau Pawn avec une position à 0
            $oPawn = new Pawn($oUser);
            $oPawn->setPosition(0);
            $oPawn->setColor('blue');
            $oPawn->setUser($oUser);

            $this->pawns[] = $oPawn;
        }
        shuffle($this->pawns);  // va mélanger le tableau d'objet des pions pour déterminer au hasard qui va commencer
    }

    public function selectPlayer($ActualPlayer) {
//joueur+1 avec modulo pour gerer la fin du tableau
        if ($ActualPlayer <= /$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ a finir

        return $ActualPlayer++;




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
