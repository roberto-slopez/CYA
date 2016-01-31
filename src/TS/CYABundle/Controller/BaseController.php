<?php

namespace TS\CYABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Doctrine\ORM\Query;

/**
 * Class BaseController
 * @package TS\Cian\MainBundle\Controller
 */
class BaseController extends Controller
{
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
     * @param $entity
     */
    public function saveChangeEntity($entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }
}