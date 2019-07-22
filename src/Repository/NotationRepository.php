<?php

namespace App\Repository;

use App\Entity\Notation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notation[]    findAll()
 * @method Notation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notation::class);
    }

    // /**
    //  * @return Notation[] Returns an array of Notation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notation
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getAllCommentsButMine($userId = 0)
    {
        return  $this->createQueryBuilder('n')
            ->innerJoin('n.giver', 'g')
            ->addSelect('g.avatar as avatar')
            ->addSelect('n.rating as rating')
            ->addSelect('g.lastName as lastName')
            ->addSelect('n.comment as comment')
            ->addSelect('g.firstName as firstName')
            ->andWhere('g.id != :val')
            ->setParameter('val', $userId)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
