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
    public function findAllFromCurrencyAndDate($currency, $date): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Rates p
            WHERE p.currency_id = :currency
            AND p.created_at = :dateTime
            limit 1 '
        )->setParameter('currency', $currency, 'dateTime', $date);

        // returns an array of Product objects
        return $query->getResult();
    }
}
