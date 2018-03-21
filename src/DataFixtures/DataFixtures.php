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
        $i = 1;
        while ($i <= 10) {

            $exhibit = new Exhibit();
            $exhibit->setName("Nom Expo " . $i);
            $exhibit->setLocation($i . " Rue Machin 7500" . $i . " Paris");
            $exhibit->setPrice($i);
            $exhibit->setDetails("Description de " . $i);
            $exhibit->setBanner("croissants.png");

            $party = new Party();
            $party->setName("Nom Soirée " . $i);
            $party->setLocation($i . " Rue Machin 7500" . $i . " Paris");
            $party->setPrice($i);
            $party->setDetails("Description de " . $i);
            $party->setBanner("croissants.png");

            $weekend = new Weekend();
            $weekend->setName("Nom du weekend " . $i);
            $weekend->setLocation($i . " Rue Truc 7500" . $i . " Paris");
            $weekend->setPrice($i);
            $weekend->setDetails("Description de " . $i);
            $weekend->setBanner("croissants.png");

            $manager->persist($exhibit);
            $manager->persist($party);
            $manager->persist($weekend);

            $i++;
        }

        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('Dave');
        $user->setLastName('Lawper');
        $user->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $user->setEmail('admin@gmail.com');
        $user->setAvatar('default_avatar.jpg');
        $user->setIsAdmin(true);
        $user->setIsActive('1');
        $user->setParty(true);
        $user->setWeekend(false);
        $user->setExhibit(true);
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
        $userTwo->setParty(false);
        $userTwo->setWeekend(false);
        $userTwo->setExhibit(false);
        $manager->persist($userTwo);

        $manager->flush();
    }
}