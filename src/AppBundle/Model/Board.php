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
        for ($i = 0; $i <= 63; $i++) {  // création des 64 cases objets
            $iNumCell = $this->getNumCell($i);  // $this->corr..[$i] // Verif fonction de Pierre

            $oCell = new Cell();
            $oCell->setNum($iNumCell);
            $oCell->setLevel(Cell::LEVEL_EASY);

            $this->cells[] = $oCell;
        }

        // init. des joueurs
        foreach ($aoUsers as $oUser) {  // pour chaque utilisateur (qui joue?) creer un nouveau Pawn avec une position à 0
            $oPawn = new Pawn($oUser);
            $oPawn->setPosition(0); // numéro de la case twig
            $oPawn->setPawnColor('blue');
            $oPawn->setUser($oUser);

            $this->pawns[] = $oPawn;

            // Position de départ
            $Idx = $this->getIdxCell(0);
            $oCell = $this->cells[$Idx];
            $oCell->addPawn($oPawn); // ajouter un pion au tableau de pion de la cellule
        }
        shuffle($this->pawns);  // va mélanger le tableau d'objet des pions pour déterminer au hasard qui va commencer
    }

    public function selectPlayer() {
//joueur+1 avec modulo pour gerer la fin du tableau

        $ActualPlayer = 0;

        return $ActualPlayer;
    }

    /* if ($ActualPlayer <= /$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ a finir

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
     */

    public function checkEndGame($PosLastPlayer) {

        If ($posLastPlayer >= 63) { // jeu terminé   $$$$$$$$$$$$$$$$$$$$
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
     * @param int $idx :   index PHP de la case
     * @return int : numéro de la case
     */
    public function getNumCell($idx) {
        return $this->aCorrespondances[$idx];
    }

    /**
     * @param int $num : numéro  de la case
     * @return int : indeex PHP de la case
     */
    public function getIdxCell($num) {
        return array_search($num, $this->aCorrespondances);
    }

}
