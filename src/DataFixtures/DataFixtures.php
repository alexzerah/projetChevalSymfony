<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword('$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC');
        $user->setEmail('test@gmail.com');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setIsActive('1');

        $manager->persist($user);

        $manager->flush();


    }


    public function user(ObjectManager $manager)
    {
        $i = 1;
        while($i < 100){
            $post = new Post();
            $post->setTitle("Title de l'article n°" . $i);
            $post->setBody("Contenue de l'article n°" . $i);
            $post->setisPublished($i%2);

            $manager->persist($post);

            $i++;
        }
        $manager->flush();
    }
}