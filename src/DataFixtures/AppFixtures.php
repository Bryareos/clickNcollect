<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $fastFood = new Category();
        $name = 'Fast Food';
        $fastFood->setName($name);
        $slugify = new Slugify();
        $fastFood->setSlug($slugify->slugify($name));

        $manager->persist($fastFood);

        $bigMac = new Product();
        $bigMac->setName('Big Mac');
        $bigMac->setDescription('Le big mac le seul l\'unique, le classique');
        $bigMac->setPrice(4);
        $bigMac->setQuantity(10);
        $bigMac->setCategoryId($fastFood);
        $manager->flush();
    }
}
