<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class CotizadorFlexibleController
 * @package TS\CYABundle\Controller
 *
 * @Route("/admin/cotizador/flexible")
 */
class CotizadorFlexibleController extends BaseController
{
    /**
     * @Route("/", name="cotizador_flexible_index")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        return [

        ];
    }
}
