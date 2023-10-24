<?php

namespace App\Repository;

use App\Entity\Kitchen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kitchen>
 *
 * @method Kitchen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kitchen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kitchen[]    findAll()
 * @method Kitchen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KitchenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kitchen::class);
    }

//    /**
//     * @return Kitchen[] Returns an array of Kitchen objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Kitchen
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
