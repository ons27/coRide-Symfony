<?php

namespace App\Repository;

use App\Entity\Moyentransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Moyentransport>
 *
 * @method Moyentransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moyentransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moyentransport[]    findAll()
 * @method Moyentransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoyentransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moyentransport::class);
    }

    public function save(Moyentransport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Moyentransport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Moyentransport[] Returns an array of Moyentransport objects
//     */
//    public function findById($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.id = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Moyentransport
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
