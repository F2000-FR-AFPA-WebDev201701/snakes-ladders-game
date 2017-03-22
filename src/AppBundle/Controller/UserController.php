<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Form\Type\UserLoginType;

class UserController extends Controller {

    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function loginAction(Request $request) {
        $oUser = new User;
        // Il s'agit d'un objet utilisateur.
        $oForm = $this->createForm(UserLoginType::class, $oUser);
        // Génération du formulaire UserLogin : l'utilisateur saisit login et password : save.
        $oForm->handleRequest($request);
        // Recueil des données saisies par l'utilisateur.
        if ($oForm->isSubmitted()) {
            // Si les données saisies sont soumises (save).
            $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
            //récupération de login+password de l'User s'il existe sinon nul.
            $oLoginUser = $repoUser->findOneBy([
                'emailLogin' => $oUser->getEmailLogin(),
                'password' => $this->cryptPwd($oUser->getPassword())
            ]);

            if ($oLoginUser instanceof User) {
                $request->getSession()->set('isConnected', true);
                $request->getSession()->set('oUser', $oLoginUser);
            }

            return $this->redirectToRoute('home');
        }

        return [
            'formLogin' => $oForm->createView()
        ];
    }

    /**
     * @Route("/logout", name="logout")
     * @Template
     */
    public function logoutAction(Request $request) {
        $request->getSession()->invalidate();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/register", name="user_register")
     * @Template
     */
    public function registerAction(Request $request) {

        $oUser = new User ();
        $oForm = $this->createForm(UserType::class, $oUser);

//UPLOADER L'IMAGE
        $oForm->handleRequest($request);
        if ($oForm->isSubmitted() && $oForm->isValid()) {
            $sUserPwd = $oUser->getPassword();
            $sCryptedUserPwd = $this->cryptPwd($sUserPwd);
            // = $sCryptedUserPwd = $this->cryptPwd($oUser->getPassword());
            // = $oUser->setPassword($this->cryptPwd($oUser->getPassword()));

            $oUser->setPassword($sCryptedUserPwd);

            $em = $this->getDoctrine()->getManager();
            $em->persist($oUser);
            $em->flush();

            $oFile = $oUser->getIcone();
            $sFilename = 'icone' . $oUser->getId() . '.' . $oFile->guessExtension();
            $sFileDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
            $oFile->move($sFileDir, $sFilename);

            $oUser->setIcone($sFilename);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return [
            'formRegister' => $oForm->createView()
        ];
    }

// fonction de cryptage du mot de passe
    // en utilisant un préfixe.motdepasse.préfixe
    // crypté par sha1 (php)
    //la clé cryptée se place dans le fichier parameter.yml dans app/config

    private function cryptPwd($sMotdepasse) {
        $sSalt = $this->getParameter('crypt_key');
        return sha1($sSalt . $sMotdepasse . $sSalt);
    }

}
