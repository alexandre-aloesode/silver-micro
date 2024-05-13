<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Capacity_Model;

class Restaurant_Capacity_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postRestaurantCapacity($params)
    {
        $access_params = $this->helper->Access('postRestaurantCapacity', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Capacity_Model();
        }
    }

    public function getRestaurantCapacity($params) {
        $access_params = $this->helper->Access('getRestaurantCapacity', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Capacity_Model();
            echo json_encode($this->model->getRestaurantCapacity($access_params));
        }
    }
}
