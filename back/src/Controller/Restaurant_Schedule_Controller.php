<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Schedule_Model;

class Restaurant_Schedule_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
        $this->model = new Restaurant_Schedule_Model();
    }

    public function postRestaurantSchedule($params)
    {
        $access_params = $this->helper->Access('postRestaurantSchedule', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        } else {
            unset($access_params['token']);
            unset($access_params['method']);
            echo json_encode($this->model->postRestaurantSchedule($access_params));
        }
    }
    
    public function getRestaurantSchedule($params)
    {
        $access_params = $this->helper->Access('getRestaurantSchedule', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        } else {
            unset($access_params['token']);
            unset($access_params['method']);
            echo json_encode($this->model->getRestaurantSchedule($access_params));
        }
    }

    public function deleteRestaurantSchedule($params)
    {
        $access_params = $this->helper->Access('deleteRestaurantSchedule', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        } else {
            unset($access_params['token']);
            unset($access_params['method']);
            echo json_encode($this->model->deleteRestaurantSchedule($access_params));
        }
    }
}
