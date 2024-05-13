<?php

namespace App\Helper;

class Client_Helper
{

    public function __construct()
    {
    }

    public function Access($call, $payload, &$params)
    {
        $granted = [
        ];

        $limited = [
            'getRestaurant',
        ];

        if (in_array($call, $granted)) {
            return ($params);
        }

        if (in_array($call, $limited)) {
            return ($this->$call($payload, $params));
        }

        return (false);
    }

    private function getRestaurant($payload, &$params)
    {
        $accepted_fields = [
            'restaurant_id', 'restaurant_name', 'restaurant_address', 
            'restaurant_zip_code', 'restaurant_phone', 'restaurant_email',
            'restaurant_images', 'restaurant_type', 'total_capacity',
            'average_price',
        ];

        foreach($params as $key => $value) {
            if (!in_array($key, $accepted_fields)) {
                unset($params[$key]);
            }
        }

        return ($params);
    }
}
