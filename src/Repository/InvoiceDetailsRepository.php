<?php

namespace App\Repository;

use App\Entity\InvoiceDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InvoiceDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceDetails[]    findAll()
 * @method InvoiceDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceDetails::class);
    }

    // /**
    //  * @return InvoiceDetails[] Returns an array of InvoiceDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InvoiceDetails
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
