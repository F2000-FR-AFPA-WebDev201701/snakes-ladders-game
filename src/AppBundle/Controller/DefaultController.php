<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Model\Board;

class DefaultController extends Controller {

    /**
     * @Route("/", name="home")
     * @Template

     */
    public function homeAction() {
        return [];
    }

    /**
     * @Route("/gameboard", name="gameboard")
     * @Template

     */
    public function gameBoardAction() {

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

        // dump($oBoard);
        return ['board' => $oBoard];
    }

}
