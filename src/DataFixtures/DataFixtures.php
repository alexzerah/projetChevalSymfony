<?php

namespace App\DataFixtures;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\User;
use App\Entity\Weekend;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function user(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('Dave');
        $user->setLastName('Lawper');
        $user->setUsername('admin');
        $user->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $user->setEmail('test@gmail.com');
        $user->setAvatar('default_avatar.jpg');
        $user->setIsAdmin(true);
        $user->setIsActive('1');

        $manager->persist($user);

        $manager->flush();


    }

    public function load(ObjectManager $manager)
    {
        $exhibit1 = new Exhibit();
        $exhibit1->setName("TERRA DATA, nos vies à l’ère du numérique");
        $exhibit1->setLocation("30 avenue Corentin Cariou - 75019 Paris");
        $exhibit1->setPrice("5");
        $exhibit1->setDetails("La Cité des Sciences et de l’Industrie présente du 4 avril 2017 au 7 janvier 2018, « Terra Data, nos vies à l’ère du numérique ». Conçue initialement pour les élèves de la 6e à la terminale, cette exposition ouverte à tous publics, permet de cerner de façon ludique ce qu’est le big data. Avec le numérique qui nous permet de quantifier et mesurer précisément l’univers qui nous entoure, il est désormais devenu nécessaire pour les jeunes d’intégrer ces notions en vue de futures carrières professionnelles de plus en plus digitalisées. Le public est invité à découvrir les méthodes, outils et applications liées à ce sujet et cerner les enjeux de cette nouvelle guerre de l’information.");
        $exhibit1->setBanner("terradata.jpg");
        $exhibit1->setDate(new \DateTime('2018-03-14 14:00:00'));

        $exhibit2 = new Exhibit();
        $exhibit2->setName("Caro / Jeunet");
        $exhibit2->setLocation("2 rue Ronsard - 75018 Paris");
        $exhibit2->setPrice("7");
        $exhibit2->setDetails("La Halle Saint-Pierre expose pour la première fois les œuvres et pépites d’un binôme de choc : les réalisateurs français Jean-Pierre Jeunet et Marc Caro. Co-réalisateurs du primé Delicatessen et de l’étrange La Cité des enfants perdus, les deux hommes prêtent pour l’occasion des objets « singuliers » de leur collection personnelle respective. Extraits de films, objets, costumes et documents accompagnent ces trésors, pour plonger les visiteurs dans leur univers décalé. A ne pas manquer pour les amateurs de ce genre à part !");
        $exhibit2->setBanner("carojeunet.jpg");
        $exhibit2->setDate(new \DateTime('2018-02-21 11:00:00'));

        $exhibit3 = new Exhibit();
        $exhibit3->setName("Néandertal l’expo");
        $exhibit3->setLocation("Palais de Chaillot - 17 place du Trocadéro et du 11 Novembre - 75016 Paris");
        $exhibit3->setPrice("10");
        $exhibit3->setDetails("Il y a 35 000 ans disparaissait l’Homme de Néandertal après 350 000 ans de présence sur Terre. Une morphologie robuste, un menton absent, des arcades sourcilières proéminentes… le physique de ce lointain cousin lui a valu toute sorte d’appellations jusqu’à ce qu’on le considère récemment comme un être humain à part entière. L’exposition du musée de l’Homme propose d’aller à sa rencontre et d’en finir avec ces méprises grâce à un parcours immersif adapté aux enfants où l’on apprend de manière ludique comment il vivait. Un voyage fascinant, riche en découvertes et en activités.");
        $exhibit3->setBanner("neandertal.jpg");
        $exhibit3->setDate(new \DateTime('2018-04-15 10:00:00'));


        $party1 = new Party();
        $party1->setName("Soirée Gaming");
        $party1->setLocation("5 rue Saint-Augustin - 75002 Paris");
        $party1->setPrice("2");
        $party1->setDetails("Les soirées Gaming are back in the game !  Hein quoi ? Tu ne sais pas ce qu'est une soirée Gaming ? C'est très simple : tu viens et tu joues. Mais jouer à quoi ? À ce que tu veux ! PC, consoles, jeux de société, jeux de cartes. Tu te fais plaiz'.");
        $party1->setBanner("gaming.png");
        $party1->setDate(new \DateTime("2018-03-30 21:00:00"));

        $party2 = new Party();
        $party2->setName("Soirée Jolicode");
        $party2->setLocation(" 7 rue d'argenteuil");
        $party2->setPrice("200");
        $party2->setDetails("On va faire du Jolicode, avec des gens très très doués. Et peut être même que Shrek sera de la partie.");
        $party2->setBanner("jolicode.png");
        $party2->setDate(new \DateTime("2018-03-14 21:00:00"));

        $party3 = new Party();
        $party3->setName("Soirée Reine des Neiges");
        $party3->setLocation("Château d'Arendelle");
        $party3->setPrice("10");
        $party3->setDetails("Elsa, Olaf, Kristoff et Sven préparent une fête d'anniversaire pour Anna. Cependant, la Reine des Neiges a attrapé un sacré rhume qui va lui jouer des tours lors de la préparation de la fête. Seulement, tout doit être parfait pour la Reine et rien ne saurait interrompre les festivités. Le rhume d'Elsa provoque la création des Snowgies, des petits bonhommes de neiges.");
        $party3->setBanner("elsa.png");
        $party3->setDate(new \DateTime("2018-05-14 21:00:00"));

        $weekend1 = new Weekend();
        $weekend1->setName("Weekend sur Endor");
        $weekend1->setLocation("Spaceport THX1138");
        $weekend1->setPrice("1000");
        $weekend1->setDetails("La lune d'Endor, ou simplement Endor par métonymie, est un satellite naturel. Le terrain d'Endor est en grande partie recouvert de forêts massives de pins et de séquoias. Le voyage est organisé par Star Tours, une agence de voyage interstellaire qui donne des tours aux planètes et lunes les plus importantes de la galaxie");
        $weekend1->setBanner("endor.png");
        $weekend1->setDate(new \DateTime("2018-02-17 14:30:00"));
        $weekend1->setEndDate(new \DateTime('2018-02-19 14:30:00'));

        $weekend2 = new Weekend();
        $weekend2->setName("Weekend sur Namek");
        $weekend2->setLocation("Planète Namek");
        $weekend2->setPrice("200");
        $weekend2->setDetails("Cette planète a un environnement particulier puisque la végétation y est devenue très rare à la suite d’une catastrophe climatique qui a eu lieu il y a plusieurs siècles. Les quelques habitants qui y vivent encore cultivent des arbres afin de repeupler la flore de la planète. Comme ils ne vivent que d’eau, les Nameks n’ont pas besoin de cultures vivrières et peuvent se consacrer pleinement à la reforestation de leur planète. À l'opposé de la Terre, l'herbe est bleue sur Namek alors que le ciel, l'eau, les rivières et les lacs y sont de couleur verte.");
        $weekend2->setBanner("namek.png");
        $weekend2->setDate(new \DateTime("2018-03-10 21:00:00"));
        $weekend2->setEndDate(new \DateTime('2018-03-12 14:30:00'));

        $weekend3 = new Weekend();
        $weekend3->setName("Weekend à Konoha");
        $weekend3->setLocation("Village caché des feuilles");
        $weekend3->setPrice("10");
        $weekend3->setDetails("Konoha est l'un des cinq grands villages ninjas et il est l'un des plus puissants. En tant que tel, il est l'un des cinq villages à avoir un Kage comme chef du village, connu sous le nom de Hokage. ");
        $weekend3->setBanner("croissants.png");
        $weekend3->setDate(new \DateTime("2018-05-14 21:00:00"));
        $weekend3->setEndDate(new \DateTime('2018-05-17 14:30:00'));




        $manager->persist($exhibit1);
        $manager->persist($exhibit2);
        $manager->persist($exhibit3);
        $manager->persist($party1);
        $manager->persist($party2);
        $manager->persist($party3);
        $manager->persist($weekend1);
        $manager->persist($weekend2);
        $manager->persist($weekend3);


        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('Dave');
        $user->setLastName('Lawper');
        $user->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $user->setEmail('admin@gmail.com');
        $user->setAvatar('default_avatar.jpg');
        $user->setIsAdmin(true);
        $user->setIsActive('1');
        $user->setFollowCategoryParty(true);
        $user->setFollowCategoryWeekend(false);
        $user->setFollowCategoryExhibit(true);
        $manager->persist($user);

        $userTwo = new User();
        $userTwo->setUsername('user');
        $userTwo->setFirstName('Michel');
        $userTwo->setLastName('Dupont');
        $userTwo->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userTwo->setEmail('user@gmail.com');
        $userTwo->setAvatar('default_avatar.jpg');
        $userTwo->setIsAdmin(false);
        $userTwo->setIsActive('1');
        $userTwo->setFollowCategoryParty(false);
        $userTwo->setFollowCategoryWeekend(false);
        $userTwo->setFollowCategoryExhibit(false);
        $manager->persist($userTwo);

        $manager->flush();
    }
}