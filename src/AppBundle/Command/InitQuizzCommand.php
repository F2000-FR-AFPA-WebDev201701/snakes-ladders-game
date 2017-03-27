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

        // THEME 01  ( Affichage du numéro du thème dans la variable question : Question0101 )
        // QUESTION 01 (FACILE)
        $oQuestion0101 = new Question ();
        $oQuestion0101->setWording('Quel est le doctype d\'un document HTML5 ?');
        $oQuestion0101->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0101->setTheme($oTheme01);
        $em->persist($oQuestion0101);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
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
        $oReply011001->setValid(true);
        $oReply011001->setQuestion($oQuestion0110);
        $em->persist($oReply011001);

        // réponse 02 : correcte
        $oReply010902 = new Reply ();
        $oReply010902->setWording('Create Simple Samples');
        $oReply010902->setValid(false);
        $oReply010902->setQuestion($oQuestion0110);
        $em->persist($oReply010902);

        // réponse 03 : incorrecte
        $oReply011003 = new Reply ();
        $oReply011003->setWording('Community Samples Society');
        $oReply011003->setValid(false);
        $oReply011003->setQuestion($oQuestion0110);
        $em->persist($oReply011003);










        // QUESTION 11 (FACILE)
        $oQuestion0111 = new Question ();
        $oQuestion0111->setWording('Avec qui le développeur va échanger le plus fréquemment ? ?');
        $oQuestion0111->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0111->setTheme($oTheme01);
        $em->persist($oQuestion0111);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011101 = new Reply ();
        $oReply011101->setWording('L intégrateur web');
        $oReply011101->setValid(true);
        $oReply011101->setQuestion($oQuestion0111);
        $em->persist($oReply011101);

        // réponse 02 : incorrecte
        $oReply011102 = new Reply ();
        $oReply011102->setWording('Le graphiste');
        $oReply011102->setValid(false);
        $oReply011102->setQuestion($oQuestion0111);
        $em->persist($oReply011102);

        // réponse 03 : incorrecte
        $oReply011103 = new Reply ();
        $oReply011103->setWording(' Le gestionnaire de base de données ');
        $oReply011103->setValid(false);
        $oReply011103->setQuestion($oQuestion0111);
        $em->persist($oReply011103);

        // QUESTION 12 (FACILE)
        $oQuestion0112 = new Question ();
        $oQuestion0112->setWording('Quelles sont les données retournées par un serveur web ?');
        $oQuestion0112->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0112->setTheme($oTheme01);
        $em->persist($oQuestion0112);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011201 = new Reply ();
        $oReply011201->setWording('Du HTML et du CSS ');
        $oReply011201->setValid(false);
        $oReply011201->setQuestion($oQuestion0112);
        $em->persist($oReply011201);

        // réponse 02 : incorrecte
        $oReply011202 = new Reply ();
        $oReply011202->setWording(' Du HTML, du CSS et du JS');
        $oReply011202->setValid(true);
        $oReply011202->setQuestion($oQuestion0112);
        $em->persist($oReply011202);

        // réponse 03 : incorrecte
        $oReply011203 = new Reply ();
        $oReply011203->setWording('Du PHP');
        $oReply011203->setValid(false);
        $oReply011203->setQuestion($oQuestion0112);
        $em->persist($oReply011203);


        // QUESTION 13 (FACILE)
        $oQuestion0113 = new Question ();
        $oQuestion0113->setWording('A quoi sert l attribut class ?');
        $oQuestion0113->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0113->setTheme($oTheme01);
        $em->persist($oQuestion0113);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011301 = new Reply ();
        $oReply011301->setWording(' A spécifier la classe de style ');
        $oReply011301->setValid(true);
        $oReply011301->setQuestion($oQuestion0113);
        $em->persist($oReply011301);

        // réponse 02 : incorrecte
        $oReply011302 = new Reply ();
        $oReply011302->setWording(' A ordonner des éléments ');
        $oReply011302->setValid(false);
        $oReply011302->setQuestion($oQuestion0113);
        $em->persist($oReply011302);

        // réponse 03 : incorrecte
        $oReply011303 = new Reply ();
        $oReply011303->setWording(' A spécifier le type de HTML utilisé ');
        $oReply011303->setValid(false);
        $oReply011303->setQuestion($oQuestion0113);
        $em->persist($oReply011303);


        // QUESTION 14 (FACILE)
        $oQuestion0114 = new Question ();
        $oQuestion0114->setWording(' A quoi sert la balise <nav> ?');
        $oQuestion0114->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0114->setTheme($oTheme01);
        $em->persist($oQuestion0114);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011401 = new Reply ();
        $oReply011401->setWording(' A définir des menus alternatifs  ');
        $oReply011401->setValid(false);
        $oReply011401->setQuestion($oQuestion0114);
        $em->persist($oReply011401);

        // réponse 02 : incorrecte
        $oReply011402 = new Reply ();
        $oReply011402->setWording(' A définir des listes déroulantes ');
        $oReply011402->setValid(false);
        $oReply011402->setQuestion($oQuestion0114);
        $em->persist($oReply011402);

        // réponse 03 : incorrecte
        $oReply011403 = new Reply ();
        $oReply011403->setWording('A définir des éléments de navigation ');
        $oReply011403->setValid(true);
        $oReply011403->setQuestion($oQuestion0114);
        $em->persist($oReply011403);


