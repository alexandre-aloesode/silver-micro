<?php

namespace App\Controller;


use App\Controller\Abstract\Abstract_Controller;
use App\Model\Type_Model;

class Type_Controller extends Abstract_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postType($params)
    {
        $access_params = $this->helper->Access('postType', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Type_Model();
        }
    }

    public function getType($params) {
        $access_params = $this->helper->Access('getType', $this->payload, $params);
        if (!$access_params) {
            echo json_encode($this->status_helper->Forbidden());
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Type_Model();
            echo json_encode($this->model->getType($access_params));
        }
    }
}
