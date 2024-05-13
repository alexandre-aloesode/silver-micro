<?php

use App\Controller\Day_Controller;

$router->map('POST', '/day', function () {
    $type = new Day_Controller();
    if($_POST['method'] == 'GET') return $type->getDay($_POST);
    else if($_POST['method'] == 'POST') return $type->postDay($_POST);
    // else if($_POST['method'] == 'PUT') return $type->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $type->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'post');