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

    public function boardAction() {
        // on copie pour l'instant la fonction gameBoardAction() du dessous
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
        $oGame = $repoGame->find(1); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours
        $oBoard = unserialize($oGame->getData());

        //dump($oBoard);
        return ['board' => $oBoard, // board est un tableau utilisable par twig qui va contenir tous les attributs de oBoard
            'bEndGame' => $oBoard->isEndGame()
        ];
    }

    /**
     * @Route("/create-game/{nbJ}/{theme}", name="game_create")
     */
    public function createAction(Request $request, $nbJ, $theme) {
//      on recupère l'identidiant du user en cours pour récuperer ces données dans la bdd et creer le game avec
        $oUserSession = $request->getSession()->get('oUser')->getId();
        // recupération des informations du User dans la base d donnée via celle de la session
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($oUserSession);
//        Initialisation de Game
        $oGame = new Game;
        $oDateGame = new \DateTime('now');
        $oGame->setCreatedDate($oDateGame);
        $nameGame = 'jeu de ' . $oUser->getPseudo() . ' a la date du ' . $oDateGame->format('Y-m-d H:i:s') . ' avec le super theme ' . $theme;
        $statusGame = 'wait';
        $themeGame = $theme;
        $oGame->setName($nameGame);
        $oGame->setNbPlayerMax($nbJ);
        $oGame->setStatus($statusGame);
        $oGame->setTheme($themeGame);
        //[DOCTRINE] sauvegarde dans la base de données data (en fait on rend persistant l'objet Game)
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->persist($oGame);  // on sauve dans la db l'entité Game qui sera mis a jour en temps réel dans le repository
        $em->flush(); // on effectue la requête
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
        // recupération des informations du User dans la base d donnée via celle de la session
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
            $statusGame = 'ok';
            $oGame->setStatus($statusGame);

            $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
            $em->flush();
            return $this->redirectToRoute('gameboard', array(
                        'iGame' => $oGame->getId()
            ));
        }
        return[""];
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
        $oBoard = unserialize($oGame->getData());

        //dump($oBoard);
        return ['board' => $oBoard, // board est un tableau utilisable par twig qui va contenir tous les attributs de oBoard
            'bEndGame' => $oBoard->isEndGame()
        ];
    }

    /**
     * @Route("/gameboard/action/{action}", name="gameaction")
     * @Template("AppBundle:Game:board.html.twig")
     */
    public function gameAction($action) {
        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game
        // recuperer la session du User -> et y recupérer son game_id. Ainsi nous récipérons le game en cours . Désérialisation .
        $oUserSession = $request->getSession()->get('oUser')->getId();
        dump($oUserSession);
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
        $oGame = $repoGame->find(1); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours

        $oBoard = unserialize($oGame->getData());  // on crée l'objet oBoard en désérialisant l'attribut-variable $data de oGame : ne pas oublier de faire un schéma update pour créer la table data car elle ne va pas se créé
        // parameters. action va lancer le dés + faire le deplacement du pions via (doAction)
        // movePawn a besoin comme paramètre l'identifiant du user qui a appuyé sur "Dés" Il faut donc changer son propore pion. (session)
        $oBoard->doAction(2, $action);
        // mise a jour de $ogame en lui
        $oGame->setData(serialize($oBoard));
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine


        $bEndGame = $oBoard->isEndGame();


        if ($bEndGame) {
            $oGame->setStatus('KO');
        }
        $em->flush();

        return [
            'board' => $oBoard, // on retourne toutes les infos du plateau dans la variable objet 'board' utilisable par twig
            'bEndGame' => $bEndGame // on retourne un booléen 'bEndGame' utilisable par twig qui est le résultat de la fonction IsEndGame(). Cette fonction test si la partie est fini => un ou plusieurs pion se trouve dans la case 63
        ];
    }

}
