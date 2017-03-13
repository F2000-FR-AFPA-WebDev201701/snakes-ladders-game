<?php

namespace AppBundle\Model;

class Board {

    private $backgroundImage;
    private $aCorrespondances;
    private $cells;
    private $pawns;
    private $dice;
    private $playerTurn;  // index du tableau de pion (qui a été mélanger à la création du plateau et des pions

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

        $this->playerTurn = 0;  // l'objet pion situé dans l'index 0 du tableau d'objet va commencer la partie
    }

    public function selectPlayer($actualPlayer) {
//joueur+1 avec modulo pour gerer la fin du tableau


        $this->playerTurn = $ActualPlayer++;
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

    public function doAction($action) {
        // dump($action);

        switch ($action) {

            case "dice":
                $this->dice = $this->runDice();     // on appel une fonction qui est dans la même class : on aurait pu mettre : Board::runDice();

                break;
        }
    }

    public function checkEndGame($PosLastPlayer) {

        If ($posLastPlayer >= 63) { // jeu terminé   $$$$$$$$$$$$$$$$$$$$
        } else {  // jeu continue
        }
    }

    /**
     * Lancement du dé (1-6)
     * @return int
     */
    public function runDice() {
        return rand(1, 6);  // on affecte une valeur au hasard de 1 à 6  dans l'attribut dice de l'objet plateau oBoard
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

    function getBackgroundImage() {
        return $this->backgroundImage;
    }

    function getACorrespondances() {
        return $this->aCorrespondances;
    }

    function getCells() {
        return $this->cells;
    }

    function getPawns() {
        return $this->pawns;
    }

    function getDice() {
        return $this->dice;
    }

    function getPlayerTurn() {
        return $this->playerTurn;
    }

    function setBackgroundImage($backgroundImage) {
        $this->backgroundImage = $backgroundImage;
    }

    function setACorrespondances($aCorrespondances) {
        $this->aCorrespondances = $aCorrespondances;
    }

    function setCells($cells) {
        $this->cells = $cells;
    }

    function setPawns($pawns) {
        $this->pawns = $pawns;
    }

    function setDice($dice) {
        $this->dice = $dice;
    }

    function setPlayerTurn($playerTurn) {
        $this->playerTurn = $playerTurn;
    }

}
