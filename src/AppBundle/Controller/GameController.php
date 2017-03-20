<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * @Route("/create", name="game_create")
     */
    public function createAction() {   // on va lancer le create 1 fois pour creer le tableau de jeu
        $oPlayer = new User();
        $oPlayer->setId('1');
        $oPlayer->setEmailLogin('aaa@aaa.com');
        $oPlayer->setPassword('aaaaaa');
        $oPlayer->setIcone('images/joueur_logo.jpg');
        $oPlayer->setPseudo('bbbbbb');
        $oPlayer->setFirstname('Pierre');
        $oPlayer->setLastname('cccccc');

        $aoPlayer[] = $oPlayer;

        $oPlayer = new User();
        $oPlayer->setId('2');
        $oPlayer->setEmailLogin('aaa2@aaa2.com');
        $oPlayer->setPassword('aaaaaa2');
        $oPlayer->setIcone('images/joueur_logo.jpg');
        $oPlayer->setPseudo('coco');
        $oPlayer->setFirstname('Pierre2');
        $oPlayer->setLastname('cccccc2');

        $aoPlayer[] = $oPlayer;

        $oBoard = new Board($aoPlayer);
        $oBoard->setPlayerTurn(0);

        //sérialisation l'objet plateau de jeu oBoard dans l'attribut $data de l'objet game pour pouvoir le sauver en DB/faire un persist flush sur l'entité game
        $oGame = new Game;
        $oGame->setData(serialize($oBoard));
        $oGame->setName('partie 1');
        $oGame->setCreatedDate(new \DateTime(date('Y-m-d H:i:s')));
        $oGame->setNbPlayerMax(9);
        $oGame->setStatus('OK');

        //[DOCTRINE] sauvegarde dans la base de données data (en fait on rend persistant l'objet Game)
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->persist($oGame);  // on sauve dans la db l'entité Game qui sera mis a jour en temps réel dans le repository
        $em->flush(); // on effectue la requête

        return $this->redirectToRoute('gameboard');
    }

    /**
     * @Route("/gameboard", name="gameboard")
     * @Template
     * Chargement du plateau de jeu
     */
    public function gameBoardAction() {

        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game (Game est sauver de manière persistante dans la Db
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
        $oGame = $repoGame->find(1); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours

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

        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game (Game est sauver de manière persistante dans la Db
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
