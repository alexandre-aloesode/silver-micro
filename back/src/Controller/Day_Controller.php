<?php

namespace App\Controller;


use App\Controller\Abstract\Abstract_Controller;
use App\Model\Day_Model;

class Day_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postDay($params)
    {
        $access_params = $this->helper->Access('postDay', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Day_Model();
        }
    }

    public function getDay($params) {
        $access_params = $this->helper->Access('getDay', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Day_Model();
            echo json_encode($this->model->getDay($access_params));
        }
    }
}
