<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Day_Model;

class Restaurant_Day_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postRestaurantDay($params)
    {
        $access_params = $this->helper->Access('postRestaurantDay', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Day_Model();
        }
    }

    public function getRestaurantDay($params) {
        $access_params = $this->helper->Access('getRestaurantDay', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Day_Model();
            echo json_encode($this->model->getRestaurantDay($access_params));
        }
    }
}