// QUESTION 15 (FACILE)
        $oQuestion0115 = new Question ();
        $oQuestion0115->setWording('Dans la règle suivante, quel élément deviendra rouge ? ( strong#intro {background-color: red;} )');
        $oQuestion0115->setDifficulty(Cell::LEVEL_EASY);
        $oQuestion0115->setTheme($oTheme01);
        $em->persist($oQuestion0115);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011501 = new Reply ();
        $oReply011501->setWording('Tous les éléments <strong> contenus dans un élément dont l id est "intro"');
        $oReply011501->setValid(false);
        $oReply011501->setQuestion($oQuestion0115);
        $em->persist($oReply011501);

        // réponse 02 : incorrecte
        $oReply011502 = new Reply ();
        $oReply011502->setWording(' L élément dont  lid est "intro" et qui est contenu dans un élément <strong> ');
        $oReply011502->setValid(false);
        $oReply011502->setQuestion($oQuestion0115);
        $em->persist($oReply011502);

        // réponse 03 : incorrecte
        $oReply011503 = new Reply ();
        $oReply011503->setWording('  L élément <strong> dont l id est "intro"  ');
        $oReply011503->setValid(true);
        $oReply011503->setQuestion($oQuestion0115);
        $em->persist($oReply011503);


        // QUESTION 16 (moyenne)
        $oQuestion0116 = new Question ();
        $oQuestion0116->setWording('A quoi sert la propriété "relative" ?  )');
        $oQuestion0116->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0116->setTheme($oTheme01);
        $em->persist($oQuestion0116);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011601 = new Reply ();
        $oReply011601->setWording('Servier de référentiel à des éléments "fixed" ');
        $oReply011601->setValid(false);
        $oReply011601->setQuestion($oQuestion0116);
        $em->persist($oReply011601);

        // réponse 02 : incorrecte
        $oReply011602 = new Reply ();
        $oReply011602->setWording('Décaler un élément par rapport à sa position de référence');
        $oReply011602->setValid(true);
        $oReply011602->setQuestion($oQuestion0116);
        $em->persist($oReply011602);

        // réponse 03 : incorrecte
        $oReply011603 = new Reply ();
        $oReply011603->setWording('  Décaler un élément par rapport à un autre élément "relative"  ');
        $oReply011603->setValid(false);
        $oReply011603->setQuestion($oQuestion0116);
        $em->persist($oReply011603);



        // QUESTION 17 (moyenne)
        $oQuestion0117 = new Question ();
        $oQuestion0117->setWording('Quelle syntaxe n est pas correcte ? )');
        $oQuestion0117->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0117->setTheme($oTheme01);
        $em->persist($oQuestion0117);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011701 = new Reply ();
        $oReply011701->setWording('   public function maFonction( $p1=4, $p2, $p3=5) {... }  ');
        $oReply011701->setValid(true);
        $oReply011701->setQuestion($oQuestion0117);
        $em->persist($oReply011701);

        // réponse 02 : incorrecte
        $oReply011702 = new Reply ();
        $oReply011702->setWording('   public function maFonction( $p1, $p2, $p3=5) {... }   ');
        $oReply011702->setValid(false);
        $oReply011702->setQuestion($oQuestion0117);
        $em->persist($oReply011702);

        // réponse 03 : incorrecte
        $oReply011703 = new Reply ();
        $oReply011703->setWording('   public function maFonction( $p1=3, $p2=1, $p3=5) {... }  ');
        $oReply011703->setValid(false);
        $oReply011703->setQuestion($oQuestion0117);
        $em->persist($oReply011703);

        // QUESTION 18 (moyenne)
        $oQuestion0118 = new Question ();
        $oQuestion0118->setWording('Quelle instruction PHP permet de démarrer une session ? )');
        $oQuestion0118->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0118->setTheme($oTheme01);
        $em->persist($oQuestion0118);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011801 = new Reply ();
        $oReply011801->setWording('session_create( )');
        $oReply011801->setValid(false);
        $oReply011801->setQuestion($oQuestion0118);
        $em->persist($oReply011801);

        // réponse 02 : incorrecte
        $oReply011802 = new Reply ();
        $oReply011802->setWording('  new Session() ');
        $oReply011802->setValid(false);
        $oReply011802->setQuestion($oQuestion0118);
        $em->persist($oReply011802);

        // réponse 03 : incorrecte
        $oReply011803 = new Reply ();
        $oReply011803->setWording('session_start( ) ');
        $oReply011803->setValid(true);
        $oReply011803->setQuestion($oQuestion0118);
        $em->persist($oReply011803);

        // QUESTION 19 (moyenne)
        $oQuestion0119 = new Question ();
        $oQuestion0119->setWording('Quel est le pré-requis majeur à un autoload rapide à mettre en place ? )');
        $oQuestion0119->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0119->setTheme($oTheme01);
        $em->persist($oQuestion0119);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply011901 = new Reply ();
        $oReply011901->setWording(' Utiliser PHP 7 ');
        $oReply011901->setValid(false);
        $oReply011901->setQuestion($oQuestion0119);
        $em->persist($oReply011901);

        // réponse 02 : incorrecte
        $oReply011902 = new Reply ();
        $oReply011902->setWording('  Respecter une nomenclature précise ');
        $oReply011902->setValid(true);
        $oReply011902->setQuestion($oQuestion0119);
        $em->persist($oReply011902);

        // réponse 03 : incorrecte
        $oReply011903 = new Reply ();
        $oReply011903->setWording('  Faire hériter toutes nos classes d une classe mère ');
        $oReply011903->setValid(false);
        $oReply011903->setQuestion($oQuestion0119);
        $em->persist($oReply011903);

