<?php

namespace App\Repository;

use App\Entity\ServiceProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceProvider>
 */
class ServiceProviderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceProvider::class);
    }

    //    /**
    //     * @return ServiceProvider[] Returns an array of ServiceProvider objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ServiceProvider
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


     public function searchEngine(string $query){
            //crée un objet de la requete qui permet de construire la requete de recherche
            return $this->createQueryBuilder('p')
            //recherche les elements dont le nom contient la requete de la recherche
                ->where('p.serviceOffered LIKE :query')
                // OU recherche les elements dont la description contient la requete de recherche
                // ->orWhere('p.serviceOffered LIKE :query')
                // //defini la valeur de la variable "query" pour la requete
                ->setParameter('query', '%' . $query . '%')
                //execute la requete et recupere les resultats
                ->getQuery()
                ->getResult();
        }
}
