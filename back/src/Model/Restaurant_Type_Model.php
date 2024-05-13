<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Restaurant_Type_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'restaurant_type');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'restaurant_type';
    }

    public function postRestaurantType($params)
    {
        $constraints = [
            ['restaurant_id', 'mandatory', 'number'], ['type_id', 'mandatory', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            var_dump($params);
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'restaurant_id' => $params['restaurant_id'],
            'type_id' => $params['type_id'],
        ];


        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getRestaurantType($params)
    {
        $constraints = [
            ['restaurant_type_id', 'optional', 'number'],  ['restaurant_id', 'optional', 'number'], 
            ['type_id', 'optional', 'number'], ['type_name', 'optional', 'string'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        $fields = $this->getRestaurantTypeFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function deleteRestaurantType($params)
    {
        $constraints = [
            ['id', 'mandatory', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        $data = ['id' => $params['id']];
        $sql = $this->buildDelete($data);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? true : false);
    }

    private function getRestaurantTypeFields()
    {
        return ([
            'restaurant_type_id' => [
                'type' => 'in',
                'field' => 'id',
                'alias' => 'restaurant_type_id',
                'filter' => 'where'
            ],
            'restaurant_id' => [
                'type' => 'in',
                'field' => 'restaurant_id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
            'type_id' => [
                'type' => 'in',
                'field' => 'type_id',
                'alias' => 'type_id',
                'filter' => 'where'
            ],
            'type_name' => [
                'type' => 'out',
                'link' => [
                    ['left' => ['restaurant_type', 'type_id'], 'right' => ['type', 'id']],
                ],
                'field' => 'name',
                'alias' => 'type_name',
                'filter' => 'where'
            ],
        ]);
    }
}