// QUESTION 20 (moyenne)
        $oQuestion0120 = new Question ();
        $oQuestion0120->setWording(' Comment définir un bouton d alerte de couleur rouge ? )');
        $oQuestion0120->setDifficulty(Cell::LEVEL_MEDIUM);
        $oQuestion0120->setTheme($oTheme01);
        $em->persist($oQuestion0120);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012001 = new Reply ();
        $oReply012001->setWording(' btn btn-danger ');
        $oReply012001->setValid(true);
        $oReply012001->setQuestion($oQuestion0120);
        $em->persist($oReply012001);

        // réponse 02 : incorrecte
        $oReply012002 = new Reply ();
        $oReply012002->setWording(' btn btn-warning ');
        $oReply012002->setValid(false);
        $oReply012002->setQuestion($oQuestion0120);
        $em->persist($oReply012002);

        // réponse 03 : incorrecte
        $oReply012003 = new Reply ();
        $oReply012003->setWording('  btn btn-error ');
        $oReply012003->setValid(false);
        $oReply012003->setQuestion($oQuestion0120);
        $em->persist($oReply012003);

// QUESTION 21 (difficile)
        $oQuestion0121 = new Question ();
        $oQuestion0121->setWording(' Quelle réponse ne valide pas la RegExp suivante : "s[ao]*" )');
        $oQuestion0121->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0121->setTheme($oTheme01);
        $em->persist($oQuestion0121);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012101 = new Reply ();
        $oReply012101->setWording('  s');
        $oReply012101->setValid(false);
        $oReply012101->setQuestion($oQuestion0121);
        $em->persist($oReply012101);

        // réponse 02 : incorrecte
        $oReply012102 = new Reply ();
        $oReply012102->setWording('Sooaoaoa');
        $oReply012102->setValid(true);
        $oReply012102->setQuestion($oQuestion0121);
        $em->persist($oReply012102);

        // réponse 03 : incorrecte
        $oReply012103 = new Reply ();
        $oReply012103->setWording(' sao');
        $oReply012103->setValid(false);
        $oReply012103->setQuestion($oQuestion0121);
        $em->persist($oReply012103);

        // QUESTION 22 (difficile)
        $oQuestion0122 = new Question ();
        $oQuestion0122->setWording(' Comment faire un survol de lien (rollover) accessible au plus grand nombre en CSS" )');
        $oQuestion0122->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0122->setTheme($oTheme01);
        $em->persist($oQuestion0122);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012201 = new Reply ();
        $oReply012201->setWording(' a:hover {color: blue;}');
        $oReply012201->setValid(false);
        $oReply012201->setQuestion($oQuestion0122);
        $em->persist($oReply012201);

        // réponse 02 : incorrecte
        $oReply012202 = new Reply ();
        $oReply012202->setWording('a:hover, a:focus {color: blue;}');
        $oReply012202->setValid(false);
        $oReply012202->setQuestion($oQuestion0122);
        $em->persist($oReply012202);

        // réponse 03 : incorrecte
        $oReply012203 = new Reply ();
        $oReply012203->setWording('a:hover, a:focus, a:active {color: blue;})');
        $oReply012203->setValid(true);
        $oReply012203->setQuestion($oQuestion0122);
        $em->persist($oReply012203);


        // QUESTION 23 (difficile)
        $oQuestion0123 = new Question ();
        $oQuestion0123->setWording(' En supposant que tous les sélecteurs suivants sont justes et désignent le même élément, lequel sera appliqué en priorité ?" )');
        $oQuestion0123->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0123->setTheme($oTheme01);
        $em->persist($oQuestion0123);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012301 = new Reply ();
        $oReply012301->setWording('#page .menu a {}');
        $oReply012301->setValid(true);
        $oReply012301->setQuestion($oQuestion0123);
        $em->persist($oReply012301);

        // réponse 02 : incorrecte
        $oReply012302 = new Reply ();
        $oReply012302->setWording('div.menu ul li a {}');
        $oReply012302->setValid(false);
        $oReply012302->setQuestion($oQuestion0123);
        $em->persist($oReply012302);

        // réponse 03 : incorrecte
        $oReply012303 = new Reply ();
        $oReply012303->setWording('#page ul li a {}');
        $oReply012303->setValid(false);
        $oReply012303->setQuestion($oQuestion0123);
        $em->persist($oReply012303);

        // QUESTION 24 (difficile)
        $oQuestion0124 = new Question ();
        $oQuestion0124->setWording(' Comment définit-on le constructeur d une classe (compatible PHP3/4/5)');
        $oQuestion0124->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0124->setTheme($oTheme01);
        $em->persist($oQuestion0124);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012401 = new Reply ();
        $oReply012401->setWording('en utilisant __construct()');
        $oReply012401->setValid(false);
        $oReply012401->setQuestion($oQuestion0124);
        $em->persist($oReply012401);

        // réponse 02 : incorrecte
        $oReply012402 = new Reply ();
        $oReply012402->setWording('en nommant la fonction comme la classe');
        $oReply012402->setValid(true);
        $oReply012402->setQuestion($oQuestion0124);
        $em->persist($oReply012402);

        // réponse 03 : incorrecte
        $oReply012403 = new Reply ();
        $oReply012403->setWording('grâce à public static void()');
        $oReply012403->setValid(false);
        $oReply012403->setQuestion($oQuestion0124);
        $em->persist($oReply012403);

        // QUESTION 25 (difficile)
        $oQuestion0125 = new Question ();
        $oQuestion0125->setWording('Quel mot clé permet de conserver la valeur d une variable locale dans une même fonction appelée plusieurs fois de suite ?');
        $oQuestion0125->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0125->setTheme($oTheme01);
        $em->persist($oQuestion0125);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012501 = new Reply ();
        $oReply012501->setWording('static');
        $oReply012501->setValid(true);
        $oReply012501->setQuestion($oQuestion0125);
        $em->persist($oReply012501);

        // réponse 02 : incorrecte
        $oReply012502 = new Reply ();
        $oReply012502->setWording('global');
        $oReply012502->setValid(false);
        $oReply012502->setQuestion($oQuestion0125);
        $em->persist($oReply012502);

        // réponse 03 : incorrecte
        $oReply012503 = new Reply ();
        $oReply012503->setWording('const');
        $oReply012503->setValid(false);
        $oReply012503->setQuestion($oQuestion0125);
        $em->persist($oReply012503);

