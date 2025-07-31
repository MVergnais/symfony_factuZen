<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findByCompanyName(string $companyName): array
    {
        return $this->createQueryBuilder('c')
            /**'c' équivaut à client */
            ->where('c.companyName LIKE :companyName')
            ->setParameter('companyName', $companyName . '%')
            /** équivaut à "commence par" */
            ->orderBy('c.companyName', 'ASC')
            ->getQuery()
            ->getResult();
    }



    /**
     * Exercice 3 – Recherche par nom d’entreprise
     * Créer une méthode personnalisée dans ClientRepository (avec un LIKE)
     *Créer une route /clients/search?name=…
     *Utiliser une requête GET pour filtrer les résultats
     */

    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
