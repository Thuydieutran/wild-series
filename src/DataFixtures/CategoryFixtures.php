<?php


namespace App\DataFixtures;


use App\Entity\Category;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends Fixture

{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
<<<<<<< HEAD
        'Horreur',
        'Comédie'
=======
        'Horreur'
>>>>>>> 667a9a384e4349c95341d6046fe37ecaffc5f751
    ];

    public function load(ObjectManager $manager)

    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();

            $category->setName($categoryName);

            $manager->persist($category);
        }  
        $manager->flush();
    }
}