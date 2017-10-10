<?php

$container = $app->getContainer();

$container["db"] = function ($c) {
    $db = $c["settings"]["db"];
    $pdo = new PDO("mysql: host=" . $db["host"] . ";dbname=" . $db["dbname"], $db["user"], $db["pass"]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};

$container["smarty"] = function ($c) {
    $smartySettings = $c["settings"]["smarty"];
    $smarty = new Smarty();

    //< иницивлизация шаблонизатора Smarty
    $smarty->setTemplateDir($smartySettings["tpl_prefix"]);
    $smarty->setCompileDir(__DIR__ . "/../tmp/smarty/templates_c");
    $smarty->setCacheDir(__DIR__ . "/../tmp/smarty/cache");
//    $smarty->setConfigDir(__DIR__ . "/../../vendor/smarty/smarty/demo/configs");

    $smarty->assign("templateWebPath", $smartySettings["tpl_web_path"]);
    // >
    return $smarty;
};