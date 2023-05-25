<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    
    {
        $faker = Factory::create();
       for($i = 0;$i <= 10 ; $i++){
            $programReference = 'Program_' . $i;
            for($j=0;$j <= 5; $j++){
                $season = new Season();
                $season->setNumber($j +1);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $i));
                $this->addReference('season_' .$i .'_'.$j, $season);
                $manager->persist($season);
            }
       }

        $manager->flush();
    }
    public function getDependencies(){
        return [
            ProgramFixtures::class,
        ];
    }
}
