<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Client;

/**on utilise client */

use Faker\Factory;

/** on utilise faker */

/** Methode */
class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $client = new Client();
            $client
                ->setCompanyName($faker->company())
                ->setContactName($faker->name())
                ->setEmail($faker->email())
                ->setPhone($faker->phoneNumber());
            $manager->persist($client);
        }
        $manager->flush();
    }
}
