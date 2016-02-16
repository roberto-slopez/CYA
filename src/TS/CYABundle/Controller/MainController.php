<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
* @Route("admin")
* @Security("has_role('ROLE_ADMIN')")
*/
class MainController extends BaseController
{
    /**
    * @Route("/", name="main")
    * @Template()
    */
    public function indexAction()
    {
        return [
        ];
    }
}
