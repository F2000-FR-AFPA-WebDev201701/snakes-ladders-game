<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\User;
use AppBundle\Model\Board;
use AppBundle\Entity\Game;
use Doctrine\ORM\Mapping as ORM;  // déclaration de l'utilisation de doctrine

class GameController extends Controller {
//    function ci dessous à effacer si il s'avère qu'elle ne sert vraiment a rien
//    public function boardAction() {
//        // on copie pour l'instant la fonction gameBoardAction() du dessous
//        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
//        $oGame = $repoGame->find(1); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours
//        $oBoard = unserialize($oGame->getData());
//
//        //dump($oBoard);
//        return ['board' => $oBoard, // board est un tableau utilisable par twig qui va contenir tous les attributs de oBoard
//            'bEndGame' => $oBoard->isEndGame()
//        ];
//    }

    /**
     * @Route("/create-game/{nbJ}/{theme}", name="game_create")
     */
    public function createAction(Request $request, $nbJ, $theme) {
//      on recupère l'identidiant du user de la session pour récuperer ces données dans la bdd et creer le game avec
        $oUserSession = $request->getSession()->get('oUser')->getId();
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);
//        Recupération de l'objet Theme
        $repoTheme = $this->getDoctrine()->getRepository('AppBundle:Theme');
        $oTheme = $repoTheme->find($theme);
//        Initialisation de Game
        $oGame = new Game;
        $oDateGame = new \DateTime('now');
        $oGame->setCreatedDate($oDateGame);
        $nameGame = 'jeu de ' . $oUser->getPseudo() . ' a la date du ' . $oDateGame->format('Y-m-d H:i:s') . ' avec le super theme ' . $oTheme->getWording();
        $statusGame = 'waiting';
        $oGame->setName($nameGame);
        $oGame->setNbPlayerMax($nbJ);
        $oGame->setStatus($statusGame);
        $oGame->setTheme($oTheme);
        $oGame->setGameCreator($oUser);
        //[DOCTRINE] sauvegarde dans la base de données data (en fait on rend persistant l'objet Game)
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->persist($oGame);  // on sauve dans la db l'entité Game qui sera mis a jour en temps réel dans le repository
        $em->flush(); // on effectue la requête
        //
//        Join the user into this party
        return $this->redirectToRoute('game_join', array(
                    'iGame' => $oGame->getId()
        ));
    }

    /**
     * @Route("/join-game/{iGame}", name="game_join")
     */
    public function joinAction(Request $request, $iGame) {
//        Add in the databse User gameId the information on the idGame
        // recupération des informations du User dans la base d donnée via celle de la session
        // on recupère l'identidiant du user en cours pour récuperer ces données dans la bdd et creer le game avec
        $oUserSession = $request->getSession()->get('oUser')->getId();
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);
        // recupération des informations de game depuis sa base de données.
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($iGame);
        $maxPlayer = $oGame->getNbPlayerMax();
//ajouter au game le user qui a rejoins la partie
        $oGame->addPlayer($oUser);
        $oUser->setGame($oGame);
//ajouter in the dabase the information
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->flush();

//        Si le nombre de joueur affilier a une partie est atteint
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $aoGamePlayers = $repoUser->findBy(array('game' => $iGame));
        if (count($aoGamePlayers) == $maxPlayer) {
//            creation du oBord
            $oBoard = new Board($aoGamePlayers);
//            ajout de oBoard dans data de oGame; et update de Game
            $oGame->setData(serialize($oBoard));
            $statusGame = 'In-process';
            $oGame->setStatus($statusGame);

            $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
            $em->flush();
            return $this->redirectToRoute('gameboard', array(
                        'iGame' => $oGame->getId()
            ));
        }
        //        Si le nombre de joueur affilier a une partie n'est pas atteint
        else {
//            return $this->redirectToRoute('waitingGame');
//             afficher les informations suivante dans un popup
//            1- jouer quand meme (si IdUser=GameCreator)-> URL
//            2- affichage nombre de joueur actuel est x manque x joueur. En attente
//           3- Sortir du jeux -> URL . supprimer le joueur dans game ET si IDuser =GameCreator alors on supprimer egalement la partie
        }
    }

    /**
     * @Route("/waitingGame, name="waitingGame")
     * @Template
     */
//    public function waitingGameAction() {
//        return [];
//    }

    /**
     * @Route("/gameboard/{iGame}", name="gameboard")
     * @Template
     * Chargement du plateau de jeu
     */
    public function gameBoardAction($iGame) {

        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game (Game est sauver de manière persistante dans la Db
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
        $oGame = $repoGame->find($iGame); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours
        $oBoard = unserialize($oGame->getData());
        return ['board' => $oBoard, // board est un tableau utilisable par twig qui va contenir tous les attributs de oBoard
            'bEndGame' => $oBoard->isEndGame()
        ];
    }

    /**
     * @Route("/gameboard/action/{action}", name="gameaction")
     * @Template("AppBundle:Game:board.html.twig")
     */
    public function gameAction(Request $request, $action) {
        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game
        // Pour cela, recuperer la session du User -> et y recupérer son game_id. Ainsi nous récipérons le game en cours . Désérialisation .
        $oUserSession = $request->getSession()->get('oUser')->getId();
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);
        $iGameUser = $oUser->getGame();
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($iGameUser); // on sélectionne l'objet Game en cours (la partie en cours).
        $oBoard = unserialize($oGame->getData());  // on crée l'objet oBoard en désérialisant l'attribut-variable $data de oGame
        // parameters. action va lancer le dés + faire le deplacement du pions via (doAction)
        // movePawn a besoin comme paramètre l'identifiant du user qui a appuyé sur "Dés" ($_session)
        $oBoard->doAction($oUser->getId(), $action);
        // mise a jour de $ogame en lui
        $oGame->setData(serialize($oBoard));
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
//        gestion de la fin de la partie si user >63
        $bEndGame = $oBoard->isEndGame();
        if ($bEndGame) {
            $oGame->setStatus('Done');
        }
        $em->flush();

        return [
            'board' => $oBoard, // on retourne toutes les infos du plateau dans la variable objet 'board' utilisable par twig
            'bEndGame' => $bEndGame // on retourne un booléen 'bEndGame' utilisable par twig qui est le résultat de la fonction IsEndGame(). Cette fonction test si la partie est fini => un ou plusieurs pion se trouve dans la case 63
        ];
    }

}
