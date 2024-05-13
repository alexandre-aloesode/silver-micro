<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;
use App\Model\Type_Model;
use App\Model\Restaurant_Type_Model;

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
            ['zip_code', 'mandatory', 'string'], ['email', 'mandatory', 'string'], ['city', 'mandatory', 'string'],
            ['phone', 'mandatory', 'string'],
            ['total_capacity', 'optional', 'number'],
            ['description', 'optional', 'string'],
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
            'zip_code' => (int)$params['zip_code'],
            'city' => $params['city'],
            'phone' => $params['phone'],
            'email' => $params['email'],
        ];

        $optional_fields = [
            ['total_capacity', 'total_capacity'],
            ['average_price', 'average_price'],
            ['images', 'images'],
            ['description', 'description'],
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

    public function getRestaurant($params)
    {

        $constraints = [
            ['restaurant_id', 'optional', 'number', true], ['restaurant_name', 'optional', 'string'],
            ['restaurant_address', 'optional', 'string'], ['restaurant_zip_code', 'optional', 'string'],
            ['restaurant_city', 'optional', 'string'], ['restaurant_description', 'optional', 'string'],
            ['total_capacity', 'optional', 'number'], ['restaurant_phone', 'optional', 'string'],
            ['restaurant_email', 'optional', 'string'], ['average_price', 'optional', 'number'],
            ['restaurant_images', 'optional', 'string'], ['restaurant_owner_id', 'optional', 'number'],
            ['restaurant_type_name', 'optional', 'string'], ['restaurant_type_id', 'optional', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        $fields = $this->getFollowupFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        $result = $request->fetchAll(\PDO::FETCH_ASSOC);

        if (isset($params['restaurant_type_name'])) {
            $restaurant_ids = [];
            $temp_result = [];
            foreach ($result as $key => $value) {
                if (!in_array($value['restaurant_id'], $restaurant_ids)) {
                    $restaurant_ids[] = $value['restaurant_id'];
                    $temp_result[] = $value;
                } else {
                    $type_to_add = $value['restaurant_type_name'];
                    foreach ($temp_result as $key2 => $value2) {
                        if ($value2['restaurant_id'] == $value['restaurant_id']) {
                            $temp_type_array = [];
                            if (is_array($value2['restaurant_type_name'])) {
                                $temp_type_array = $value2['restaurant_type_name'];
                            } else {
                                $temp_type_array[] = $value2['restaurant_type_name'];
                            }
                            $temp_type_array[] = $type_to_add;
                            $temp_result[$key2]['restaurant_type_name'] = $temp_type_array;
                        }
                    }
                    unset($result[$key]);
                }
                // if (!is_array($value['restaurant_type'])) {
                //     $result[$key]['restaurant_type'] = [$value['restaurant_type']];
                // }
            }
            $result = $temp_result;
            foreach ($result as $key => $value) {
                if (!is_array($value['restaurant_type_name'])) {
                    $result[$key]['restaurant_type_name'] = [$value['restaurant_type_name']];
                }
            }
        }

        if (isset($params['restaurant_type_id'])) {
            $restaurant_ids = [];
            $temp_result = [];
            foreach ($result as $key => $value) {
                if (!in_array($value['restaurant_id'], $restaurant_ids)) {
                    $restaurant_ids[] = $value['restaurant_id'];
                    $temp_result[] = $value;
                } else {
                    $type_to_add = $value['restaurant_type_id'];
                    foreach ($temp_result as $key2 => $value2) {
                        if ($value2['restaurant_id'] == $value['restaurant_id']) {
                            $temp_type_array = [];
                            if (is_array($value2['restaurant_type_id'])) {
                                $temp_type_array = $value2['restaurant_type_id'];
                            } else {
                                $temp_type_array[] = $value2['restaurant_type_id'];
                            }
                            $temp_type_array[] = $type_to_add;
                            $temp_result[$key2]['restaurant_type_id'] = $temp_type_array;
                        }
                    }
                    unset($result[$key]);
                }
                // if (!is_array($value['restaurant_type'])) {
                //     $result[$key]['restaurant_type'] = [$value['restaurant_type']];
                // }
            }
            $result = $temp_result;
            foreach ($result as $key => $value) {
                if (!is_array($value['restaurant_type_id'])) {
                    $result[$key]['restaurant_type_id'] = [$value['restaurant_type_id']];
                }
            }
        }

        return ($result);
    }

    public function putRestaurant($params)
    {
        $constraints = [
            ['restaurant_id', 'mandatory', 'number'], ['restaurant_name', 'optional', 'string'],
            ['restaurant_address', 'optional', 'string'], ['restaurant_zip_code', 'optional', 'string'],
            ['restaurant_city', 'optional', 'string'], ['restaurant_description', 'optional', 'string'],
            ['total_capacity', 'optional', 'number'], ['restaurant_phone', 'optional', 'string'],
            ['restaurant_email', 'optional', 'string'], ['average_price', 'optional', 'number'],
            ['restaurant_images', 'optional', 'string'], ['restaurant_owner_id', 'optional', 'number'],
            ['restaurant_type', 'optional', 'string'],
        ];

        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        $data = [];
        $fields = [
            ['id', 'restaurant_id'],
            ['name', 'restaurant_name'],
            ['address', 'restaurant_address'],
            ['zip_code', 'restaurant_zip_code'],
            ['city', 'restaurant_city'],
            ['description', 'restaurant_description'],
            ['total_capacity', 'total_capacity'],
            ['phone', 'restaurant_phone'],
            ['email', 'restaurant_email'],
            ['average_price', 'average_price'],
            ['images', 'restaurant_images'],
            ['id_user', 'restaurant_owner_id'],
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

        if (isset($params['restaurant_type'])) {
            $params['restaurant_type'] = explode(',', $params['restaurant_type']);
            $type_model = new Type_Model();
            $all_types = $type_model->getType([
                'type_name' => '',
                'type_id' => ''
            ]);

            $restaurant_type_model = new Restaurant_Type_Model();
            $existing_types = $restaurant_type_model->getRestaurantType([
                'restaurant_type_id' => '',
                'restaurant_id' => $params['restaurant_id'],
                'type_id' => '',
                'type_name' => ''
            ]);
            $existing_types_names = array_column($existing_types, 'type_name');

            foreach ($params['restaurant_type'] as $key => $value) {
                if (!in_array($value, $existing_types_names)) {
                    foreach ($all_types as $key2 => $value2) {
                        if ($value2['type_name'] == $value) {
                            $restaurant_type_model->postRestaurantType([
                                'restaurant_id' => $params['restaurant_id'],
                                'type_id' => (string)$value2['type_id']
                            ]);
                        }
                    }
                }
            }
            foreach ($existing_types_names as $key => $value) {
                if (!in_array($value, $params['restaurant_type'])) {
                    foreach ($existing_types as $key2 => $value2) {
                        if ($value2['type_name'] == $value) {
                            $restaurant_type_model->deleteRestaurantType([
                                'id' => (string)$value2['restaurant_type_id']
                            ]);
                        }
                    }
                }
            }
        }
        return ($response);
    }

    public function deleteRestaurant($params)
    {
        $constraints = [
            ['id', 'mandatory', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        $data = [
            'id' => $params['id'],
        ];
        $pdo = self::getPdo();
        $sql = $this->buildDelete($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response);
    }

    private function getFollowupFields()
    {
        return ([
            'restaurant_id' => [
                'type' => 'in',
                'field' => 'id',
                'alias' => 'restaurant_id',
                'filter' => 'where'
            ],
            'restaurant_name' => [
                'type' => 'in',
                'field' => 'name',
                'alias' => 'restaurant_name',
                'filter' => 'where'
            ],
            'restaurant_address' => [
                'type' => 'in',
                'field' => 'address',
                'alias' => 'restaurant_address',
                'filter' => 'like'
            ],
            'restaurant_zip_code' => [
                'type' => 'in',
                'field' => 'zip_code',
                'alias' => 'restaurant_zip_code',
                'filter' => 'where'
            ],
            'total_capacity' => [
                'type' => 'in',
                'field' => 'total_capacity',
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
                'field' => 'images',
                'alias' => 'restaurant_images',
                'filter' => 'where'
            ],
            'restaurant_owner_id' => [
                'type' => 'in',
                'field' => 'id_user',
                'alias' => 'restaurant_owner_id',
                'filter' => 'where'
            ],
            'restaurant_type_name' => [
                'type' => 'out',
                'link' => [
                    ['left' => ['restaurant', 'id'], 'right' => ['restaurant_type', 'restaurant_id']],
                    ['left' => ['restaurant_type', 'type_id'], 'right' => ['type', 'id']],
                ],
                'field' => 'name',
                'alias' => 'restaurant_type_name',
                'filter' => 'where'
            ],
            'restaurant_type_id' => [
                'type' => 'out',
                'link' => [
                    ['left' => ['restaurant', 'id'], 'right' => ['restaurant_type', 'restaurant_id']],
                    ['left' => ['restaurant_type', 'type_id'], 'right' => ['type', 'id']],
                ],
                'field' => 'id',
                'alias' => 'restaurant_type_id',
                'filter' => 'where'
            ],
            'restaurant_city' => [
                'type' => 'in',
                'field' => 'city',
                'alias' => 'restaurant_city',
                'filter' => 'where'
            ],
            'restaurant_description' => [
                'type' => 'in',
                'field' => 'description',
                'alias' => 'restaurant_description',
                'filter' => 'like'
            ],
        ]);
    }
}
