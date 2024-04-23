<?php
namespace App\Helper;

class Restaurant_Helper {
    public function __construct()
    {
    
    }

    public function Access($call, $payload, &$params)
    {
        $granted = [
            'postRestaurant',
        ];

        $limited = [
            
        ];

        if (in_array($call, $granted)) {
            return ($params);
        }

        if (in_array($call, $limited)) {
            return ($this->$call($payload, $params));
        }

        return (false);
    }
}