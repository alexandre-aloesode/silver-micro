<?php

use App\Controller\Capacity_Controller;

$router->map('POST', '/capacity', function () {
    $capacity = new Capacity_Controller();
    if($_POST['method'] == 'GET') return $capacity->getCapacity($_POST);
    else if($_POST['method'] == 'POST') return $capacity->postCapacity($_POST);
    // else if($_POST['method'] == 'PUT') return $capacity->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $capacity->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'post');