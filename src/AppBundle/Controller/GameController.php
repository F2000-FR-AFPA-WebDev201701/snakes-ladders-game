<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Model\Board;
use AppBundle\Entity\Game;

class GameController extends Controller {

    /**
     * @Route("/create-game/{nbJ}/{theme}", name="game_create")
     */
    public function createAction(Request $request, $nbJ, $theme) {
        // on recupère l'identidiant du user en cours pour récuperer ces données dans la bdd et creer le game avec
        $oUserSession = $request->getSession()->get('oUser')->getId();

        // recupération des informations du User dans la base d donnée via celle de la session
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);

        // Recupération de l'objet Theme
        $repoTheme = $this->getDoctrine()->getRepository('AppBundle:Theme');
        $oTheme = $repoTheme->find($theme);

        $oDateGame = new \DateTime('now');
        $nameGame = 'Jeu de ' . $oUser->getPseudo() . ' à la Date du ' . $oDateGame->format('Y-m-d H:i:s') . ' avec le Super-Thème ' . $theme;

        // Initialisation de Game
        $oGame = new Game;
        $oGame->setCreatedDate($oDateGame);
        $oGame->setName($nameGame);
        $oGame->setNbPlayerMax($nbJ);
        $oGame->setStatus('waiting');
        $oGame->setTheme($oTheme);
        $oGame->setGameCreator($oUser);
//        creation du tableau de jeu pour gérer le cas que le nombre de user (dans join n'est pas suffisant')
        $oBoard = new Board();
//            ajout de oBoard dans data de oGame; et update de Game
        $oGame->setData(serialize($oBoard));

        //[DOCTRINE] sauvegarde dans la base de données data (en fait on rend persistant l'objet Game)
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->persist($oGame);  // on sauve dans la db l'entité Game qui sera mis a jour en temps réel dans le repository
        $em->flush();

