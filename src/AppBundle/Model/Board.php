<?php

namespace AppBundle\Model;

class Board {

    const MSG_GAMEBEGINS = 'La partie commence.';
    const MSG_YOURTURN = 'A toi de Jouer __name__ ! <br/>Lance le Dé !';
    const MSG_WRONGANSWER = 'Mauvaise Réponse __name__ !<br/>Tu recules de __nbcase__ case(s) !';
    const MSG_RIGHTANSWER = 'Bonne Réponse __name__ !<br/>Tu avances de __nbcase__ case(s) !';

    /* Variables constantes. Chaque variable constante correspond à une situation de jeu.
     * Il y a six situations de jeu. __name__ et __nbcase__ pourront être remplacés
     * respectivement par "le nom du joueur" et le "nombre de cases à reculer".
     */

    private $backgroundImage;
    private $aCorrespondances;
    private $cells;
    private $pawns;
    private $dice;
    private $question;
    private $clickOnDice;

    /**
     * Index du tableau de pion (qui a été mélanger à la création du plateau et des pions
     * @var type
     */
    private $playerTurn;
// index du tableau de pion (qui a été mélanger à la création du plateau et des pions

    /**
     * Cet attribut $messagesToPlayers est utilisé en même temps que les variables constantes (plus haut).
     * @var array
     */
    private $messagesToPlayers;

    /**
     * Setup du jeu se fait avec le constructeur (car le plateau ne va se construire qu'une fois):
     * @param array $aoUsers
     */
    public function __construct() {
        $this->cells = [];
        $this->pawns = [];
        $this->messagesToPlayers = [];
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

            // Attribution difficultés des cases
            If (($i == 0 || $i == 4 || $i == 9 || $i == 11 || $i == 14 || $i == 16 || $i == 26 || $i == 29 || $i == 31 || $i == 17) || $i == 55 || ($i > 34 && $i < 40) || ($i > 43 && $i < 47) || ($i > 53 && $i < 56)) {
                $oCell->setLevel(Cell::LEVEL_MEDIUM);
            } else if (($i == 42 || $i == 43 || $i == 34 || $i == 32 || $i == 23 || $i == 20 ) || ($i > 56 && $i < 65) || ($i > 46 && $i < 54) || ($i > 25 && $i < 28)) {
                $oCell->setLevel(Cell::LEVEL_EASY);
            } else {
                $oCell->setLevel(Cell::LEVEL_HARD);
            }

            $this->cells[] = $oCell;
        }
    }

    public function initPlayers($aoUsers) {
        $aColors = ['white', 'brown', 'blue', 'black'];
        shuffle($aColors);

        // init. des joueurs
        foreach ($aoUsers as $idx => $oUser) {  // pour chaque utilisateur (qui joue?) creer un nouveau Pawn avec une position à 0
            $oPawn = new Pawn($oUser);
            $oPawn->setPosition(0); // numéro de la case twig
            $oPawn->setPawnColor($aColors[$idx]);
            $oPawn->setUser($oUser);
            $this->pawns[] = $oPawn;

            // Position de départ
            $Idx = $this->getIdxCell(0);
            $oCell = $this->cells[$Idx];
            $oCell->addPawn($oPawn); // ajouter un pion au tableau de pion de la cellule
        }
        shuffle($this->pawns);  // va mélanger le tableau d'objet des pions pour déterminer au hasard qui va commencer

        $this->playerTurn = 0;  // l'objet pion situé dans l'index 0 du tableau d'objet va commencer la partie
        // La Partie Commence !
        $msgPlayerTurn = str_replace(
                '__name__', $this->getCurrentPseudo(), Board::MSG_YOURTURN
        );

        $this->messagesToPlayers = [Board::MSG_GAMEBEGINS, $msgPlayerTurn];
    }

    public function nextPlayer() {
        $this->playerTurn = $this->playerTurn + 1;
//        test si on est arrivé à la fin du tableau
        if ($this->playerTurn >= count($this->pawns)) {
            $this->playerTurn = 0;
        }

        // On reset la question
        $this->question = null;

        $msgPlayerTurn = str_replace(
                '__name__', $this->getCurrentPseudo(), Board::MSG_YOURTURN
        );
        $this->messagesToPlayers[] = $msgPlayerTurn;
    }

    public function doAction($idUser, $action, $oRepo, $oTheme) {
//      Verification que le joueur qui a cliqué (idUser) est bien l'Id du User qui est sencés jouer (playerTurn)
        if (!$this->isCurrentPlayer($idUser)) {
            return;
        }

//        Recuperer le pion du user si celui ci est bon
        $oActualPawn = $this->pawns[$this->playerTurn];


        switch ($action) {
            case "dice":

                //Désactivation du dès si une réponse à une question doit être donnée
                if (($this->getQuestion()) != Null) {
                    // $$$$$$$$$$$$ dessous adapter le commentaire avec méthode Pierre
                    // $this->setComment('Attention, répondez à la question avant de pouvoir relancer le dès !');
                    break;
                }


                $this->dice = $this->runDice();     // on appel une fonction qui est dans la même class : on aurait pu mettre : Board::runDice();
//                  Changer dans pawn du user en cours sa nouvelle position et changer le tabeau cell avec les nouveuax pions integré
                $this->movePawn($oActualPawn);     // On appel la fonction qui retournera la nouvelle position du pion en prennant en compte la valeur du dés
//                    modifier le tableau de cells avec les nouveaux pions
                $idx = $this->getIdxCell($oActualPawn->getPosition());
                $oCell = $this->cells[$idx];


                // Affichage de la question et des trois réponses proposées :
                $aoQuestions = $oRepo->findBy([
                    'theme' => $oTheme,
                    'difficulty' => $oCell->getLevel(),
                ]);
                shuffle($aoQuestions);
                $this->question = $aoQuestions[0];
                break;
        }
    }

