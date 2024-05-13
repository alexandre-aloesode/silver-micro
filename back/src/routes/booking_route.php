<?php

use App\Controller\Booking_Controller;

$router->map('POST', '/booking', function () {
    $booking = new Booking_Controller();
    if($_POST['method'] == 'GET') return $booking->getBooking($_POST);
    else if($_POST['method'] == 'POST') return $booking->postBooking($_POST);
    // else if($_POST['method'] == 'PUT') return $booking->putRestaurant($_POST);
    // else if($_POST['method'] == 'DELETE') return $booking->deleteRestaurant($_POST);
    else return json_encode(['success' => false, 'message' => 'Méthode inconnue']);
}, 'post');