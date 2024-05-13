<?php

use App\Controller\Restaurant_Capacity_Controller;

$router->map('POST', '/restaurant_capacity', function () {
    $restaurant_capacity = new Restaurant_Capacity_Controller();
    if($_POST['method'] == 'GET') return $restaurant_capacity->getRestaurantCapacity($_POST);
    else if($_POST['method'] == 'POST') return $restaurant_capacity->postRestaurantCapacity($_POST);
    // else if($_POST['method'] == 'PUT') return $restaurant_capacity->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $restaurant_capacity->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_post');



