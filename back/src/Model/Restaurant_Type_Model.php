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
        $this->tableName = 'restaurant';
    }

    public function postRestaurantType($params)
    {
        $constraints = [
            ['restaurant_id', 'mandatory', 'number'], ['type_id', 'mandatory', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
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

    public function getRestaurantType($params) {

        $constraints = [
            ['restaurant_id', 'optional', 'number'], ['type_id', 'optional', 'number'],
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
			'restaurant_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
            'type_id' => [
                'type' => 'in',
                'field' => 'type_id',
                'alias' => 'type_id',
                'filter' => 'none'
            ],
        ]);
    }
}
