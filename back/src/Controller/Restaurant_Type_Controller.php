<?php

namespace App\Controller;


use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Type_Model;

class Restaurant_Type_Controller extends Abstract_Controller
{

    public function __construct($array)
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postRestaurantType($params)
    {
        $access_params = $this->helper->Access('postRestaurantType', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Type_Model();
        }
    }

    public function getRestaurantType($params) {
        $access_params = $this->helper->Access('getRestaurantType', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Type_Model();
            echo json_encode($this->model->getRestaurantType($access_params));
        }
    }
}
