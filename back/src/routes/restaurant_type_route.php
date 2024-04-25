<?php

use App\Controller\Restaurant_Type_Controller;

$router->map('POST', '/restaurant', function () {
    $restaurant_type = new Restaurant_Type_Controller($_POST);
    if($_POST['method'] == 'GET') return $restaurant_type->getRestaurantType($_POST);
    else if($_POST['method'] == 'POST') return $restaurant_type->postRestaurantType($_POST);
    // else if($_POST['method'] == 'PUT') return $restaurant_type->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $restaurant_type->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_post');

// $router->map('GET', '/restaurant', function () {
//     var_dump("toto");
//     // $restaurant_type = new Restaurant_Controller($_POST);
//     // return $restaurant_type->getRestaurant($_POST);
// }, 'restaurant_get');



