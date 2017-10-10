<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get("/", function () use ($app) {
    $controller = new \App\Controller\IndexController($app->getContainer());
    $controller->indexAction();
});

$app->get("/product/{id}", function (Request $request, Response $response, $args) use ($app) {
    $controller = new \App\Controller\ProductController($app->getContainer());
    $controller->indexAction($args);
});

$app->get("/category/{id}", function (Request $request, Response $response, $args) use ($app) {
    $controller = new \App\Controller\CategoryController($app->getContainer());
    $controller->indexAction($args);
});