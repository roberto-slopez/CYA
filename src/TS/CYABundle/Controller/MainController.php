<?php

namespace TS\CYABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Security,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
* @Security("has_role('ROLE_USER')")
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
