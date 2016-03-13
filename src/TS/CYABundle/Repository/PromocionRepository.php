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
 * Class PromocionRepository
 * @package TS\CYABundle\Repository
 */
class PromocionRepository extends EntityRepository
{
    /**
     * @param $courseId
     * @return array
     */
    public function getByCourse($courseId)
    {
        $qb = $this->createQueryBuilder('promocion')
            ->join('promocion.course', 'course');
        $qb->where('course.id =:course_id')
            ->setParameter('course_id', $courseId);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param $courseId
     * @return array
     */
    public function getSingleByCourse($courseId)
    {
        try {
            $qb = $this->createQueryBuilder('promocion')
                ->join('promocion.course', 'course')
                ->where('course.id =:course_id')
                ->setParameter('course_id', $courseId)
                ->andWhere('promocion.enable = 1')
                ->setMaxResults(1);

            return $qb->getQuery()->getSingleScalarResult();
        } catch (\Exception $e) {
            return false;
        }
    }
}