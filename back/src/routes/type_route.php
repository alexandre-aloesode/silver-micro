<?php

use App\Controller\Type_Controller;

$router->map('POST', '/restaurant', function () {
    $type = new Type_Controller();
    if($_POST['method'] == 'GET') return $type->getType($_POST);
    else if($_POST['method'] == 'POST') return $type->postType($_POST);
    // else if($_POST['method'] == 'PUT') return $type->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $type->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'post');