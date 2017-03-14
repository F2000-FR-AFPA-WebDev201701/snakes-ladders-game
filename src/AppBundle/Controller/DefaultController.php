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

class DefaultController extends Controller {

    /**
     * @Route("/", name="home")
     * @Template

     */
    public function homeAction() {
        return [];
    }

    /**
     * @Route("/create", name="game_create")
     */
    public function createAction() {

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

        return ['board' => $oBoard];
    }

    /**
     * @Route("/gameboard/action/{action}", name="gameaction")
     * @Template("AppBundle:Default:gameBoard.html.twig")
     */
    public function gameAction($action) {

        // [DOCTRINE] on récupère l'objet oBoard en deserialisant l'attribut data de Game (Game est sauver de manière persistante dans la Db
        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game'); // on récupère les objets Game en récupérant le repository de Game
        $oGame = $repoGame->find(1); // on sélectionne l'objet Game en cours (la partie en cours). On met un index à 1 pour l'instant, puis on modfiera ça lorsque nous aurons plusieurs parties en cours

        $oBoard = unserialize($oGame->getData());  // on crée l'objet oBoard en désérialisant l'attribut-variable $data de oGame : ne pas oublier de faire un schéma update pour créer la table data car elle ne va pas se créé
        // parameters. action va lancer le dés + faire le deplacement du pions via (doAction)
        // movePawn a besoin comme paramètre l'identifiant du user qui a appuyé sur "Dés" Il faut donc changer son propore pion. (session)
        $oBoard->doAction(1, $action);
        // mise a jour de $ogame en lui
        $oGame->setData(serialize($oBoard));
        $em = $this->getDoctrine()->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
        $em->flush();
        return ['board' => $oBoard];
    }

}
