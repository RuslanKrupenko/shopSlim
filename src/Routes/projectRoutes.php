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

$app->get("/cart", function () use ($app) {
    $controller = new \App\Controller\CartController($app->getContainer());
    $controller->indexAction();
});

$app->post("/cart/add/{id}", function (Request $request, Response $response, $args) use ($app) {
    $controller = new \App\Controller\CartController($app->getContainer());
    $controller->addtocartAction($args);
});

$app->post("/cart/remove/{id}", function (Request $request, Response $response, $args) use ($app) {
    $controller = new \App\Controller\CartController($app->getContainer());
    $controller->removefromcartAction($args);
});

$app->post("/cart/order", function (Request $request, Response $response, $args) use ($app) {
    $controller = new \App\Controller\CartController($app->getContainer());
    $controller->orderAction($request);
});

$app->post("/user/register", function (Request $request, Response $response, $args) use ($app) {
    $controller = new \App\Controller\UserController($app->getContainer());
    $controller->registerAction($request);
});