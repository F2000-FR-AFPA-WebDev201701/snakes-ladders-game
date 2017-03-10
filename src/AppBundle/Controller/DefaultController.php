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
        // $this->setIcone('a.jpg');
        $oPlayer->setPseudo('bbbbbb');
        $oPlayer->setFirstname('Pierre');
        $oPlayer->setLastname('cccccc');


        $oBoard = new Board([$oPlayer]);

        // dump($oBoard);
        return ['board' => $oBoard];
    }

}
