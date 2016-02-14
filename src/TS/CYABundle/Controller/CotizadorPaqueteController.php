<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class CotizadorPaquetesController
 * @package TS\CYABundle\Controller
 *
 * @Route("/admin/cotizador/paquete")
 */
class CotizadorPaqueteController extends BaseController
{
    /**
     * @Route("/", name="cotizador_paquete_index")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        return [

        ];
    }
}
