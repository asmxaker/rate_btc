<?php

namespace App\Repository;

use App\Entity\Rates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rates[]    findAll()
 * @method Rates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rates::class);
    }

//    public function findAllFromCurrencyAndDate(int $currency, $date): array
//    {
//        $entityManager = $this->getEntityManager();
//        $query = $entityManager->createQuery(
//            'SELECT p
//            FROM App\Entity\Rates p
//            WHERE p.currency_id = :currency
//            AND p.created_at = :dateTime
//            LIMIT 1 ;'
//        )->setParameter('currency', $currency, 'dateTime', $date . ":00");
//
//        return $query->getResult();
//    }
}
