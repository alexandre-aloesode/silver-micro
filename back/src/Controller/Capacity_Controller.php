<?php

namespace App\Controller;

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Capacity_Model;

class Capacity_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postCapacity($params)
    {
        $access_params = $this->helper->Access('postCapacity', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Capacity_Model();
        }
    }

    public function getCapacity($params) {
        $access_params = $this->helper->Access('getCapacity', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Capacity_Model();
            echo json_encode($this->model->getCapacity($access_params));
        }
    }
}
