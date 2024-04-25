<?php

namespace App\Model;

use App\Model\Abstract\Abstract_Model;
use APP\Helper\API_Helper;
use APP\Helper\Status_Helper;

class Type_Model extends Abstract_Model
{
    public function __construct()
    {
        parent::connect();
        $this->api_helper = new API_Helper('silver-micro', 'type');
        $this->status_helper = new Status_Helper();
        $this->tableName = 'restaurant';
    }

    public function postType($params)
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

    public function getType($params) {

        $constraints = [
            ['type_id', 'optional', 'number'], ['type_name', 'optional', 'string'],
        ];
        if ($this->api_helper->checkParameters($params, $constraints) == false)
        { return ($this->status_helper->PreconditionFailed()); }

        $fields = $this->getTypeFields();
        $sql = $this->buildGet($fields, $params);
        $pdo = self::getPdo();
        $request = $pdo->prepare($sql);
        $request->execute();
        return ($request->fetchAll(\PDO::FETCH_ASSOC));    
    }

    private function getTypeFields()
    {
        return ([
			'type_id' => [
                'type' => 'in',
                'field' =>'id',
                'alias' => 'type_id',
                'filter' => 'where'
            ],
            'type_name' => [
                'type' => 'in',
                'field' => 'type_name',
                'alias' => 'type_name',
                'filter' => 'none'
            ],
        ]);
    }
}
