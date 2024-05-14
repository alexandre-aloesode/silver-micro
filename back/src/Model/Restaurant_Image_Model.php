<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Restaurant_Image_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'restaurant_image');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'restaurant_image';
    }

    public function postRestaurantImage($params)
    {
        $constraints = [
            ['restaurant_id', 'mandatory', 'number'], ['restaurant_image_name', 'mandatory', 'string']
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'restaurant_id' => $params['restaurant_id'],
            'name' => $params['restaurant_image_name'],
        ];

        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getRestaurantImage($params) {

        $constraints = [
            ['restaurant_image_id', 'optional', 'number'], ['restaurant_id', 'optional', 'number'],
            ['restaurant_image_name', 'optional', 'string']
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getRestaurantImageFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));  
    }

    public function putRestaurantImage($params)
    {
        $constraints = [
            ['restaurant_image_id', 'mandatory', 'number'], ['restaurant_id', 'optional', 'number'],
            ['restaurant_image_name', 'optional', 'string']
        ];

        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        $data = [];
        $fields = [
            ['id', 'restaurant_image_id'],
            ['restaurant_id', 'restaurant_id'],
            ['name', 'restaurant_image_name']
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field[1], $params)) {
                $data[$field[0]] = $params[$field[1]];
            }
        }

        $pdo = self::getPdo();
        $sql = $this->buildPut($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);

        return ($response);
    }

    public function deleteRestaurantImage($params)
    {
        $constraints = [
            ['id', 'mandatory', 'number']
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $sql = $this->buildDelete($params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        return ($request->execute($params));
    }

    private function getRestaurantImageFields()
    {
        return ([
			'restaurant_image_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'restaurant_image_id',
                'filter' => 'where'
            ],
            'restaurant_id' => [
                'type' => 'in',
                'field' => 'restaurant_id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
            'restaurant_image_name' => [
                'type' => 'in',
                'field' => 'name',
                'alias' => 'restaurant_image_name',
                'filter' => 'where'
            ]
        ]);
    }
}
