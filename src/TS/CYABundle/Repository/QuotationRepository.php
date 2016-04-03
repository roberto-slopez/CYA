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
use TS\CYABundle\Entity\Quotation;

/**
 * Class QuotationRepository
 * @package TS\CYABundle\Repository
 */
class QuotationRepository extends EntityRepository
{
    /**
     * @param $limit
     * @param null $type
     * @return array
     */
    public function getLastRecords($limit, $type = null)
    {
        $qb = $this->createQueryBuilder('quotation');

        if ($type) {
            $qb->where('quotation.type =:typeQuotation')->setParameter('typeQuotation', $type);
        }
        $qb->orderBy('quotation.updatedAt', 'desc');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $name
     * @param $lastName
     * @param bool|false $sellerId
     * @return array
     */
    public function getByNameAndLastName($name, $lastName, $sellerId = false) {
        $qb = $this->createQueryBuilder('quotation');
        $qb->join('quotation.client', 'client');
        $qb->orderBy('client.first_name');

        if (boolval($name)) {
            $qb->andWhere('client.first_name LIKE :first_name');
            $qb->setParameter('first_name', $name.'%');

        }
        if (boolval($lastName)) {
            $qb->andWhere('client.last_name LIKE :last_name');
            $qb->setParameter('last_name', '%'.$lastName);
        }

        if (boolval($sellerId)) {
            $qb->andWhere('quotation.createdBy =:idSeller')
            ->setParameter('idSeller', $sellerId);
        }

        return $qb->getQuery()->getResult();
    }
}