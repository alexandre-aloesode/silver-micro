<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Hour_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'hour');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'hour';
    }

    public function postHour($params)
    {
        $constraints = [
        ['hour', 'mandatory', 'string'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'time' => $params['time'],
        ];

        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getHour($params) {

        $constraints = [
            ['hour_id', 'optional', 'number'], ['hour_time', 'optional', 'string'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }
        $fields = $this->getHourFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));    
    }

    private function getHourFields()
    {
        return ([
			'hour_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'hour_id',
                'filter' => 'where'
            ],
            'hour_time' => [
                'type' => 'in',
                'field' => 'time',
                'alias' => 'hour_time',
                'filter' => 'where'
            ],
        ]);
    }
}
