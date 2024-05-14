<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Image_Model;

class Restaurant_Image_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postRestaurantImage($params)
    {
        $access_params = $this->helper->Access('postRestaurantImage', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Image_Model();
            echo json_encode($this->model->postRestaurantImage($access_params));
        }
    }

    public function getRestaurantImage($params) {
        $access_params = $this->helper->Access('getRestaurantImage', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Image_Model();
            echo json_encode($this->model->getRestaurantImage($access_params));
        }
    }

    public function putRestaurantImage($params) {
        $access_params = $this->helper->Access('putRestaurantImage', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Image_Model();
            echo json_encode($this->model->putRestaurantImage($access_params));
        }
    }

    public function deleteRestaurantImage($params) {
        $access_params = $this->helper->Access('deleteRestaurantImage', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Image_Model();
            echo json_encode($this->model->deleteRestaurantImage($access_params));
        }
    }
}
