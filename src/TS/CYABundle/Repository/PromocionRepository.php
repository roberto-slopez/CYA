<?php
/**
 * Created by @roberto-slopez
 * User: tscompany
 * Date: 7/02/16
 * Time: 04:45 PM
 */

namespace TS\CYABundle\Repository;

use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\Promocion;
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
     * @return Promocion
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

            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $examId
     * @return null|Promocion
     */
    public function getSingleByExam($examId)
    {
        try {
            $qb = $this->createQueryBuilder('promocion')
                ->join('promocion.exam', 'exam')
                ->where('exam.id =:exam_id')
                ->setParameter('exam_id', $examId)
                ->andWhere('promocion.enable = 1')
                ->setMaxResults(1);

            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $packageId
     * @return bool|Promocion
     */
    public function getSingleByPackage($packageId)
    {
        try {
            $qb = $this->createQueryBuilder('promocion')
                ->join('promocion.package', 'package')
                ->where('package.id =:package_id')
                ->setParameter('package_id', $packageId)
                ->andWhere('promocion.enable = 1')
                ->setMaxResults(1);

            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param bool|false $courseId
     * @param bool|false $packageId
     * @param bool|false $examId
     * @return bool|Promocion
     */
    public function getPromotion($courseId = false, $packageId = false, $examId = false)
    {
        try {
            $qb = $this->createQueryBuilder('promocion')
                ->andWhere('promocion.enable = 1');

            if ($courseId) {
                $qb->join('promocion.course', 'course')
                    ->where('course.id =:course_id')
                    ->setParameter('course_id', $courseId);
            } elseif ($packageId) {
                $qb->join('promocion.package', 'package')
                    ->where('package.id =:package_id')
                    ->setParameter('package_id', $packageId);
            } elseif ($examId) {
                $qb->join('promocion.exam', 'exam')
                    ->where('exam.id =:exam_id')
                    ->setParameter('exam_id', $examId);
            }

            $qb->setMaxResults(1);
            $result = $qb->getQuery()->getSingleResult();
            if ($result) {
                $result = ($result->getPercentage() * 100).'%';
            } else {
                //TODO: puede que este de mas
                $result = false;
            }
        } catch (\Exception $e) {
            return false;
        }

        return $result;
    }
}