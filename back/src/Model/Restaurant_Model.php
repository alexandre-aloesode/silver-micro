<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Restaurant_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'restaurant');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'restaurant';
    }

    public function postRestaurant($params)
    {
        $constraints = [
            ['name', 'mandatory', 'string'], ['address', 'mandatory', 'string'], ['id_user', 'mandatory', 'number'],
            ['zipCode', 'mandatory', 'string'],
            //  ['phone', 'mandatory', 'string'],
            ['total_capacity', 'optional', 'number'], ['email', 'optional', 'string'],
            ['average_price', 'optional', 'number'], ['images', 'optional', 'string'],

        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'name' => $params['name'],
            'address' => $params['address'],
            'id_user' => $params['id_user'],
            'zip_code' => (int)$params['zipCode'],
            // 'phone' => $params['phone'],
        ];

        $optional_fields = [
            ['total_capacity', 'total_capacity'],
            ['email', 'email'],
            ['average_price', 'average_price'],
            ['images', 'images'],
        ];

        foreach ($optional_fields as $field) {
            if (array_key_exists($field[1], $params)) {
                $data[$field[0]] = $params[$field[1]];
            }
        }
        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getRestaurant($params) {

        $constraints = [
            ['restaurant_id', 'optional', 'number', true], ['restaurant_name', 'optional', 'string'],
            ['restaurant_address', 'optional', 'string'], ['restaurant_zip_code', 'optional', 'string'],
            ['total_capacity', 'optional', 'number'], ['restaurant_phone', 'optional', 'string'],
            ['restaurant_email', 'optional', 'string'], ['average_price', 'optional', 'number'], 
            ['restaurant_images', 'optional', 'string'], ['restaurant_owner_id', 'optional', 'number']
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getFollowupFields();
        $sql = $this->buildGet($fields, $params);
        var_dump($sql);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));    
    }

    private function getFollowupFields()
    {
        return ([
			'restaurant_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
            'restaurant_name' => [
                'type' => 'in',
                'field' => 'name',
                'alias' => 'restaurant_name',
                'filter' => 'none'
            ],
            'restaurant_address' => [
                'type' => 'in',
                'field' =>'address',
                'alias' => 'restaurant_address',
                'filter' => 'like'
            ],
            'restaurant_zip_code' => [
                'type' => 'in',
                'field' =>'restaurant_zip_code',
                'alias' => 'restaurant_zip_code',
                'filter' => 'none'
            ],
            'total_capacity' => [
                'type' => 'in',
                'field' =>'total_capacity',
                'alias' => 'total_capacity',
                'filter' => 'where'
            ],
            'restaurant_phone' => [
                'type' => 'in',
                'field' => 'phone',
                'alias' => 'restaurant_phone',
                'filter' => 'where'
            ],
            'restaurant_email' => [
                'type' => 'in',
                'field' => 'email',
                'alias' => 'restaurant_email',
                'filter' => 'where'
            ],
            'average_price' => [
                'type' => 'in',
                'field' => 'average_price',
                'alias' => 'average_price',
                'filter' => 'where'
            ],
            'restaurant_images' => [
                'type' => 'in',
                'field' => 'restaurant_images',
                'alias' => 'restaurant_images',
                'filter' => 'where'
            ],
            'restaurant_owner_id' => [
                'type' => 'in',
                'field' => 'user_id',
                'alias' => 'restaurant_owner_id',
                'filter' => 'where'
            ],
         
            // 'student_firstname' => [
            //     'type' => 'out',
            //     'link' => [
            //         ['left' => ['followup', 'applicant_fk'], 'right' => ['applicant', 'id']]
            //     ],
            //     'field' =>'firstname',
            //     'alias' => 'student_firstname',
            //     'filter' => 'like'
            // ],
        ]);
    }
}
