<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Booking_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'booking');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'booking';
    }

    public function postBooking($params)
    {
        $constraints = [
            ['user_id', 'mandatory', 'number'],
            ['restaurant_id', 'mandatory', 'number'], ['capacity_id', 'mandatory', 'number'],
            ['schedule_id', 'mandatory', 'number'],

        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'user_id' => $params['user_id'],
            'restaurant_id' => $params['restaurant_id'],
            'capacity_id' => $params['capacity_id'],
            'schedule_id' => $params['schedule_id'],
        ];

        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getBooking($params) {

        $constraints = [
            ['booking_id', 'optional', 'number', true], ['restaurant_id', 'optional', 'number'],
            ['capacity_id', 'optional', 'number'], ['schedule_id', 'optional', 'number'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getFollowupFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));
    }

    private function getFollowupFields()
    {
        return ([
			'booking_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'booking_id',
                'filter' => 'where'
            ],
            'user_id' => [
                'type' => 'in',
                'field' => 'user_id',
                'alias' => 'user_id',
                'filter' => 'where'
            ],
            'restaurant_id' => [
                'type' => 'in',
                'field' =>'restaurant_id',
                'alias' => 'restaurant_id',
                'filter' => 'like'
            ],
            'capacity_id' => [
                'type' => 'in',
                'field' =>'capacity_id',
                'alias' => 'capacity_id',
                'filter' => 'where'
            ],
            'schedule_id' => [
                'type' => 'in',
                'field' =>'schedule_id',
                'alias' => 'schedule_id',
                'filter' => 'where'
            ],
            // 'booking_type' => [
            //     'type' => 'out',
            //     'link' => [
            //         ['left' => ['booking', 'id'], 'right' => ['booking_type', 'booking_id']],
            //         ['left' => ['booking_type', 'type_id'], 'right' => ['type', 'id']],
            //     ],
            //     'field' =>'name',
            //     // 'field' =>'booking_id',
            //     'alias' => 'booking_type',
            //     'filter' => 'like'
            // ],
        ]);
    }
}
