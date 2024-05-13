<?php

use App\Controller\Hour_Controller;

$router->map('POST', '/hour', function () {
    $hour = new Hour_Controller();
    if($_POST['method'] == 'GET') return $hour->getHour($_POST);
    else if($_POST['method'] == 'POST') return $hour->postHour($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'post');