<?php

namespace App\Repository;

use App\Entity\Titre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Titre>
 *
 * @method Titre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Titre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Titre[]    findAll()
 * @method Titre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Titre::class);
    }


    public function pagination(int $page): array{

        $size = 4;
        $first = ($page-1)*$size;
        $qb = $this->createQueryBuilder("t")
                   ->setFirstResult($first)
                   ->setMaxResults($size);

        return $qb->getQuery()->getResult();
    }

    /**
     * DQL
     */
    public function findByTitre(string $titre): array{
        $em = $this->getEntityManager();
        $dql = "SELECT t FROM App\Entity\Titre t WHERE t.nom LIKE :titre";
        $query = $em->createQuery($dql);
        $query->setParameter("titre","%".$titre."%");
        $query->setMaxResults(5);
        return $query->getResult();
    }
    /**
     * QueryBuilder
     */
    public function search(string $keyword,array $conditions): array{
        $qb = $this->createQueryBuilder("t");

        $flag = false;
        foreach( $conditions as $key => $val ){
            if($val){
                $qb->orWhere("t.$key LIKE :keyword");
                $flag=true;
            }
        }

        if($flag){
            $qb->setParameter('keyword','%'.$keyword.'%');
        }
        $query = $qb->getQuery();
     
        return $query->getResult();
    }

//    /**
//     * @return Titre[] Returns an array of Titre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Titre
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
