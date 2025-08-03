<?php

namespace App\DataFixtures;

/** utilitaire pour récupérer les données */

use App\Entity\Client;
use App\Entity\Invoice;
use DateTimeImmutable;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // on récupère des clients pour leur relier des factures
        // comme si c'était clientRepository->findAll()
        $clients = $manager->getRepository(Client::class)->findAll();

        // vérifie qu’il y a bien des clients, sinon on stoppe la fixture
        if (empty($clients)) {
            throw new \Exception("Aucun client trouvé. Veuillez exécuter ClientFixtures d’abord.");
        }

        // on va créer des factures pour des clients aléatoires
        for ($i = 0; $i < 100; $i++) {
            $invoice = new Invoice();
            // on génère une réference unique INV-4589
            $invoice->setReference('INV-' . $faker->unique()->numberBetween(1000, 9999));
            // On génère une date qui démarre de aujourd'hui (now) - 1 an, jusqu'à maintenant
            // issuedAt est de classe DateTimeImmutable
            // faker génère un objet de format DateTime (mutable / modifiable)
            $invoice->setIssuedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween("-1 year", "now")));
            // On prend un élement aléatoire dans la liste fournie à faker
            $invoice->setStatus($faker->randomElement(['draft', 'sent', 'paid']));
            // Idem pour le client
            $invoice->setClient($faker->randomElement($clients));
            // le manager enregistre la facture de coté.
            $manager->persist($invoice);
        }

        // execute la mise en BDD
        $manager->flush();
    }
}
