<?php

namespace App\Repository;

use App\Entity\Ekdi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ekdi>
 *
 * @method Ekdi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ekdi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ekdi[]    findAll()
 * @method Ekdi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EkdiRepository extends AbstractBasicRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ekdi::class);
    }

    public function getCollectionEkdi1(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.code LIKE :val')
            ->setParameter('val', '%.00.00.00.%')
            ->getQuery()
            ->getResult();
    }
    public function getCollectionEkdi2($value): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.code LIKE :val')
            ->setParameter('val', $value . '.__.00.00.')
            ->getQuery()
            ->getResult();
    }

    public function getCollectionEkdi3($value): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.code LIKE :val')
            ->setParameter('val', $value . '.__.00.')
            ->getQuery()
            ->getResult();
    }

    public function getCollectionEkdi4($value): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.code LIKE :val')
            ->setParameter('val', $value . '.__.')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Ekdi[] Returns an array of Ekdi objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ekdi
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
