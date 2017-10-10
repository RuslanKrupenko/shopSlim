<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $smarty = $this->container["smarty"];
        if (isset($_SESSION['user'])) {
            $smarty->assign("arUser", $_SESSION['user']);
        }

        $smarty->assign('cartCntItems', count($_SESSION['cart']));
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getRequest()
    {
        return $this->container->get("request");
    }

    public function getResponse()
    {
        return $this->container->get("response");
    }
}