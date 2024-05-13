<?php

use App\Controller\Restaurant_Controller;

$router->map('POST', '/restaurant', function () {
    $restaurant = new Restaurant_Controller();
    if($_POST['method'] == 'GET') return $restaurant->getRestaurant($_POST);
    else if($_POST['method'] == 'POST') return $restaurant->postRestaurant($_POST);
    else if($_POST['method'] == 'PUT') return $restaurant->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $restaurant->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_post');

// $router->map('GET', '/restaurant', function () {
//     var_dump("toto");
//     // $restaurant = new Restaurant_Controller($_POST);
//     // return $restaurant->getRestaurant($_POST);
// }, 'restaurant_get');



