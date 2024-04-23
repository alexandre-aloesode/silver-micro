<?php

namespace App\Controller;

require_once 'vendor/autoload.php';

use App\Controller\Abstract\Abstract_Controller;
use App\Model\Restaurant_Model;

require_once '/var/www/html/silver-micro/back/src/controller/Abstract/Abstract_Controller.php';
require_once '/var/www/html/silver-micro/back/src/model/Restaurant_Model.php';


class Restaurant_Controller extends Abstract_Controller
{

    public function __construct($array)
    {
        parent::__construct();
        if (!$this->is_verified) {
            return;
        }
    }

    public function postRestaurant($params)
    {
        $access_params = $this->helper->Access('postRestaurant', $params, $params);
        if (!$access_params) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }
        else {
            unset($access_params['token']);
            unset($access_params['method']);
            $this->model = new Restaurant_Model();
            return $this->model->postRestaurant($access_params);
        }
    }
}
