<?php

namespace App\Repository;

use App\Entity\Valeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Valeur>
 */
class ValeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valeur::class);
    }

    public function findByEntrepriseDate(int $idEntreprise, Date $date, String $type): array
    {
        $afficheDate = $date->format('Y-m-d');

        $qb = $this->createQueryBuilder('v')
            ->innerJoin('v.entreprise', 'e')
            ->innerJoin('v.date', 'd')
            ->where('e.id = :id')
            ->andWhere('d.valeur >= :date')
            ->andWhere('d.type = ":type"')
            ->setParameter('id', $idEntreprise)
            ->setParameter('date', $afficheDate)
            ->setParameter('type', $type)
            ->orderBy('d.valeur', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }

    //    /**
    //     * @return Valeur[] Returns an array of Valeur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Valeur
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
