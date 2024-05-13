<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Booking_Model;

class Booking_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postBooking($params)
    {
        $access_params = $this->helper->Access('postBooking', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Booking_Model();
            echo json_encode($this->model->postBooking($access_params));
        }
    }

    public function getBooking($params) {
        $access_params = $this->helper->Access('getBooking', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Booking_Model();
            echo json_encode($this->model->getBooking($access_params));
        }
    }
}
