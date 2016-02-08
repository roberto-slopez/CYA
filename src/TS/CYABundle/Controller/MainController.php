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
        $message = \Swift_Message::newInstance()
        ->setSubject('Registration confirmation')
        ->setFrom('eldinsanchez@gmail.com')
        ->setTo('tscompany09@gmail.com')
        ->setContentType('text/plain')
        ->setBody("test");

        $this->get('mailer')->send($message);
        return [
        ];
    }
}