//    }

    /**
     * Lancement du dé (1-6)
     * @return int
     */
    public function runDice() {
        return rand(1, 6);  // on affecte une valeur au hasard de 1 à 6  dans l'attribut dice de l'objet plateau oBoard
    }

// This function take as input the oActualPawn and will return :
// the new position value of the pawn (in twig case) and change the tab cells with the new position of the pawn inside
    public function movePawn($oPawn) {
        // Remove into the cell the place where the pawn were
        $iOldCell = $this->getIdxCell($oPawn->getPosition());
        $this->cells[$iOldCell]->removePawn($oPawn);

        // Calcul of the new position
        $iLastPosition = $oPawn->getPosition();
        $iDiceValue = $this->getDice();
        $iNewPosition = $iLastPosition + $iDiceValue;
        if ($iNewPosition >= 63) {     // si la nouvelle position du pion dépasse 63, la position du pion restera à 63
            $iNewPosition = 63;
        }
        $this->pawns[$this->playerTurn]->setPosition($iNewPosition);
        // Add into the new cell the pawn
        $iNewCell = $this->getIdxCell($this->pawns[$this->playerTurn]->getPosition());
        $this->cells[$iNewCell]->addPawn($this->pawns[$this->playerTurn]);

        return;
    }

    public function doQuizzAction($idUser, $oRepo, $idQuestion, $idReply) {
        if (!$this->isCurrentPlayer($idUser)) {
            return;
        }

        // préparation des paramètres à envoyer pour bonus/malus
        $oPawn = $this->pawns[$this->playerTurn];
        $posOPawn = $this->pawns[$this->playerTurn]->getPosition();
        $level = $this->cells[$this->getIdxCell($posOPawn)]->getLevel();

        $oQuestion = $oRepo->find($idQuestion);
        $aoReplies = $oQuestion->getReplies();

        $oGoodReply = null;
        foreach ($aoReplies as $oReply) {
            if ($oReply->getValid()) {
                $oGoodReply = $oReply;
                break;
            }
        }

        if ($oGoodReply->getId() == $idReply) {
            $this->bonusPawn($oPawn, $level);
        } else {
            $this->malusPawn($oPawn, $level);
        }

        $this->nextPlayer();
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

    public function getBackgroundImage() {
        return $this->backgroundImage;
    }

    public function getACorrespondances() {
        return $this->aCorrespondances;
    }

    public function getCells() {
        return $this->cells;
    }

    public function getPawns() {
        return $this->pawns;
    }

    public function getDice() {
        return $this->dice;
    }

    public function getPlayerTurn() {
        return $this->playerTurn;
    }

    public function setBackgroundImage($backgroundImage) {
        $this->backgroundImage = $backgroundImage;
    }

    public function setACorrespondances($aCorrespondances) {
        $this->aCorrespondances = $aCorrespondances;
    }

    public function setCells($cells) {
        $this->cells = $cells;
    }

    public function setPawns($pawns) {
        $this->pawns = $pawns;
    }

    public function setDice($dice) {
        $this->dice = $dice;
    }

    public function setPlayerTurn($playerTurn) {
        $this->playerTurn = $playerTurn;
    }

    public function isEndGame() {
        $bEndOfGame = 0;

        if (count($this->cells[self::getIdxCell(63)]->getPawns()) != 0) {
            $bEndOfGame = 1; // si un pion arrive dans la case 63 on retourne un booléen = 1 pour dire que la partie est finie
            // attribut "statut" de l'objet oGame = KO => fair dans le GameControleur
        }
        return $bEndOfGame;
    }

    public function malusPawn($oPawn, $level) {
        // Level = niveau de difficulté de la case/question
        $nbCaseMalus = 0;

        switch ($level) {
            case 0:
                $nbCaseMalus = 4;
                break;
            case 1:
                $nbCaseMalus = 2;
                break;
            case 2:
                $nbCaseMalus = 1;
                break;
        }

        $wrongAnswer = str_replace(
                array('__name__', '__nbcase__'), array($this->getCurrentPseudo(), $nbCaseMalus), Board::MSG_WRONGANSWER
        );
        $this->messagesToPlayers = [$wrongAnswer];

        // On enlève le pion de la case actuelle
        $iOldCell = $this->getIdxCell($oPawn->getPosition());
        $this->cells[$iOldCell]->removePawn($oPawn);

        // calcul de la nouvelle position
        if (($oPawn->getPosition()) < $nbCaseMalus) {
            $oPawn->setPosition(0);
        } else {
            $oPawn->setPosition(($oPawn->getPosition()) - $nbCaseMalus);
        }

        // on ajoute le pion sur la nouvelle case
        $iNewCell = $this->getIdxCell($oPawn->getPosition());
        $this->cells[$iNewCell]->addPawn($oPawn);

        return;
    }

    public function bonusPawn($oPawn, $level) {
        // Level = niveau de difficulté de la case/question
        $nbCaseBonus = 0;

        switch ($level) {
            case 0:
                $nbCaseBonus = 1;
                break;
            case 1:
                $nbCaseBonus = 2;
                break;
            case 2:
                $nbCaseBonus = 4;
                break;
        }

        $rightAnswer = str_replace(
                array('__name__', '__nbcase__'), array($this->getCurrentPseudo(), $nbCaseBonus), Board::MSG_RIGHTANSWER
        );
        $this->messagesToPlayers = [$rightAnswer];

        $iOldCell = $this->getIdxCell($oPawn->getPosition());
        $this->cells[$iOldCell]->removePawn($oPawn);

        // calcul de la nouvelle position
        if ((($oPawn->getPosition()) + $nbCaseBonus) > 63) {
            $oPawn->setPosition(63);
        } else {
            $oPawn->setPosition(($oPawn->getPosition()) + $nbCaseBonus);
        }

        // on ajoute le pion sur la nouvelle case
        $iNewCell = $this->getIdxCell($oPawn->getPosition());
        $this->cells[$iNewCell]->addPawn($oPawn);

        return;
    }

    private function isCurrentPlayer($idUser) {
        return (!is_null($this->playerTurn)) && ($this->pawns[$this->playerTurn]->getUser()->getId() == $idUser);
        // $$$$$$$$ si probleme remettre :  return ($this->pawns[$this->playerTurn]->getUser()->getId() == $idUser);
    }

    private function getCurrentPseudo() {
        $oStartPawn = $this->pawns[$this->playerTurn];
        return $oStartPawn->getUser()->getPseudo();
    }

    public function getMessagesToPlayers() {
        return $this->messagesToPlayers;
    }

    public function getQuestion() {
        return $this->question;
    }

}
