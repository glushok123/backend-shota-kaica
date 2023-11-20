<?php

namespace App\Repository;

use App\Entity\Documet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Documet>
 *
 * @method Documet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documet[]    findAll()
 * @method Documet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumetRepository extends AbstractBasicRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documet::class);
    }

//    /**
//     * @return Documet[] Returns an array of Documet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Documet
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
