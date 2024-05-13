<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Day_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'day');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'day';
    }

    public function postDay($params)
    {
        $constraints = [
        ['name', 'mandatory', 'string'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false) {
            return ($this->status_helper->PreconditionFailed());
        }

        // $this->db->trans_start();
        $data = [
            'name' => $params['name'],
        ];

        $pdo = self::getPdo();
        $sql = $this->buildPost($data);
        $request = $pdo->prepare($sql);
        $response = $request->execute($data);
        return ($response === true ? $pdo->lastInsertId() : false);
    }

    public function getDay($params) {

        $constraints = [
            ['day_id', 'optional', 'number'], ['day_name', 'optional', 'string'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getDayFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));    
    }

    private function getDayFields()
    {
        return ([
			'day_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'day_id',
                'filter' => 'where'
            ],
            'day_name' => [
                'type' => 'in',
                'field' => 'name',
                'alias' => 'day_name',
                'filter' => 'where'
            ],
        ]);
    }
}
