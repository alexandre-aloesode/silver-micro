<?php

use App\Controller\Restaurant_Day_Controller;

$router->map('POST', '/restaurant_Day', function () {
    $restaurant_day = new Restaurant_Day_Controller();
    if($_POST['method'] == 'GET') return $restaurant_day->getRestaurantDay($_POST);
    else if($_POST['method'] == 'POST') return $restaurant_day->postRestaurantDay($_POST);
    // else if($_POST['method'] == 'PUT') return $restaurant_Day->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $restaurant_Day->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_post');



