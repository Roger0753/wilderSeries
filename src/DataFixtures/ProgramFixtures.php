<?php

namespace App\DataFixtures;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{  
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 5; $i++){
        $program = new Program();
        $program->setTitle('walking dead' .$i);
        $program->setSynopsis('Des zombies envahissent la terre' .$i);
        $program->setCategory($this->getReference('category_Action' ));
        $manager->persist($program);
    }
       
        $manager->flush();

    }
    public function getDependencies(){
        return [
            CategoryFixtures::class,
        ];
    }
}
