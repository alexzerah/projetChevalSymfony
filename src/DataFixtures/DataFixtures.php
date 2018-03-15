<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Soiree;
use App\Entity\User;
use App\Entity\Weekend;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $i = 1;
        while($i < 50){

            $soiree = new Soiree();
            $soiree->setNomSoiree("Nom Soiree" . $i);
            $soiree->setLocalisation($i . " Rue Machin 7500" . $i . " Paris");
            $soiree->setPrix($i);
            $soiree->setDetails("Description de " . $i);
            $soiree->setBanner("https://picsum.photos/200/300/?image=" . $i);

            $weekend = new Weekend();
            $weekend->setNom("Nom du weekend " . $i);
            $weekend->setLocalisation($i . " Rue Truc 7500" . $i . " Paris");
            $weekend->setPrix($i);
            $weekend->setDetails("Description de " . $i);
            $weekend->setBanner("https://picsum.photos/200/300/?image=" . $i);

            $manager->persist($soiree);
            $manager->persist($weekend);

            $i++;
        }
        $manager->flush();
    }
}