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

    public function getLocalCountryValue() {
        //$isLocalCountry
        $qb = $this->createQueryBuilder('exchange_rate_usd');
        $qb->join('exchange_rate_usd.coin', 'coin')
            ->where('coin.isLocalCountry =:isLocalCountry')
            ->setParameter('isLocalCountry', true)
            ->setMaxResults(1);

        return $qb->getQuery()->getResult()[0]->getLocal();
    }
}