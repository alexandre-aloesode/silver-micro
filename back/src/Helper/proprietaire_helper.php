<?php
namespace App\Helper;

class Proprietaire_Helper {

    public function __construct()
    {
    
    }

    public function Access($call, $payload, &$params)
    {
        $granted = [
            'getRestaurant',
        ];

        $limited = [
            'postRestaurant',
        ];

        if (in_array($call, $granted)) {
            return ($params);
        }

        if (in_array($call, $limited)) {
            return ($this->$call($payload, $params));
        }

        return (false);
    }

    private function postRestaurant($payload, &$params)
    {
        $params['id_user'] = (string)$payload->id;
        return ($params);
    }
}