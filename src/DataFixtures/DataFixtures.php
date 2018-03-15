<?php

namespace App\DataFixtures;

use App\Entity\Exposition;
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

            $exposition = new Exposition();
            $exposition->setNom("Nom Expo " . $i);
            $exposition->setLocalisation($i . " Rue Machin 7500" . $i . " Paris");
            $exposition->setPrix($i);
            $exposition->setDetails("Description de " . $i);
            $exposition->setBanner("https://picsum.photos/200/300/?image=" . $i);

            $soiree = new Soiree();
            $soiree->setNomSoiree("Nom Soirée " . $i);
            $soiree->setLocalisation($i . " Rue Machin 7500" . $i . " Paris");
            $soiree->setPrix($i);
            $soiree->setDetails("Description de " . $i);
            $soiree->setBanner("https://picsum.photos/200/300/?image=" . $i);

            $manager->persist($exposition);
            $manager->persist($soiree);

            $i++;
        }
        $manager->flush();
    }
}