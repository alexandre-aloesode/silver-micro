<?php

namespace App\Controller;


use App\Controller\Abstract\Abstract_Controller;
use App\Model\Hour_Model;

class Hour_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postHour($params)
    {
        $access_params = $this->helper->Access('postHour', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Hour_Model();
        }
    }

    public function getHour($params) {
        $access_params = $this->helper->Access('getHour', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Hour_Model();
            echo json_encode($this->model->getHour($access_params));
        }
    }
}
