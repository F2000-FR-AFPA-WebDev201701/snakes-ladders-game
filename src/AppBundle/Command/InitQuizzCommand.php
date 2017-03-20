<?php

namespace AppBundle\Command;

use AppBundle\Entity\Question;
use AppBundle\Entity\Reply;
use AppBundle\Entity\Theme;
use AppBundle\Model\Cell;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitQuizzCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console")
                ->setName('app:init-quizz')

                // the short description shown while running "php bin/console list"
                ->setDescription('Init the quizz system')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to init the quizz system...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $oDoc = $this->getContainer()->get('doctrine');
        $em = $oDoc->getManager();  // em signifie Entity Manager : on récupère le service em de doctrine
// THEME 01 : Débeloppement Web
        $oTheme01 = new Theme ();
        $oTheme01->setWording('Développement Web');
        $em->persist($oTheme01);

// THEME 02 : Cuisine
        $oTheme02 = new Theme ();
        $oTheme02->setWording('Cuisine');
        $em->persist($oTheme02);



        // QUESTION 01 (FACILE)
        $oQuestion0101 = new Question ();
        $oQuestion0101->setWording('Quel est le doctype d\'un document HTML5 ?');
        $oQuestion0101->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0101->setTheme($oTheme01);
        $em->persist($oQuestion0101);

        // réponse 01 : correcte
        $oReply010101 = new Reply ();
        $oReply010101->setWording('<!DOCTYPE html>');
        $oReply010101->setValid(true);
        $oReply010101->setQuestion($oQuestion0101);
        $em->persist($oReply010101);

        // réponse 02 : incorrecte
        $oReply010102 = new Reply ();
        $oReply010102->setWording('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML5.0 Strict//EN">');
        $oReply010102->setValid(false);
        $oReply010102->setQuestion($oQuestion0101);
        $em->persist($oReply010102);

        // réponse 03 : incorrecte
        $oReply010103 = new Reply ();
        $oReply010103->setWording('<!DOCTYPE html5>');
        $oReply010103->setValid(false);
        $oReply010103->setQuestion($oQuestion0101);
        $em->persist($oReply010103);



        // QUESTION 02 (FACILE)
        $oQuestion0102 = new Question ();
        $oQuestion0102->setWording('Quelle est la syntaxe pour déclarer l\'encodage des caractères du document en UTF-8 ?');
        $oQuestion0102->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0102->setTheme($oTheme01);
        $em->persist($oQuestion0102);

        // réponse 01 : incorrecte
        $oReply010201 = new Reply ();
        $oReply010201->setWording('<meta encoding="text/html; charset=utf-8">');
        $oReply010201->setValid(false);
        $oReply010201->setQuestion($oQuestion0102);
        $em->persist($oReply010201);

        // réponse 02 : incorrecte
        $oReply010202 = new Reply ();
        $oReply010202->setWording('<meta charset="text/html; UTF-8">');
        $oReply010202->setValid(false);
        $oReply010202->setQuestion($oQuestion0102);
        $em->persist($oReply010202);

        // réponse 03 : correcte
        $oReply010203 = new Reply ();
        $oReply010203->setWording('<meta charset="utf-8">');
        $oReply010203->setValid(true);
        $oReply010203->setQuestion($oQuestion0102);
        $em->persist($oReply010203);



        // QUESTION 03 (FACILE)
        $oQuestion0103 = new Question ();
        $oQuestion0103->setWording('Quelle nouvelle balise de section permet de regrouper un contenu tangentiel au contenu principal du document ?');
        $oQuestion0103->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0103->setTheme($oTheme01);
        $em->persist($oQuestion0103);

        // réponse 01 : incorrecte
        $oReply010301 = new Reply ();
        $oReply010301->setWording('<section id="sidebar">');
        $oReply010301->setValid(false);
        $oReply010301->setQuestion($oQuestion0103);
        $em->persist($oReply010301);

        // réponse 02 : correcte
        $oReply010302 = new Reply ();
        $oReply010302->setWording('<sidebar>');
        $oReply010302->setValid(true);
        $oReply010302->setQuestion($oQuestion0103);
        $em->persist($oReply010302);

        // réponse 03 : incorrecte
        $oReply010303 = new Reply ();
        $oReply010303->setWording('<aside>');
        $oReply010303->setValid(false);
        $oReply010303->setQuestion($oQuestion0103);
        $em->persist($oReply010303);



        // QUESTION 04 (FACILE)
        $oQuestion0104 = new Question ();
        $oQuestion0104->setWording('La nouvelle balise <time> permet de baliser une date structurée. Quelle serait sa syntaxe pour le 1er avril 2012 à 13h37 ?');
        $oQuestion0104->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0104->setTheme($oTheme01);
        $em->persist($oQuestion0104);

        // réponse 01 : correcte
        $oReply010401 = new Reply ();
        $oReply010401->setWording('<time datetime="2012-04-01T13:37:00Z"></time>');
        $oReply010401->setValid(true);
        $oReply010401->setQuestion($oQuestion0104);
        $em->persist($oReply010401);

        // réponse 02 : incorrecte
        $oReply010402 = new Reply ();
        $oReply010402->setWording('<time value="2012-04-01 13:37"></time>');
        $oReply010402->setValid(false);
        $oReply010402->setQuestion($oQuestion0104);
        $em->persist($oReply010402);

        // réponse 03 : incorrecte
        $oReply010403 = new Reply ();
        $oReply010403->setWording('<time datetime="01/04/2012 13H37M00S"></time>');
        $oReply010403->setValid(false);
        $oReply010403->setQuestion($oQuestion0104);
        $em->persist($oReply010403);




        // QUESTION 05 (DIFFICILE)
        $oQuestion0105 = new Question ();
        $oQuestion0105->setWording('Pour le fragment de code XHTML suivant : <div><p>kikoo</p></div><p>lol</p>, avec laquelle de ces règles CSS les deux paragraphes seront-il espacés verticalement de 20 pixels ?');
        $oQuestion0105->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0105->setTheme($oTheme01);
        $em->persist($oQuestion0105);

        // réponse 01 : incorrecte
        $oReply010501 = new Reply ();
        $oReply010501->setWording('div {padding: 0; margin: 0;} \n p {padding: 0; margin: 10px;}');
        $oReply010501->setValid(false);
        $oReply010501->setQuestion($oQuestion0105);
        $em->persist($oReply010501);

        // réponse 02 : incorrecte
        $oReply010502 = new Reply ();
        $oReply010502->setWording('div {padding: 7px; margin: 0;}\n p {padding: 0; margin: 13px;}');
        $oReply010502->setValid(false);
        $oReply010502->setQuestion($oQuestion0105);
        $em->persist($oReply010502);

        // réponse 03 : correcte
        $oReply010503 = new Reply ();
        $oReply010503->setWording(' div {padding: 8px; margin: 5px;} \n p {padding: 0; margin: 6px;}');
        $oReply010503->setValid(true);
        $oReply010503->setQuestion($oQuestion0105);
        $em->persist($oReply010503);



        // QUESTION 06 (DIFFICILE)
        $oQuestion0106 = new Question ();
        $oQuestion0106->setWording('Quelle balise n\'est pas auto-fermante ?');
        $oQuestion0106->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0106->setTheme($oTheme01);
        $em->persist($oQuestion0106);

        // réponse 01 : incorrecte
        $oReply010601 = new Reply ();
        $oReply010601->setWording('<param>');
        $oReply010601->setValid(false);
        $oReply010601->setQuestion($oQuestion0106);
        $em->persist($oReply010601);

        // réponse 02 : correcte
        $oReply010602 = new Reply ();
        $oReply010602->setWording('<optgroup>');
        $oReply010602->setValid(true);
        $oReply010602->setQuestion($oQuestion0106);
        $em->persist($oReply010602);

        // réponse 03 : incorrecte
        $oReply010603 = new Reply ();
        $oReply010603->setWording('<area>');
        $oReply010603->setValid(false);
        $oReply010603->setQuestion($oQuestion0106);
        $em->persist($oReply010603);



        // QUESTION 07 (MOYENNE)
        $oQuestion0107 = new Question ();
        $oQuestion0107->setWording('Comment définit-on une constante ?');
        $oQuestion0107->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0107->setTheme($oTheme01);
        $em->persist($oQuestion0107);

        // réponse 01 : incorrecte
        $oReply010701 = new Reply ();
        $oReply010701->setWording('set(\'maconstante\' = \'valeur\');');
        $oReply010701->setValid(false);
        $oReply010701->setQuestion($oQuestion0107);
        $em->persist($oReply010701);

        // réponse 02 : correcte
        $oReply010702 = new Reply ();
        $oReply010702->setWording('define("maconstante","valeur");');
        $oReply010702->setValid(true);
        $oReply010702->setQuestion($oQuestion0107);
        $em->persist($oReply010702);

        // réponse 03 : incorrecte
        $oReply010703 = new Reply ();
        $oReply010703->setWording('const $maconstante = valeur;');
        $oReply010703->setValid(false);
        $oReply010703->setQuestion($oQuestion0107);
        $em->persist($oReply010703);



