<?php

session_start();

require_once "./vendor/autoload.php";
require_once "./src/Util/DynamicRoute.php";
require_once "./src/Util/BreakingText.php";
require_once "./src/Util/ImageRepository.php";

require_once "./alias.php";

$adminRoutes = require_once "./src/Http/AdminRoutes.php";
$clientRoutes = require_once "./src/Http/SiteRoutes.php";

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

$adminRoutes($app);
$clientRoutes($app);

$app->run();
