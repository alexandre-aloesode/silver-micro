<?php

use App\Controller\Restaurant_Controller;
require_once '/var/www/html/silver-micro/back/src/controller/Restaurant_Controller.php';

$router->map('POST', '/restaurant', function () {
    $restaurant = new Restaurant_Controller($_POST);
    return $restaurant->postRestaurant($_POST);
}, 'restaurant_post');



