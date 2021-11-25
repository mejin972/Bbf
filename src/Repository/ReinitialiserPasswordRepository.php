<?php

namespace App\Repository;

use App\Entity\ReinitialiserPassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReinitialiserPassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReinitialiserPassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReinitialiserPassword[]    findAll()
 * @method ReinitialiserPassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReinitialiserPasswordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReinitialiserPassword::class);
    }

    // /**
    //  * @return ReinitialiserPassword[] Returns an array of ReinitialiserPassword objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReinitialiserPassword
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
