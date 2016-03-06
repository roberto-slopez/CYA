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
     * @param string $name
     * @param string $lastName
     * @return array
     */
    public function getByNameAndLastName($name, $lastName) {
        $qb = $this->createQueryBuilder('quotation');
        $qb->join('quotation.client', 'client')
            ->add('where', $qb->expr()->andX(
                $qb->expr()->like('client.first_name', $qb->expr()->literal($name.'%')),
                $qb->expr()->like('client.last_name', $qb->expr()->literal($lastName.'%'))
            ))
        ;

        return $qb->getQuery()->getResult();
    }
}