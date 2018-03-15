<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Soiree;
use App\Entity\User;
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

            $manager->persist($soiree);

            $i++;
        }
        $manager->flush();
    }
}