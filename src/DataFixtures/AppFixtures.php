<?php

// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Person($faker));
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        $actors = $faker->actors($gender = null, $count = 100, $duplicates = false);

        foreach ($actors as $item) {
            $fullName = $faker->actor; // Assuming $faker->actor returns a full name
            $nameParts = explode(' ', $fullName);
            $actor = new Actor();
            $actor->setLastname($nameParts[1] ?? ''); // Assuming the last name is the second part
            $actor->setFirstname($nameParts[0] ?? ''); // Assuming the first name is the first part
            $actor->setDob(new \DateTime('2012-03-03'));
            $actor->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($actor);

            $movie = new Movie();
            $movie->setTitle($faker->title);
            $movie->addActor($actor); // Assuming addActor method requires an Actor parameter
            $manager->persist($movie);
        }
        $manager->flush();
    }
}
