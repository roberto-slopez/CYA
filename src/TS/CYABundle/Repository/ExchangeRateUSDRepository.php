<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:39 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ExchangeRateUSDRepository
 * @package TS\CYABundle\Repository
 */
class ExchangeRateUSDRepository extends EntityRepository
{
    /**
     * @param $coindId
     * @return mixed
     */
    public function getCurrentExchangeRateUSDByCoinId($coindId)
    {
        $qb = $this->createQueryBuilder('exchange_rate_usd');
        $qb->join('exchange_rate_usd.coin', 'coin')
            ->where('coin.id =:coindId')
            ->setParameter('coindId', $coindId)
            ->orderBy('exchange_rate_usd.date', 'asc')
            ->setMaxResults(1);

        return $qb->getQuery()->getResult()[0]->getLocal();
    }

    /**
     * @return mixed
     */
    public function getLocalCountryValue()
    {
        $qb = $this->createQueryBuilder('exchange_rate_usd');
        $qb->join('exchange_rate_usd.coin', 'coin')
            ->where('coin.isLocalCountry =:isLocalCountry')
            ->setParameter('isLocalCountry', true)
            ->setMaxResults(1);

        $result = $qb->getQuery()->getResult();

        return $result[0]->getLocal();
    }

    /**
     * @param \DateTime $today
     * @return mixed
     */
    public function getExchangeRateToday(\DateTime $today)
    {
        $qb = $this->createQueryBuilder('exchange_rate_usd')
            ->select('count(exchange_rate_usd.id)')
            ->where('exchange_rate_usd.date = :today')
            ->setParameter('today', $today->format('Y-m-d'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param \DateTime $today
     * @return mixed
     */
    public function getAllExchangeRateToday(\DateTime $today)
    {
        $qb = $this->createQueryBuilder('exchange_rate_usd')
            ->where('exchange_rate_usd.date = :today')
            ->setParameter('today', $today->format('Y-m-d'));

        return $qb->getQuery()->getResult();
    }
}