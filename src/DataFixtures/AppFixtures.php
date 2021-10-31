<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        
        $faker = \Faker\Factory::create('FR-_fr');
        //$faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        //$faker->addProvider(new \Liior\Faker\Prices($faker));

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setTitle($faker->name)
                ->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 200))
                ->setImage($faker->imageUrl(400, 400));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
