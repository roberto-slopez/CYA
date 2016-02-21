<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 11:24 AM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CoinRepository
 * @package TS\CYABundle\Repository
 */
class CoinRepository extends EntityRepository
{
    /**
     * @param null $exception code coin
     * @return mixed
     */
    public function getCount($exception = null)
    {
        $qb = $this->createQueryBuilder('coin')
            ->select('count(coin.id)');

        if ($exception) {
            $qb->where('coin.code != :code')->setParameter('code', $exception);
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}