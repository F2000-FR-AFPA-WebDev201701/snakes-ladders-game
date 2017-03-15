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

    // Routing :  "/board" est ce qui va s'afficher dans le navigateur (cela peut être n'importe quel nom mais il ne doit pas avoir été utilisé comme Url avant)
    //            name="board" est le nom de la route que l'on peut appeler avec la fonction path de twig
    //            boardAction  est la fonction sur laquelle on va effectué des opération Php puis elle va retourner les résultats à la page/vue twig du même nom : board.html.twig
    /**
     * @Route("/board", name="board")
     * @Template
     */
}
