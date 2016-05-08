<?php

namespace TS\CYABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Doctrine\ORM\Query;
use TS\CYABundle\Entity\Agency;
use TS\CYABundle\Entity\Course;
use TS\CYABundle\Entity\ExchangeRateUSD;
use TS\CYABundle\Entity\Quotation;
use TS\CYABundle\Entity\Service;
use TS\CYABundle\Entity\Usuario;

/**
 * Class BaseController
 * @package TS\Cian\MainBundle\Controller
 */
class BaseController extends Controller
{
    /**
     * @return Usuario
     */
    public function getCurrenUser()
    {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @param $message
     * @return mixed
     */
    public function setFlashExito($message)
    {
        return $this->get('session')->getFlashBag()->set('exito', $message);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function setFlashInfo($message)
    {
        return $this->get('session')->getFlashBag()->set('info', $message);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function setFlashAviso($message)
    {
        return $this->get('session')->getFlashBag()->set('aviso', $message);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function setFlashError($message)
    {
        return $this->get('session')->getFlashBag()->set('error', $message);
    }

    /**
     * @param $date
     * @return \DateTime
     */
    public function parseDateForm($date)
    {
        $time = strtotime($date);
        $date = date('Y-m-d', $time);

        return new \DateTime($date);
    }

    /**
     * @param Quotation $quotation
     * @param $type
     * @return Quotation
     */
    public function calculateValues(Quotation $quotation, $type)
    {
        $em = $this->getDoctrine()->getManager();
        $coin = $quotation->getCountry()->getCoin();
        $isLocal = $coin->getIsLocalCountry();
        $idCoin = $coin->getId();
        $current = 1;

        if (!$isLocal) {
            $current = $em->getRepository('TSCYABundle:ExchangeRateUSD')
                ->getCurrentExchangeRateUSDByCoinId($idCoin);
        }
        $valueInscripcion = 0;
        if ($type == Quotation::FLEXIBLE) {
            $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanasLodging(), 2);
            $quotation->setAmountLodging($lodgingAmount);

            $courseValue = $quotation->getCourseValue() * $quotation->getSemanas();
            $promocion = $em->getRepository('TSCYABundle:Promocion')->getSingleByCourse(
                $quotation->getCourse()->getId()
            );

            if ($promocion) {
                $quotation->setPromocion($promocion);
                $percentage = $promocion->getPercentage();
                $discount = $percentage * $courseValue;
                $courseValue -= $discount;
            }

            $quotation->setAmountCourse(round($courseValue, 2));

            $valueInscripcion = $quotation->getCourse()->getPriceInscription();
        } elseif ($type == Quotation::PACKAGE) {
            $package = $quotation->getPackage();
            $quotation->setSemanas($package->getSemanas());
            //TODO: mejorar
            if ($quotation->getSemanasLodging()) {
                $lodgingAmount = round(
                    $quotation->getLodging()->getPricePerWeek() * $quotation->getSemanasLodging(),
                    2
                );
            } else {
                $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanas(), 2);
            }

            if (!$quotation->getSemanasLodging()) {
                $packageLodging = $em->getRepository('TSCYABundle:PackageLodging')
                    ->getPriceLodgingById($quotation->getLodging()->getId());

                $lodgingPrice = $packageLodging ? $packageLodging->getLodgingPrice() : 0;
                $amountLodging = intval($lodgingPrice) > 0 ? $lodgingPrice : $lodgingAmount;
                $quotation->setAmountLodging(round($amountLodging, 2));
            } else {
                $quotation->setAmountLodging(round($lodgingAmount, 2));
            }


            $valuePackage = $package->getPrice();
            $promocion = $em->getRepository('TSCYABundle:Promocion')->getSingleByPackage($package->getId());

            if ($promocion) {
                $quotation->setPromocion($promocion);
                $percentage = $promocion->getPercentage();
                $discount = $percentage * $valuePackage;
                $valuePackage = $valuePackage - $discount;
            }

            $quotation->setAmountCourse(round($valuePackage, 2));

            $valueInscripcion = $package->getPriceInscription();
        } elseif ($type == Quotation::EXAM) {
            $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanasLodging(), 2);
            $quotation->setAmountLodging($lodgingAmount);
            $valueExam = $quotation->getExamValue() * $quotation->getSemanas();

            $promocion = $em->getRepository('TSCYABundle:Promocion')->getSingleByExam($quotation->getExam()->getId());
            if ($promocion) {
                $quotation->setPromocion($promocion);
                $percentage = $promocion->getPercentage();
                $discount = $percentage * $valueExam;
                $valueExam -= $discount;
            }

            $quotation->setAmountCourse(round($valueExam, 2));

            $valueInscripcion = $quotation->getExam()->getPriceInscription();
        }

        $totalService = 0;
        $agency = $em->getRepository('TSCYABundle:Agency')->getLastRecords(1);
        foreach ($quotation->getService() as $service) {
            $totalService += $this->getPriceServiceByParameters($service, $agency[0]);
        }
        $quotation->setAmountService(round($totalService, 2));

        $totalLocal = $quotation->getAmountCourse() +
            $quotation->getAmountLodging() +
            $quotation->getAmountService() +
            $valueInscripcion;

        $quotation->setTotalLocal($totalLocal);
        $quotation->setTotalUSD(round($totalLocal * $current, 2));
        $quotation->setTotalLocalCountry(round($quotation->getTotalUSD(), 2));

        return $quotation;
    }

    /**
     * TODO: completar funcionalidad
     *
     * @param Service $service
     * @param Agency $agency
     * @return float
     */
    public function getPriceServiceByParameters(Service $service, Agency $agency)
    {
        //$agency->isSumerSchedule();
        return $service->getPrice();
    }

    /**
     * @param $entity
     */
    public function saveChangeEntity($entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }

    /**
     * @param $currencys
     * @return array
     */
    public function validExpirationDate($currencys)
    {
        $currencysToExpire = [];
        $today = new \DateTime('today');
        foreach ($currencys as $currency) {
            $data = $this->isNearbyToExpire($currency, $today);
            if ($data) {
                $currencysToExpire[] = $data;
            }
        }

        return $currencysToExpire;
    }

    public function isNearbyToExpire(ExchangeRateUSD $exchangeRateUSD, \DateTime $today)
    {
        $expirationDay = $exchangeRateUSD->getExpiration();
        // TODO: evaluar si es necesario cambiar, puesto que funciona solamente cuando esta en el mes actual
        if ($today->format('m-Y') === $expirationDay->format('m-Y')) {
            $expirationDays = $expirationDay->format('d') - $today->format('d');
            if ($expirationDays <= 3) {
                return [
                    "name" => $exchangeRateUSD->getCoin()->getName(),
                    "code" => $exchangeRateUSD->getCoin()->getCode(),
                    "symbol" => $exchangeRateUSD->getCoin()->getSymbol(),
                    "days" => $expirationDays,
                ];
            }
        }

        return false;
    }
}