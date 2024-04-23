<?php

require_once 'vendor/autoload.php';

if (session_id() === '' || !isset($_SESSION)) session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Methods: *");

$router = new AltoRouter();
$router->setBasePath('/silver-micro/back');

$route = str_replace('/silver-micro/back', '', $_SERVER['REQUEST_URI']);
require_once __DIR__ . '/src/routes/' . $route . '_route.php';

$match = $router->match();
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
