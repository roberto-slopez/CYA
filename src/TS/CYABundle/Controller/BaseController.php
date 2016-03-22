<?php

namespace TS\CYABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Doctrine\ORM\Query;
use TS\CYABundle\Entity\Course;
use TS\CYABundle\Entity\ExchangeRateUSD;
use TS\CYABundle\Entity\Quotation;
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
        $totalService = 0;
        foreach ($quotation->getService() as $service) {
            $totalService += $service->getPrice();
        }
        $quotation->setAmountService(round($totalService, 2));
        $isLocal = $coin->getIsLocalCountry();
        $idCoin = $coin->getId();
        $current = 1;

        if (!$isLocal) {
            $current = $em ->getRepository('TSCYABundle:ExchangeRateUSD')
                ->getCurrentExchangeRateUSDByCoinId($idCoin);
        }

        if ($type == Quotation::FLEXIBLE) {
            $promocion = $em->getRepository('TSCYABundle:Promocion')->getSingleByCourse($quotation->getCourse()->getId());

            if ($promocion) {
                $quotation->setPromocion($promocion);
            }
            $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanas(), 2);
            $quotation->setAmountLodging($lodgingAmount);

            $courseValue = $quotation->getCourseValue() * $quotation->getSemanas();
            $courseValueFinish = $courseValue;

            if ($quotation->getPromocion()) {
                $percentage = $quotation->getPromocion()->getPercentage();
                $discount = $percentage * $courseValueFinish;
                $courseValueFinish -= $discount;
            }

            $quotation->setAmountCourse(round($courseValueFinish, 2));
        } elseif ($type == Quotation::PACKAGE) {
            $quotation->setSemanas($quotation->getPackage()->getSemanas());
            $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanas(), 2);

            $packageLodging = $em->getRepository('TSCYABundle:PackageLodging')
                ->getPriceLodgingById($quotation->getLodging()->getId());

            $lodgingPrice = $packageLodging ? $packageLodging->getLodgingPrice() : 0;
            $amountLodging = intval($lodgingPrice) > 0 ? $lodgingPrice : $lodgingAmount;

            $quotation->setAmountLodging(round($amountLodging, 2));
            $quotation->setAmountCourse(round($quotation->getPackage()->getPrice(), 2));
        } elseif ($type == Quotation::EXAM) {
            $lodgingAmount = round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanas(), 2);
            $quotation->setAmountLodging($lodgingAmount);
            $quotation->setAmountCourse(round($quotation->getExamValue() * $quotation->getSemanas(), 2));
        }

        $totalLocal = $quotation->getAmountCourse() +
            $quotation->getAmountLodging() +
            $quotation->getAmountService();

        $quotation->setTotalLocal($totalLocal);
        $quotation->setTotalUSD(round($totalLocal * $current, 2));
        $quotation->setTotalLocalCountry(round($quotation->getTotalUSD(), 2));

        return $quotation;
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
    public function validExpirationDate($currencys) {
        $currencysToExpire = [];
        $today = new \DateTime('today');
        foreach ($currencys as $currency) {
            $data = $this->isAboutToExpire($currency, $today);
            if ($data) {
                $currencysToExpire[] = $data;
            }
        }

        return $currencysToExpire;
    }

    public function isAboutToExpire(ExchangeRateUSD $exchangeRateUSD, \DateTime $today) {
        $expirationDay = $exchangeRateUSD->getExpiration();
        if ($today->format('m-Y') === $expirationDay->format('m-Y')) {
            $expirationDays = $expirationDay->format('d') - $today->format('d');
            if ($expirationDays <= 3) {
                return [
                    "name" => $exchangeRateUSD->getCoin()->getName(),
                    "code" => $exchangeRateUSD->getCoin()->getCode(),
                    "symbol" => $exchangeRateUSD->getCoin()->getSymbol(),
                    "days" => $expirationDays
                ];
            }
        }

        return false;
    }
}