<?php

namespace App\DataFixtures;

use App\Entity\Searches;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $wordsArray = [
            "flippant",
            "voyage",
            "rabbits",
            "fasten",
            "pricey",
            "want",
            "pizzas",
            "scintillating",
            "handle",
            "branch",
            "picture",
            "long-term",
            "automatic",
            "steel",
            "flagrant",
            "retire",
            "disappear",
            "plain",
            "confuse",
            "zany",
            "guess",
            "end",
            "bed",
            "back",
            "stay",
            "hall",
            "excellent",
            "alive",
            "wreck",
            "flood",
            "obtainable",
            "handy",
            "little",
            "title",
            "box",
            "skirt",
            "fancy",
            "different",
            "sound",
            "blue",
            "force",
            "weigh",
            "drip",
            "ritzy",
            "fold",
            "vigorous",
            "nest",
            "tooth",
            "axiomatic",
            "man",
            "pastoral",
            "silver",
            "cruel",
            "imaginary",
            "friend",
            "rustic",
            "shape",
            "guarantee",
            "cool",
            "correct",
            "rambunctious",
            "halting",
            "error",
            "toys",
            "baby",
            "add",
            "brake",
            "cough",
            "fork",
            "nutty",
            "nerve",
            "please",
            "twig",
            "unique",
            "rejoice",
            "soap",
            "match",
            "satisfying",
            "agonizing",
            "babies",
            "shaggy",
            "right",
            "sharp",
            "kindhearted",
            "view",
            "attract",
            "key",
            "earthy",
            "collect",
            "mundane",
            "cheap",
            "painstaking",
            "hollow",
            "chief",
            "average",
            "wood",
            "cheat",
            "desert",
            "warm",
            "decorous",
        ];
        for ($i = 0; $i < 99; $i++) {
            $product = new Searches();
            $product->setWord($wordsArray[$i] );
            $product->setCnt(mt_rand(0, 500));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
