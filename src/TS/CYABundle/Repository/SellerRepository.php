<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:45 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class SellerRepository
 * @package TS\CYABundle\Repository
 */
class SellerRepository extends EntityRepository
{
    /**
     * @param $userId
     * @return array
     */
    public function getByUser($userId)
    {
        $qb = $this->createQueryBuilder('seller')
            ->leftJoin('seller.userSeller', 'user')
            ->where('user.id = :user_id')
            ->setParameter('user_id', $userId)
            ->setMaxResults(1);

        return $qb->getQuery()->getResult()[0];
    }
}