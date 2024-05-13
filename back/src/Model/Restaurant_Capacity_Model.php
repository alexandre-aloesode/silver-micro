<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Restaurant_Capacity_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'restaurant_capacity');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'restaurant_capacity';
    }

    public function postRestaurantCapacity($params)
    {
        $constraints = [
            ['restaurant_id', 'mandatory', 'number'], ['capacity_id', 'mandatory', 'number'],
            ['number_of_tables', 'mandatory', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'restaurant_id' => $params['restaurant_id'],
            'capacity_id' => $params['capacity_id'],
            'number_of_tables' => $params['number_of_tables'],
        ];

        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getRestaurantCapacity($params) {

        $constraints = [
            ['restaurant_capacity_id', 'optional', 'number'], ['restaurant_id', 'optional', 'number'], ['capacity_id', 'optional', 'number'],
            ['number_of_tables', 'optional', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));    
    }

    private function getFields()
    {
        return ([
            'restaurant_capacity_id' => [
                'type' => 'in',
                'field' => 'restaurant_capacity_id',
                'alias' => 'restaurant_capacity_id',
                'filter' => 'where'
            ],
			'restaurant_id' => [
                'capacity' => 'in',
                'field' =>'restaurant_id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
            'capacity_id' => [
                'Capacity' => 'in',
                'field' => 'capacity_id',
                'alias' => 'capacity_id',
                'filter' => 'where'
            ],
            'number_of_tables' => [
                'type' => 'in',
                'field' => 'number_of_tables',
                'alias' => 'number_of_tables',
                'filter' => 'where'
            ],
        ]);
    }
}
