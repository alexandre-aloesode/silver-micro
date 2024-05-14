<?php

use App\Controller\Restaurant_Image_Controller;

$router->map('POST', '/restaurant_image', function () {
    $restaurant_image = new Restaurant_Image_Controller();
    if($_POST['method'] == 'GET') return $restaurant_image->getRestaurantImage($_POST);
    else if($_POST['method'] == 'POST') return $restaurant_image->postRestaurantImage($_POST);
    else if($_POST['method'] == 'PUT') return $restaurant_image->putRestaurantImage($_POST);
    else if($_POST['method'] == 'DELETE') return $restaurant_image->deleteRestaurantImage($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_image_post');



