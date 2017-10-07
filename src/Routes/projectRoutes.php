<?php

$app->get("/", function () use ($app) {
    $controller = new \App\Controller\IndexController($app->getContainer());
    $controller->indexAction();
});