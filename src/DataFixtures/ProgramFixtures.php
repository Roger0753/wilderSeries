<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Program;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{  
    public function load(ObjectManager $manager): void
    {   $faker = Factory::create();

        for ($i = 0; $i <=10; $i++){
        $program = new Program();
        $program->settitle($faker->title());
        $program->setSynopsis($faker->paragraphs(1 ,true));
        $program->setCountry($faker->country());
        $program->setYear($faker->year());
        $program->setPoster('https://picsum.photos/id/237/200/300');
        $radomCategoryKey = array_rand(CategoryFixtures::CATEGORIES);
        $categoryName = CategoryFixtures::CATEGORIES[$radomCategoryKey];
        $program->setCategory($this->getReference('category_' .$categoryName ));
        $this->addReference('program_' .$i, $program);
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
