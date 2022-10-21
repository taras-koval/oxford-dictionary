<?php

namespace App\DataFixtures;

use App\Entity\Searches;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 51; $i++) {
            $product = new Searches();
            $product->setWord('word '.$i);
            $product->setCnt(mt_rand(0, 100500));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
