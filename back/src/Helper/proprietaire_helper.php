<?php
namespace App\Helper;

use App\Model\Restaurant_Model;

class Proprietaire_Helper {

    public function __construct()
    {
    
    }

    public function Access($call, $payload, &$params)
    {
        $granted = [
            'getCapacity',
            'getDay',
            'getHour',
            'getType',
        ];
        
        $limited = [
            'getRestaurant',

            'postRestaurant',
            'putRestaurant',

            'getRestaurantSchedule',
            'postRestaurantSchedule',
            'deleteRestaurantSchedule'
        ];

        if (in_array($call, $granted)) {
            return ($params);
        }

        if (in_array($call, $limited)) {
            return ($this->$call($payload, $params));
        }

        return (false);
    }

    private function isRestaurantInScope($payload, $params)
    {
        if (!isset($params['restaurant_id'])) {
            return (false);
        }
        $restaurant = new Restaurant_Model();
        $restaurant = $restaurant->getRestaurant([
            'restaurant_id' => '',
            'restaurant_owner_id' => (string)$payload->id,
        ]);
        foreach ($restaurant as $key => $value) {
            if ($value['restaurant_id'] == $params['restaurant_id']) {
                return ($params);
            }
        }
        return (false);
    }

    private function getRestaurant($payload, &$params)
    {
        $params['restaurant_owner_id'] = (string)$payload->id;
        return ($params);
    }

    private function postRestaurant($payload, &$params)
    {
        $params['id_user'] = (string)$payload->id;
        return ($params);
    }

    private function putRestaurant($payload, &$params)
    {
        if (!isset($params['restaurant_id'])) {
            return (false);
        }
        return ($this->isRestaurantInScope($payload, $params));
    }

    private function getRestaurantSchedule($payload, &$params)
    {
        if(!isset($params['restaurant_id']))
        {
            return false;
        }
        return ($this->isRestaurantInScope($payload, $params));
    }

    private function postRestaurantSchedule($payload, &$params)
    {
        if(!isset($params['restaurant_id']))
        {
            return false;
        }
        return ($this->isRestaurantInScope($payload, $params));
    }

    private function deleteRestaurantSchedule($payload, &$params)
    {
        if(!isset($params['restaurant_id']))
        {
            return false;
        }
        if($this->isRestaurantInScope($payload, $params) !== false)
        {
            unset($params['restaurant_id']);
            return ($params);
        }
        return false;
    }
}