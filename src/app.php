<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once "../vendor/autoload.php";

$settings = require __DIR__ . "/../config/settings.php";

$app = new Slim\App($settings);

require_once __DIR__ . "/../src/Routes/projectRoutes.php";
require_once __DIR__ . "/../src/DependencyInjection/container.php";

$app->run();