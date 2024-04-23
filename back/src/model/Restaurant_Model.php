<?php
namespace App\Model;
use App\Model\Abstract\Abstract_Model;
require_once '/var/www/html/silver-micro/back/src/model/Abstract/Abstract_Model.php';
use APP\Helper\API_Helper;
require_once '/var/www/html/silver-micro/back/src/helpers/api_helper.php';

use APP\Helper\Status_Helper;
require_once '/var/www/html/silver-micro/back/src/helpers/status_helper.php';

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
        ['name', 'mandatory', 'string'], ['address', 'mandatory', 'string'],
        ['zipCode', 'mandatory', 'number']
        //  ['comment', 'mandatory', 'string'],
        // ['type', 'optional', 'string']
    ];
    if ($this->api_helper->checkParameters($params, $constraints) == false)
    { return ($this->status_helper->PreconditionFailed()); }

    // $this->db->trans_start();

    $data = [
        'name' => $params['name'],
        'address' => $params['address'],
        'zip_code' => $params['zipCode'],
        // 'creation_date' => date('Y-m-d H:i:s'),
        // 'author' => $email,
        // 'type' => isset($params['type']) ? $params['type'] : 'PEDA'
    ];

    $optional_fields = [
        ['type', 'type'],
    ];

    foreach ($optional_fields as $field)
    {
        if (array_key_exists($field[1], $params))
        {
            $data[$field[0]] = $params[$field[1]];
        }
    }

    $pdo = self::getPdo();
    $sql = $this->buildPost($data);
    $request = $pdo->prepare($sql);
    $response = $request->execute($data);
    return ($response === true ? $pdo->lastInsertId() : false);
    // $response = $pdo->insert($this->tableName, $data);
    // return ($response === true ? $this->pdo->insert_id() : false);
    

    // $response = $this->db->insert($this->table, $data);
    // $this->db->trans_complete();
    
    // return ($response === true ? $this->db->insert_id() : false);
}
}