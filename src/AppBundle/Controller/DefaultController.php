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

}
