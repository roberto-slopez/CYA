<?php

namespace TS\CYABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Doctrine\ORM\Query;
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
        if ($type == Quotation::FLEXIBLE) {
            $quotation->setAmountLodging(
                round($quotation->getLodging()->getPricePerWeek() * $quotation->getSemanas(), 2)
            );

            $quotation->setAmountCourse(round($quotation->getCourse()->getPrice() * $quotation->getSemanas(), 2));
            $totalService = 0;
            foreach ($quotation->getService() as $service) {
                $totalService = $service->getPrice();
            }

            $quotation->setAmountService(round($totalService, 2));
            $totalLocal = $quotation->getAmountCourse() + $quotation->getAmountLodging() + $quotation->getAmountService(
                );

            $quotation->setTotalLocal($totalLocal);
            $idCoin = $quotation->getCountry()->getCoin()->getId();
            $current = $this->getDoctrine()->getManager()
                ->getRepository('TSCYABundle:ExchangeRateUSD')
                ->getCurrentExchangeRateUSDByCoinId($idCoin);

            $localCountryValue = $this->getDoctrine()->getManager()
                ->getRepository('TSCYABundle:ExchangeRateUSD')
                ->getLocalCountryValue();

            $quotation->setTotalUSD(round($totalLocal * $current, 2));
            $quotation->setTotalLocalCountry(round($quotation->getTotalUSD() * $localCountryValue, 2));

        }

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
}