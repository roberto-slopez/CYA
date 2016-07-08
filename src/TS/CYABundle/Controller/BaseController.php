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

        $quotation->setTotalSemanas($quotation->getSemanas());
        $totalManualMultiplier = 0;
        foreach ($quotation->getManualMultiplier() as $key => $manual) {
            $totalManualMultiplier += $manual->getPrice();
        }

        if (!$isLocal) {
            $current = $em->getRepository('TSCYABundle:ExchangeRateUSD')
                ->getCurrentExchangeRateUSDByCoinId($idCoin);
        }

        $valueInscripcion = 0;

        if ($type == Quotation::FLEXIBLE) {
            $quotation->setAmountLodging(0.00);
            if (!$quotation->getWithoutLodging()) {
                $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanasLodging(), 2);
                $quotation->setAmountLodging($lodgingAmount);
            }

            $courseValue = $quotation->getCourseValue() * $quotation->getTotalSemanas();
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

            $quotation->setAmountLodging(0.00);
            if (!$quotation->getWithoutLodging()) {
                if ($quotation->getSemanasLodging() > 0) {
                    $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanasLodging(), 2);
                } else {
                    $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanas(), 2);
                }

                if ($quotation->getSemanasLodging() == 0) {
                    $packageLodging = $em->getRepository('TSCYABundle:PackageLodging')
                        ->getPriceLodgingById($quotation->getLodging()->getId());

                    $lodgingPrice = $packageLodging ? $packageLodging->getLodgingPrice() : 0;
                    $amountLodging = intval($lodgingPrice) > 0 ? $lodgingPrice : $lodgingAmount;
                    $quotation->setAmountLodging(round($amountLodging, 2));
                } else {
                    $quotation->setAmountLodging(round($lodgingAmount, 2));
                }
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
            $quotation->setAmountLodging(0.00);
            if (!$quotation->getWithoutLodging()) {
                $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanasLodging(), 2);
                $quotation->setAmountLodging($lodgingAmount);
            }

            $valueExam = $quotation->getExamValue() * $quotation->getTotalSemanas();

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

        foreach ($quotation->getService() as $service) {
            $totalService += $this->getPriceServiceByParameters($service, $quotation);
        }

        $quotation->setAmountService(round($totalService, 2));
        $quotation->setAmountManualMultiplier(round($totalManualMultiplier, 2));

        $totalLocal = $quotation->getAmountCourse() +
            $quotation->getAmountLodging() +
            $quotation->getAmountService() +
            $quotation->getAmountManualMultiplier() +
            $valueInscripcion;

        $quotation->setTotalLocal($totalLocal);
        $quotation->setTotalUSD(round($totalLocal * $current, 2));
        $quotation->setTotalLocalCountry(round($quotation->getTotalUSD(), 2));

        return $quotation;
    }

    /**
     * Calc service price
     * @param Service $service
     * @param Quotation $quotation
     * @return float
     */
    public function getPriceServiceByParameters(Service $service, Quotation $quotation)
    {
        if ($service->getIsHealthCoverage() && $quotation->getSemanas() >= 4) {
            $meses = $quotation->getSemanas() / 4;
            return $meses * $service->getPrice();
        }

        if ($service->getSummerSupplement()) {
            return $service->getPrice() * $quotation->getSummerSupplement();
        }

        if ($service->getChargePerWeekCourse()) {
            // limite de semanas
            if ($service->getUsesLimitWeeks()) {
                if ($service->getLimitWeek() <= $quotation->getSemanas()) {
                    return $service->getPrice() * $quotation->getSemanas();
                } else {
                    // aplicar limite de semanas
                    return $service->getPrice() * $service->getLimitWeek();
                }
            } else {
                // multiplicar por semanas
                return $service->getPrice() * $quotation->getSemanas();
            }
        }

        if ($service->getChargePerWeekLodging()) {
            // limite de semanas
            if ($service->getUsesLimitWeeks()) {
                if ($service->getLimitWeek() <= $quotation->getSemanasLodging()) {
                    return $service->getPrice() * $quotation->getSemanasLodging();
                } else {
                    // aplicar limite de semanas
                    return $service->getPrice() * $service->getLimitWeek();
                }
            } else {
                // multiplicar por semanas
                return $service->getPrice() * $quotation->getSemanasLodging();
            }
        }

        if ($service->getUseAmountInitialWeeks()) {
            if ($service->getInitialWeeks() >= $quotation->getSemanas()) {
                return $service->getPrice() * $quotation->getSemanas();
            } else {
                return 0;
            }
        }

        if ($service->getMultiplesOfFour()) {
            $result = 0;
            foreach (range(0, 100, 4) as $k => $n) {
                if ($quotation->getSemanas() <= $n) {
                    $result = $service->getPrice() * $k;
                    break;
                }
            }

            return $result;
        }

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

        $curdate = strtotime($today->format('d-m-Y'));
        $mydate = strtotime($expirationDay->format('d-m-Y'));

        if($curdate > $mydate) {
            return [
                "name" => $exchangeRateUSD->getCoin()->getName(),
                "code" => $exchangeRateUSD->getCoin()->getCode(),
                "symbol" => $exchangeRateUSD->getCoin()->getSymbol(),
                "days" => 0,
            ];
        }

        return false;
    }
}