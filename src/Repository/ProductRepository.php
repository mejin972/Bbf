<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByCategory($category)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category_id = :val')
            ->setParameter('val', $category)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;  
    }

    public function findByGenre($genre,$mix)
    {
        return $this->createQueryBuilder('p')
            ->Where('p.genre = :val')
            ->orWhere('p.genre = :mix')
            ->setParameter('val', $genre)   
            ->setParameter('mix', $mix)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;  
    }

    public function findByName($name,$category)
    {
        $key = $name;

        $query = $this
            ->createQueryBuilder('p')
            ->andWhere('p.name LIKE :q')
            ->setParameter('q', "%$key%")
            ->andWhere('p.category_id = :val')
            ->setParameter('val', $category)
        ;

        //dd($query);
        return $query->getQuery()->getResult();
        /*
       $key = $name;
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :r')
            ->setParameter('r',"%$key%")
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;*/

    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
