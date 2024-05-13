<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Restaurant_Day_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'restaurant_day');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'restaurant_day';
    }

    public function postRestaurantDay($params)
    {
        $constraints = [
            ['restaurant_id', 'mandatory', 'number'], ['day_id', 'mandatory', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'restaurant_id' => $params['restaurant_id'],
            'day_id' => $params['day_id'],
        ];

        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getRestaurantDay($params) {

        $constraints = [
            ['restaurant_day_id', 'optional', 'number'], ['restaurant_id', 'optional', 'number'], ['day_id', 'optional', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getRestaurantDayFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));    
    }

    private function getRestaurantDayFields()
    {
        return ([
            'restaurant_day_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'restaurant_day_id',
                'filter' => 'where'
            ],
			'day_id' => [
                'type' => 'in',
                'field' =>'day_id',
                'alias' => 'day_id',
                'filter' => 'where'
            ],
            'restaurant_id' => [
                'type' => 'in',
                'field' => 'restaurant_id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
        ]);
    }
}