// QUESTION 26 (difficile)
        $oQuestion0126 = new Question ();
        $oQuestion0126->setWording('Quel est le résultat de parseInt("010",8) ?');
        $oQuestion0126->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0126->setTheme($oTheme01);
        $em->persist($oQuestion0126);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012601 = new Reply ();
        $oReply012601->setWording('1');
        $oReply012601->setValid(false);
        $oReply012601->setQuestion($oQuestion0126);
        $em->persist($oReply012601);

        // réponse 02 : incorrecte
        $oReply012602 = new Reply ();
        $oReply012602->setWording('2');
        $oReply012602->setValid(false);
        $oReply012602->setQuestion($oQuestion0126);
        $em->persist($oReply012602);

        // réponse 03 : incorrecte
        $oReply012603 = new Reply ();
        $oReply012603->setWording('8');
        $oReply012603->setValid(true);
        $oReply012603->setQuestion($oQuestion0126);
        $em->persist($oReply012603);

        // QUESTION 27 (difficile)
        $oQuestion0127 = new Question ();
        $oQuestion0127->setWording('Quelle chaîne de caractères ne correspond pas à lexpression régulière /\ba/?');
        $oQuestion0127->setDifficulty(Cell::LEVEL_HARD);
        $oQuestion0127->setTheme($oTheme01);
        $em->persist($oQuestion0127);

        // réponse 01 : correcte ( ffichage du numéro du thème, puis numéro de la question dans la variable réponse : $oReply010101 )
        $oReply012701 = new Reply ();
        $oReply012701->setWording('"-a"');
        $oReply012701->setValid(false);
        $oReply012701->setQuestion($oQuestion0127);
        $em->persist($oReply012701);

        // réponse 02 : incorrecte
        $oReply012702 = new Reply ();
        $oReply012702->setWording('"_a"');
        $oReply012702->setValid(true);
        $oReply012702->setQuestion($oQuestion0127);
        $em->persist($oReply012702);

        // réponse 03 : incorrecte
        $oReply012703 = new Reply ();
        $oReply012703->setWording('"d c b a"');
        $oReply012703->setValid(false);
        $oReply012703->setQuestion($oQuestion0127);
        $em->persist($oReply012703);

// FLUSH
        //[DOCTRINE] sauvegarde dans la base de données data (en fait on rend persistant l'objet Game)
        $em->flush(); // on effectue la requête
    }

}
