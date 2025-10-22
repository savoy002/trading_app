<?php

namespace App\Repository;

use App\Entity\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Date>
 */
class DateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Date::class);
    }

    public function findByEntreprise(int $id, ?String $type = null): array
    {
        $qb = $this->createQueryBuilder('d')
            ->innerJoin('d.valeurs', 'v')
            ->innerJoin('v.entreprise', 'e')
            ->where("e.id = :id")
            ->setParameter('id', $id)
            ->orderBy('d.valeur', 'ASC');

        if($type != null) {
            $qb->andWhere("d.type = :type")
                ->setParameter('type', $type);
        }

        $query = $qb->getQuery();

        return $query->execute();
    }

//    /**
//     * @return Date[] Returns an array of Date objects
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

//    public function findOneBySomeField($value): ?Date
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
