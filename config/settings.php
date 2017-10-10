<?php

$template = "default";
$templateAdmin = "admin";

return ["settings" => [
    "displayErrorDetails" => true,
    "addContentLengthHeader" => false,
    "db" => [
        "host" => "loclahost",
        "user" => "root",
        "pass" => "12345",
        "dbname" => "shop",
    ],
    "smarty" => [
        "tpl_prefix" => __DIR__ . "/../src/views/{$template}/",
        "tpl_admin_prefix" => __DIR__ . "/src/views/{$templateAdmin}/",
        "tpl_postfix" => ".tpl",
        "tpl_web_path" => "/templates/{$template}/",
        "tpl_admin_web_path" => "/templates/{$templateAdmin}/"
    ]
]
];