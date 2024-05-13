<?php

use App\Controller\Restaurant_Type_Controller;

$router->map('POST', '/restaurant_type', function () {
    $restaurant_type = new Restaurant_Type_Controller();
    if($_POST['method'] == 'GET') return $restaurant_type->getRestaurantType($_POST);
    else if($_POST['method'] == 'POST') return $restaurant_type->postRestaurantType($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_post');
