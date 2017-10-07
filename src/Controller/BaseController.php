<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;

class BaseController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }
}