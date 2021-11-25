<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    /**
     * Permet de retourner un produit en finction de la requete d'un utilisateur
     *
     * return Product[]
     * 
     */

    public function findWithSearch(Search $search){
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c');
        
        if(!empty($search->categories)){
            $query = $query
                ->andWhere( 'c.id IN (:categories)' )
                ->setParameter('categories',$search->categories );
                //dd($query);
        }

        if(!empty($search->q)){
            //$string = "%{($search->string)}%" ;
            $key = $search->q;
            $query = $query
                ->andWhere('p.name LIKE :q')
                ->setParameter('q', "%$key%"); // "%{ }%" permet d'indique a symfony que l'on veut effectuer une requete partielle.
            //dd($query);
        }

        return $query->getQuery()->getResult();
    }


    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
