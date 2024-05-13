<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Model;

class Restaurant_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postRestaurant($params)
    {
        $access_params = $this->helper->Access('postRestaurant', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Model();
            echo json_encode($this->model->postRestaurant($access_params));
        }
    }

    public function getRestaurant($params) {
        $access_params = $this->helper->Access('getRestaurant', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Model();
            echo json_encode($this->model->getRestaurant($access_params));
        }
    }

    public function putRestaurant($params) {
        $access_params = $this->helper->Access('putRestaurant', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Model();
            echo json_encode($this->model->putRestaurant($access_params));
        }
    }
}
