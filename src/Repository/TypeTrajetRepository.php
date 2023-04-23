<?php

namespace App\Repository;

use App\Entity\TypeTrajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Entity\PersistentCollection;
use Doctrine\Persistence\Entity\PersistentEntity;

/**
 * @extends ServiceEntityRepository<TypeTrajet>
 *
 * @method TypeTrajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTrajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTrajet[]    findAll()
 * @method TypeTrajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTrajet::class);
    }

    public function save(TypeTrajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeTrajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TypeTrajet[] Returns an array of TypeTrajet objects
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

//    public function findOneBySomeField($value): ?TypeTrajet
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
