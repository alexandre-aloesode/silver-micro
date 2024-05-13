<?php

use App\Controller\Restaurant_Schedule_Controller;

$router->map('POST', '/restaurant_schedule', function () {
    $restaurant_schedule = new Restaurant_Schedule_Controller();
    if($_POST['method'] == 'GET') return $restaurant_schedule->getRestaurantSchedule($_POST);
    else if($_POST['method'] == 'POST') return $restaurant_schedule->postRestaurantSchedule($_POST);
    else if($_POST['method'] == 'DELETE') return $restaurant_schedule->deleteRestaurantSchedule($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'restaurant_post');