        // Join the user into this party
        return $this->redirectToRoute('game_join', array(
                    'iGame' => $oGame->getId()
        ));
    }

    /**
     * @Route("/join-game/{iGame}", name="game_join")
     */
    public function joinAction(Request $request, $iGame) {
//        Add in the database User gameId the information on the idGame
        // recupération des informations du User dans la base d donnée via celle de la session
        // on recupère l'identidiant du user en cours pour récuperer ces données dans la bdd et creer le game avec
        $oUserSession = $request->getSession()->get('oUser')->getId();
        $em = $this->getDoctrine()->getManager();

        // recupération des informations du User dans la base d donnée via celle de la session
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);

        // recupération des informations de game depuis sa base de données.
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($iGame);

        //ajouter au game le user qui a rejoins la partie
        $oGame->addPlayer($oUser);
        $oUser->setGame($oGame);

        //ajouter in the dabase the information
        $em->flush();

        // Envoie des informations du jeu dans game_start qui va tester si le nombre de joueur est suffisant
        return $this->redirectToRoute('game_start', array(
                    'iGame' => $oGame->getId()
        ));
    }

    /**
     * @Route("/changePlayer-game/{iGame}/{newNbPlayerMax}", name="changeNbPlayerMax")
     */
    public function changeNbPlayerMaxAction($iGame, $newNbPlayerMax) {
        // Cette fonction permet de changer le nombre de joueur Max d'une partie déjà créé.
        $em = $this->getDoctrine()->getManager();
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($iGame);

//      Changement de  nombre de joeur max autorisé par le nombre de joeur actuel
        $oGame->setNbPlayerMax(intval($newNbPlayerMax));
        $em->flush();

//      Redirection
        return $this->redirectToRoute('game_start', array(
                    'iGame' => $oGame->getId()
        ));
    }

    /**
     * @Route("/leave-game/{iGame}", name="leaveGame")
     */
    public function leaveGameAction($iGame, Request $request) {
        // Cette fonction permet de supprimer le userSession de la partie en cour et si userSession = createur de la partie alors suppression de la partie
        // récupération du jeu
        $em = $this->getDoctrine()->getManager();
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($iGame);

        // recupération des informations du User dans la base d donnée via celle de la session
        $oUserSession = $request->getSession()->get('oUser')->getId();
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);

        // suppression du User dans la partie
        $oGame->removePlayer($oUser);
        $oUser->setGame();
        $em->flush();

        // Si le userSession est également le createur de la partie on suprrimer la partie
        if ($oUser->getId() == $oGame->getGameCreator()->getId()) {
//            suppression de tous les players restant affilier à la partie
            foreach ($oGame->getPlayers() as $oPlayer) {
                $oGame->removePlayer($oPlayer);
                $oPlayer->setGame();
            }
//            suppression de la partie dans la base de données
            $em->remove($oGame);
            $em->flush();
        }

        //      Redirection
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/start-game/{iGame}", name="game_start")
     */
    public function startGameAction($iGame) {
        // Cette fonction permet de changer le status du game a in-process si le nombre de joueurs est atteint
        $em = $this->getDoctrine()->getManager();

//        recupération des informations de game depuis sa base de données.
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($iGame);

        if (count($oGame->getPlayers()) == $oGame->getNbPlayerMax()) {
// [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game (Game est sauver de manière persistante dans la Db
            $oBoard = unserialize($oGame->getData());
            $oBoard->initPlayers($oGame->getPlayers());

            // ajout de oBoard dans data de oGame; et update de Game
            $oGame->setData(serialize($oBoard));
            $oGame->setStatus('in-process');

            // em signifie Entity Manager : on récupère le service em de doctrine
            $em->flush();
        }
        return $this->redirectToRoute('gameboard', array(
                    'iGame' => $oGame->getId()
        ));
    }

    /**
     * @Route("/gameboard/{iGame}", name="gameboard")
     * @Template
     * Chargement du plateau de jeu
     */
    public function gameBoardAction($iGame) {

        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game (Game est sauver de manière persistante dans la Db
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
        $oGame = $repoGame->find($iGame); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours
        if ($oGame === null) {
            //      Redirection vers home si la partie n'existe plus (suprresion par le createur)
            return $this->redirectToRoute('home');
        }
        $oBoard = unserialize($oGame->getData());
        return [
            'board' => $oBoard, // board est un tableau utilisable par twig qui va contenir tous les attributs de oBoard
            'bEndGame' => $oBoard->isEndGame(),
            'nameGame' => $oGame->getName(),
            'game' => $oGame,
            'sStatusGame' => $oGame->getStatus(),
        ];
    }

    /**
     * @Route("/gameboard/action/{action}", name="gameaction")
     * @Template("AppBundle:Game:board.html.twig")
     */
    public function gameAction($action, Request $request) {

        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game
        // Pour cela, recuperer la session du User -> et y recupérer son game_id. Ainsi nous récipérons le game en cours . Désérialisation .
        $oUserSession = $request->getSession()->get('oUser')->getId();

        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);

        $oGame = $oUser->getGame();
        $oBoard = unserialize($oGame->getData());  // on crée l'objet oBoard en désérialisant l'attribut-variable $data de oGame
        // parameters. action va lancer le dés + faire le deplacement du pions via (doAction)
        // movePawn a besoin comme paramètre l'identifiant du user qui a appuyé sur "Dés" ($_session)
        //
        //Je récupère la requete dans le REQUEST et j'initialise la variable-paramètre $repoQuestion
        // je vérifie si elle est de type POST (c'est à dire si un bouton réponse a été cliqué)
        $idQuestion = $request->request->get('idQuestion', null);
        $idReply = $request->request->get('idReply', null);

        $repoQuestion = $this->getDoctrine()->getRepository('AppBundle:Question');

        if ($idQuestion && $idReply) {

            $oBoard->doQuizzAction(
                    $oUser->getId(), $repoQuestion, $idQuestion, $idReply
            );
        } else {
            $oBoard->doAction(
                    $oUser->getId(), $action, $repoQuestion, $oGame->getTheme()
            );
        }

        // gestion de la fin de la partie si user >63
        $bEndGame = $oBoard->isEndGame();
        if ($bEndGame) {
            $oGame->setStatus('Done');
        }

        // mise a jour de $ogame en lui
        $oGame->setData(serialize($oBoard));
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->flush();

        return [
            'board' => $oBoard, // on retourne toutes les infos du plateau dans la variable objet 'board' utilisable par twig
            'bEndGame' => $bEndGame, // on retourne un booléen 'bEndGame' utilisable par twig qui est le résultat de la fonction IsEndGame(). Cette fonction test si la partie est fini => un ou plusieurs pion se trouve dans la case 63
            'nameGame' => $oGame->getName(),
            'game' => $oGame,
            'sStatusGame' => $oGame->getStatus(),
        ];
    }

}
