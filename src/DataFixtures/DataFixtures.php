<?php

namespace App\DataFixtures;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\User;
use App\Entity\Weekend;
use App\Entity\Photo;
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
        $user->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $user->setEmail('test@gmail.com');
        $user->setAvatar('default_avatar.jpg');
        $user->setIsAdmin(true);
        $user->setIsActive('1');

        $manager->persist($user);

        $manager->flush();


    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $exhibit1 = new Exhibit();
        $exhibit1->setName("TERRA DATA, nos vies à l’ère du numérique");
        $exhibit1->setLocation("30 avenue Corentin Cariou - 75019 Paris");
        $exhibit1->setPrice("5");
        $exhibit1->setDetails("La Cité des Sciences et de l’Industrie présente du 4 avril 2017 au 7 janvier 2018, « Terra Data, nos vies à l’ère du numérique ». Conçue initialement pour les élèves de la 6e à la terminale, cette exposition ouverte à tous publics, permet de cerner de façon ludique ce qu’est le big data. Avec le numérique qui nous permet de quantifier et mesurer précisément l’univers qui nous entoure, il est désormais devenu nécessaire pour les jeunes d’intégrer ces notions en vue de futures carrières professionnelles de plus en plus digitalisées. Le public est invité à découvrir les méthodes, outils et applications liées à ce sujet et cerner les enjeux de cette nouvelle guerre de l’information.");
        $exhibit1->setBanner("5abcd6efcc45c260216574.jpg");
        $exhibit1->setDate(new \DateTime('2018-03-14 14:00:00'));

        $exhibit2 = new Exhibit();
        $exhibit2->setName("Caro / Jeunet");
        $exhibit2->setLocation("2 rue Ronsard - 75018 Paris");
        $exhibit2->setPrice("7");
        $exhibit2->setDetails("La Halle Saint-Pierre expose pour la première fois les œuvres et pépites d’un binôme de choc : les réalisateurs français Jean-Pierre Jeunet et Marc Caro. Co-réalisateurs du primé Delicatessen et de l’étrange La Cité des enfants perdus, les deux hommes prêtent pour l’occasion des objets « singuliers » de leur collection personnelle respective. Extraits de films, objets, costumes et documents accompagnent ces trésors, pour plonger les visiteurs dans leur univers décalé. A ne pas manquer pour les amateurs de ce genre à part !");
        $exhibit2->setBanner("5abcf048c6a84588964304.jpg");
        $exhibit2->setDate(new \DateTime('2018-02-21 11:00:00'));

        $exhibit3 = new Exhibit();
        $exhibit3->setName("Néandertal l’expo");
        $exhibit3->setLocation("Palais de Chaillot - 17 place du Trocadéro et du 11 Novembre - 75016 Paris");
        $exhibit3->setPrice("10");
        $exhibit3->setDetails("Il y a 35 000 ans disparaissait l’Homme de Néandertal après 350 000 ans de présence sur Terre. Une morphologie robuste, un menton absent, des arcades sourcilières proéminentes… le physique de ce lointain cousin lui a valu toute sorte d’appellations jusqu’à ce qu’on le considère récemment comme un être humain à part entière. L’exposition du musée de l’Homme propose d’aller à sa rencontre et d’en finir avec ces méprises grâce à un parcours immersif adapté aux enfants où l’on apprend de manière ludique comment il vivait. Un voyage fascinant, riche en découvertes et en activités.");
        $exhibit3->setBanner("5abcd6cfd0aac275456020.jpg");
        $exhibit3->setDate(new \DateTime('2018-04-15 10:00:00'));


        $party1 = new Party();
        $party1->setName("Soirée Gaming");
        $party1->setLocation("5 rue Saint-Augustin - 75002 Paris");
        $party1->setPrice("2");
        $party1->setDetails("Les soirées Gaming are back in the game !  Hein quoi ? Tu ne sais pas ce qu'est une soirée Gaming ? C'est très simple : tu viens et tu joues. Mais jouer à quoi ? À ce que tu veux ! PC, consoles, jeux de société, jeux de cartes. Tu te fais plaiz'.");
        $party1->setBanner("5abcee816926c933704431.jpg");
        $party1->setDate(new \DateTime("2018-03-30 21:00:00"));



        $party2 = new Party();
        $party2->setName("Soirée Jolicode");
        $party2->setLocation(" 7 rue d'argenteuil");
        $party2->setPrice("200");
        $party2->setDetails("On va faire du Jolicode, avec des gens très très doués. Et peut être même que Shrek sera de la partie.");
        $party2->setBanner("5abcd69e3005c343706488.jpeg");
        $party2->setDate(new \DateTime("2018-03-14 21:00:00"));




        $party3 = new Party();
        $party3->setName("Soirée Reine des Neiges");
        $party3->setLocation("Château d'Arendelle");
        $party3->setPrice("10");
        $party3->setDetails("Elsa, Olaf, Kristoff et Sven préparent une fête d'anniversaire pour Anna. Cependant, la Reine des Neiges a attrapé un sacré rhume qui va lui jouer des tours lors de la préparation de la fête. Seulement, tout doit être parfait pour la Reine et rien ne saurait interrompre les festivités. Le rhume d'Elsa provoque la création des Snowgies, des petits bonhommes de neiges.");
        $party3->setBanner("5abcd6822f4a4917685503.jpg");
        $party3->setDate(new \DateTime("2018-05-14 21:00:00"));

        $weekend1 = new Weekend();
        $weekend1->setName("Weekend sur Endor");
        $weekend1->setLocation("Spaceport THX1138");
        $weekend1->setPrice("1000");
        $weekend1->setDetails("La lune d'Endor, ou simplement Endor par métonymie, est un satellite naturel. Le terrain d'Endor est en grande partie recouvert de forêts massives de pins et de séquoias. Le voyage est organisé par Star Tours, une agence de voyage interstellaire qui donne des tours aux planètes et lunes les plus importantes de la galaxie");
        $weekend1->setBanner("5abcd7df6638c644400967.jpeg");
        $weekend1->setDate(new \DateTime("2018-02-17 14:30:00"));
        $weekend1->setEndDate(new \DateTime('2018-02-19 14:30:00'));

        $weekend2 = new Weekend();
        $weekend2->setName("Weekend sur Namek");
        $weekend2->setLocation("Planète Namek");
        $weekend2->setPrice("200");
        $weekend2->setDetails("Cette planète a un environnement particulier puisque la végétation y est devenue très rare à la suite d’une catastrophe climatique qui a eu lieu il y a plusieurs siècles. Les quelques habitants qui y vivent encore cultivent des arbres afin de repeupler la flore de la planète. Comme ils ne vivent que d’eau, les Nameks n’ont pas besoin de cultures vivrières et peuvent se consacrer pleinement à la reforestation de leur planète. À l'opposé de la Terre, l'herbe est bleue sur Namek alors que le ciel, l'eau, les rivières et les lacs y sont de couleur verte.");
        $weekend2->setBanner("5abcd7c7b458c541481821.gif");
        $weekend2->setDate(new \DateTime("2018-03-10 21:00:00"));
        $weekend2->setEndDate(new \DateTime('2018-03-12 14:30:00'));

        $weekend3 = new Weekend();
        $weekend3->setName("Weekend à Konoha");
        $weekend3->setLocation("Village caché des feuilles");
        $weekend3->setPrice("10");
        $weekend3->setDetails("Konoha est l'un des cinq grands villages ninjas et il est l'un des plus puissants. En tant que tel, il est l'un des cinq villages à avoir un Kage comme chef du village, connu sous le nom de Hokage. ");
        $weekend3->setBanner("5abcd9850ed1c989345074.jpg");
        $weekend3->setDate(new \DateTime("2018-05-12 21:00:00"));
        $weekend3->setEndDate(new \DateTime('2018-05-15 14:30:00'));




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
        $userTwo->setFirstName('Jessica');
        $userTwo->setLastName('Mehameha');
        $userTwo->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userTwo->setEmail('user@gmail.com');
        $userTwo->setAvatar('default_avatar.jpg');
        $userTwo->setIsAdmin(false);
        $userTwo->setIsActive('1');
        $userTwo->setFollowCategoryParty(false);
        $userTwo->setFollowCategoryWeekend(false);
        $userTwo->setFollowCategoryExhibit(false);
        $manager->persist($userTwo);


        $userThree= new User();
        $userThree->setUsername('HarryDick');
        $userThree->setFirstName('Harry');
        $userThree->setLastName('Dick');
        $userThree->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userThree->setEmail('HarryDick@gmail.com');
        $userThree->setAvatar('default_avatar.jpg');
        $userThree->setIsAdmin(false);
        $userThree->setIsActive('1');
        $userThree->setFollowCategoryParty(false);
        $userThree->setFollowCategoryWeekend(false);
        $userThree->setFollowCategoryExhibit(false);
        $manager->persist($userThree);

        $userFour= new User();
        $userFour->setUsername('PHP');
        $userFour->setFirstName('Phillipe Henry');
        $userFour->setLastName('Pheng');
        $userFour->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userFour->setEmail('PhillipeHenryPheng@gmail.com');
        $userFour->setAvatar('default_avatar.jpg');
        $userFour->setIsAdmin(true);
        $userFour->setIsActive('1');
        $userFour->setFollowCategoryParty(false);
        $userFour->setFollowCategoryWeekend(false);
        $userFour->setFollowCategoryExhibit(false);
        $manager->persist($userFour);

        $userFive= new User();
        $userFive->setUsername('CheVal');
        $userFive->setFirstName('Valentin');
        $userFive->setLastName('Chevalier');
        $userFive->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userFive->setEmail('CheVal@gmail.com');
        $userFive->setAvatar('default_avatar.jpg');
        $userFive->setIsAdmin(false);
        $userFive->setIsActive('1');
        $userFive->setFollowCategoryParty(false);
        $userFive->setFollowCategoryWeekend(false);
        $userFive->setFollowCategoryExhibit(false);
        $manager->persist($userFive);

        $userSix= new User();
        $userSix->setUsername('FabulousFab');
        $userSix->setFirstName('Fabien');
        $userSix->setLastName('Potencier');
        $userSix->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userSix->setEmail('FabPot@gmail.com');
        $userSix->setAvatar('default_avatar.jpg');
        $userSix->setIsAdmin(false);
        $userSix->setIsActive('1');
        $userSix->setFollowCategoryParty(false);
        $userSix->setFollowCategoryWeekend(false);
        $userSix->setFollowCategoryExhibit(false);
        $manager->persist($userSix);

        $userSeven= new User();
        $userSeven->setUsername('UbUntu');
        $userSeven->setFirstName('Uub');
        $userSeven->setLastName('Untu');
        $userSeven->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $userSeven->setEmail('UubUntu@gmail.com');
        $userSeven->setAvatar('default_avatar.jpg');
        $userSeven->setIsAdmin(false);
        $userSeven->setIsActive('1');
        $userSeven->setFollowCategoryParty(false);
        $userSeven->setFollowCategoryWeekend(false);
        $userSeven->setFollowCategoryExhibit(false);
        $manager->persist($userSeven);
      

        $photo = new Photo();
        $photo->setPhoto('5abdf4fd44a9d140863487.jpg');
        $photo->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo->addPhotoExhibit($exhibit2);
        $manager->persist($photo);

        $photo2 = new Photo();
        $photo2->setPhoto('5abdf5f55e261479941221.jpg');
        $photo2->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo2->addPhotoExhibit($exhibit2);
        $manager->persist($photo2);

        $photo3 = new Photo();
        $photo3->setPhoto('5abdf62b52bb0446033939.jpg');
        $photo3->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo3->addPhotoExhibit($exhibit2);
        $manager->persist($photo3);

        $photo4 = new Photo();
        $photo4->setPhoto('5abdf69b812f8549716766.jpg');
        $photo4->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo4->addPhotoExhibit($exhibit1);
        $manager->persist($photo4);

        $photo5 = new Photo();
        $photo5->setPhoto('5abdf75e238c4588024317.jpg');
        $photo5->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo5->addPhotoParty($party1);
        $manager->persist($photo5);

        $photo6 = new Photo();
        $photo6->setPhoto('5abdf790a1cdd069530308.jpg');
        $photo6->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo6->addPhotoParty($party1);
        $manager->persist($photo6);

        $photo7 = new Photo();
        $photo7->setPhoto('5abdf7dee6ee0912572257.jpg');
        $photo7->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo7->addPhotoParty($party1);
        $manager->persist($photo7);

        $photo8 = new Photo();
        $photo8->setPhoto('5abdf846ccce1268378630.jpg');
        $photo8->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo8->addPhotoParty($party1);
        $manager->persist($photo8);

        $photo9 = new Photo();
        $photo9->setPhoto('5abdf870c6fc8442519918.jpg');
        $photo9->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo9->addPhotoParty($party1);
        $manager->persist($photo9);

        $photo10 = new Photo();
        $photo10->setPhoto('5abdf8afb27db469920311.png');
        $photo10->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo10->addPhotoParty($party2);
        $manager->persist($photo10);

        $photo11 = new Photo();
        $photo11->setPhoto('5abdf9620114d980981674.jpg');
        $photo11->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo11->addPhotoWeekend($weekend2);
        $manager->persist($photo11);

        $photo12 = new Photo();
        $photo12->setPhoto('5abdf9d949dec529894079.jpg');
        $photo12->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo12->addPhotoWeekend($weekend2);
        $manager->persist($photo12);

        $photo13 = new Photo();
        $photo13->setPhoto('5abdfa1af3d06492112251.jpg');
        $photo13->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo13->addPhotoWeekend($weekend2);
        $manager->persist($photo13);

        $photo14 = new Photo();
        $photo14->setPhoto('5abdfb0f2873a517206158.jpg');
        $photo14->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo14->addPhotoWeekend($weekend1);
        $manager->persist($photo14);

        $photo15 = new Photo();
        $photo15->setPhoto('5abdfb3326c33315518533.jpg');
        $photo15->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo15->addPhotoWeekend($weekend1);
        $manager->persist($photo15);

        $photo16 = new Photo();
        $photo16->setPhoto('5abdfb5bbf032519389069.jpg');
        $photo16->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo16->addPhotoWeekend($weekend1);
        $manager->persist($photo16);

        $photo17 = new Photo();
        $photo17->setPhoto('5abdfb8eb8538059665151.jpg');
        $photo17->setUpdatedAt(new \DateTime("2018-03-29 21:00:00"));
        $photo17->addPhotoWeekend($weekend1);
        $manager->persist($photo17);



        $manager->flush();

    }
}