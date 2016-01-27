<?php

namespace TS\CYABundle\Doctrine\Behaviors\Blameable;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\User\User;

/**
 * UserCallable can be invoked to return a blameable user
 *
 * Class UserCallable
 * @package TS\CYABundle\Doctrine\Behaviors\Blameable
 */
class UserCallable
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param callable
     * @param string $userEntity
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        $token = $this->container->get('security.token_storage')->getToken();

        if (null !== $token) {
            return $token->getUser();
        }
    }
}
