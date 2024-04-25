<?php
require_once 'vendor/autoload.php';
if (session_id() === '' || !isset($_SESSION)) session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Methods: *");

$router = new AltoRouter();
$router->setBasePath('/silver-micro/back');

$route = str_replace('/silver-micro/back', '', $_SERVER['REQUEST_URI']);
if ($route == '/login' || $route == '/register') {
    $route = '/auth';
}
if (str_contains($route, '?')) {
    $modified_route = explode('?', $route);
    $modified_route = $modified_route[0];
    var_dump($modified_route);
    // $route = $route[0];
    // var_dump($route);
}
// var_dump($route);
isset($modified_route) ? require_once __DIR__ . '/src/routes' . $modified_route . '_route.php' :
    require_once __DIR__ . '/src/routes' . $route . '_route.php';

$match = $router->match();
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