// QUESTION 08 (MOYENNE)
        $oQuestion0108 = new Question ();
        $oQuestion0108->setWording('Quel attribut est-il convenu d\'employer pour désigner un élément qui ne sera employé qu\'une seule fois dans le document ?');
        $oQuestion0108->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0108->setTheme($oTheme01);
        $em->persist($oQuestion0108);

        // réponse 01 : correcte
        $oReply010801 = new Reply ();
        $oReply010801->setWording('id');
        $oReply010801->setValid(true);
        $oReply010801->setQuestion($oQuestion0108);
        $em->persist($oReply010801);

        // réponse 02 : incorrecte
        $oReply010802 = new Reply ();
        $oReply010802->setWording('name');
        $oReply010802->setValid(false);
        $oReply010802->setQuestion($oQuestion0108);
        $em->persist($oReply010802);

        // réponse 03 : incorrecte
        $oReply010803 = new Reply ();
        $oReply010803->setWording('class');
        $oReply010803->setValid(false);
        $oReply010803->setQuestion($oQuestion0108);
        $em->persist($oReply010803);



// QUESTION 09 (MOYENNE)
        $oQuestion0109 = new Question ();
        $oQuestion0109->setWording('Ce code XHTML est-il valide ? <ul><li>élément de liste</li><p>détail de l\'élément</p><li>autre élément de liste</li></ul>');
        $oQuestion0109->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0109->setTheme($oTheme01);
        $em->persist($oQuestion0109);

        // réponse 01 : incorrecte
        $oReply010901 = new Reply ();
        $oReply010901->setWording('Oui');
        $oReply010901->setValid(false);
        $oReply010901->setQuestion($oQuestion0109);
        $em->persist($oReply010901);

        // réponse 02 : correcte
        $oReply010902 = new Reply ();
        $oReply010902->setWording('Non');
        $oReply010902->setValid(true);
        $oReply010902->setQuestion($oQuestion0109);
        $em->persist($oReply010902);

        // réponse 03 : incorrecte
        $oReply010903 = new Reply ();
        $oReply010903->setWording('Parfois Oui, parfois Non');
        $oReply010903->setValid(false);
        $oReply010903->setQuestion($oQuestion0109);
        $em->persist($oReply010903);



// QUESTION 10 (FACILE)
        $oQuestion0110 = new Question ();
        $oQuestion0110->setWording('Que signifie CSS ?');
        $oQuestion0110->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0110->setTheme($oTheme01);
        $em->persist($oQuestion0110);

        // réponse 01 : incorrecte
        $oReply011001 = new Reply ();
        $oReply011001->setWording('Cascading Style Sheets');
        $oReply011001->setValid(false);
        $oReply011001->setQuestion($oQuestion0110);
        $em->persist($oReply011001);

        // réponse 02 : correcte
        $oReply010902 = new Reply ();
        $oReply010902->setWording('Create Simple Samples');
        $oReply010902->setValid(true);
        $oReply010902->setQuestion($oQuestion0110);
        $em->persist($oReply010902);

        // réponse 03 : incorrecte
        $oReply011003 = new Reply ();
        $oReply011003->setWording('Community Samples Society');
        $oReply011003->setValid(false);
        $oReply011003->setQuestion($oQuestion0110);
        $em->persist($oReply011003);

// FLUSH
        //[DOCTRINE] sauvegarde dans la base de données data (en fait on rend persistant l'objet Game)
        $em->flush(); // on effectue la requête
    }

}
