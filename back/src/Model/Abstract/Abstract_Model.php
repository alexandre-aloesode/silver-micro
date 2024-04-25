<?php

namespace App\Model\Abstract;

require_once '/var/www/html/silver-micro/back/constants.php';
use APP\Helper\Status_Helper;

abstract class Abstract_Model
{
    protected string $tableName;

    protected static $pdo;

    protected $api_helper;

    protected $status_helper;


    public function __construct()
    {
        // $this->status_helper = new Status_Helper();
    }

    public static function connect()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        self::$pdo = new \PDO($dsn, DB_USER, DB_PWD);
    }

    protected static function getPdo()
    {
        if (!self::$pdo) {
            self::connect();
        }
        return self::$pdo;
    }

    public function createOne(array $params)
    {

        $fieldsName = implode(', ', array_keys($params));
        $fieldsName = str_replace(':', '', $fieldsName);

        $fieldsSqlValue = implode(', ', array_keys($params));

        $requestCreateOne = "INSERT INTO $this->tableName ($fieldsName) VALUES ($fieldsSqlValue)";

        $queryCreateOne = self::getPdo()->prepare($requestCreateOne);

        $queryCreateOne->execute($params);
    }

    public function readAll(): array
    {

        $requestReadAll = "SELECT * FROM $this->tableName";

        $queryReadAll = self::getPdo()->prepare($requestReadAll);

        $queryReadAll->execute();

        $resultReadAll = $queryReadAll->fetchAll();

        return $resultReadAll;
    }

    public function readAllWithLimit(int $limit, int $offset): array
    {

        $requestReadAll = "SELECT * FROM $this->tableName LIMIT $limit OFFSET $offset";

        $queryReadAll = self::getPdo()->prepare($requestReadAll);

        $queryReadAll->execute();

        $resultReadAll = $queryReadAll->fetchAll();

        return $resultReadAll;
    }


    public function readOnebyId(int $id): array
    {
        $requestReadOne = "SELECT * FROM $this->tableName WHERE id = :id";

        $queryReadOne = self::getPdo()->prepare($requestReadOne);

        $queryReadOne->execute(['id' => $id]);

        $resultReadOne = $queryReadOne->fetchAll();

        return $resultReadOne;
    }


    public function readOnebyString(string $fieldName, string $input): array
    {
        $requestReadOne = "SELECT * FROM $this->tableName WHERE $fieldName = :$fieldName";

        $queryReadOne = self::getPdo()->prepare($requestReadOne);

        $queryReadOne->execute([$fieldName => $input]);

        $resultReadOne = $queryReadOne->fetchAll();

        return $resultReadOne;
    }

    public function readOnebyForeignKey(string $foreignKey, int $keyValue, $order): array
    {
        if($order == "void") {
            
            $requestReadOne = "SELECT * FROM $this->tableName WHERE $foreignKey = :$foreignKey";
        }

        else {

            $requestReadOne = "SELECT * FROM $this->tableName WHERE $foreignKey = :$foreignKey ORDER BY $order";
        }

        $queryReadOne = self::getPdo()->prepare($requestReadOne);

        $queryReadOne->execute([':' . $foreignKey => $keyValue]);

        $resultReadOne = $queryReadOne->fetchAll();

        return $resultReadOne;
    }

    public function readLast(): int
    {
        $requestReadLast = "SELECT id FROM $this->tableName ORDER BY id DESC LIMIT 1";

        $queryReadLast = self::getPdo()->prepare($requestReadLast);

        $queryReadLast->execute();

        $resultReadLast = $queryReadLast->fetchAll();

        return $resultReadLast[0][0];
    }

    public function readOneSingleInfo(string $field, string $key, int $id)
    {

        $sql = "SELECT $field FROM $this->tableName WHERE $key = :$key";

        $query = self::getPdo()->prepare($sql);

        $query->execute([
            ':' . $key => $id
        ]);

        $result = $query->fetchAll();

        return $result[0][0];
    }


    public function countAll(): int
    {
        $requestCountAll = "SELECT COUNT(*) AS total_entries FROM $this->tableName";
        $queryCountAll = self::getPdo()->prepare($requestCountAll);
        $queryCountAll->execute();
        $resultCountAll = $queryCountAll->fetch();
        $totalEntries = $resultCountAll['total_entries'];
        return $totalEntries;
    }

    public function countByCriteria(string $fieldName, string $fieldValue): int
    {
        $requestCountByCriteria = "SELECT COUNT(*) AS total_entries FROM $this->tableName WHERE $fieldName = :fieldValue";
        $queryCountByCriteria = self::getPdo()->prepare($requestCountByCriteria);
        $queryCountByCriteria->execute([':fieldValue' => $fieldValue]);
        $resultCountByCriteria = $queryCountByCriteria->fetch();
        $totalEntries = $resultCountByCriteria['total_entries'];
        return $totalEntries;
    }

    public function addAmounts(string $fieldName, string $fieldValue): int
    {
        $requestTotalAmount = "SELECT SUM(total_amount) AS total FROM $this->tableName WHERE $fieldName = :fieldValue";
        $queryTotalAmount = self::getPdo()->prepare($requestTotalAmount);
        $queryTotalAmount->execute([':fieldValue' => $fieldValue]);
        $resultTotalAmount = $queryTotalAmount->fetch();
        $totalAmount = $resultTotalAmount['total'];
        return $totalAmount;
    }

    public function updateOne(array $params)
    {

        //Récupération des params puis suppression du dernier élément du tableau, à savoir l'id, qu'on ne veut pas update
        $fieldsToUpdate = $params;
        array_pop($fieldsToUpdate);

        //Création du tableau dans lequel stocker notre string de requête d'update
        $requestString = [];

        //Boucle pour alimenter notre tableau
        foreach ($fieldsToUpdate as $key => $value) {

            $fieldName = str_replace(':', '', $key);
            $requestString[] = $fieldName . ' = ' . $key;
        }

        //Conversion du tableau en string
        $requestString = implode(', ', $requestString);

        $requestUpdateOne = "UPDATE $this->tableName SET $requestString WHERE id = :id";

        $queryUpdateOne = self::getPdo()->prepare($requestUpdateOne);

        $queryUpdateOne->execute($params);
    }

    public function deleteOne(array $params)
    {
        $fieldsArray = [];

        foreach ($params as $key => $value) {
            $fieldsArray[] = $key;
        }

        $input1 = $fieldsArray[0];
        $fieldName1 = str_replace(':', '', $input1);

        if (count($fieldsArray) > 1) {

            $input2 = $fieldsArray[1];
            $fieldName2 = str_replace(':', '', $input2);
            $requestDeleteOne = "DELETE FROM $this->tableName WHERE $fieldName1 = $input1 AND $fieldName2 = $input2";
        } else {

            $requestDeleteOne = "DELETE FROM $this->tableName WHERE $fieldName1 = $input1";
        }

        $queryDeleteOne = self::getPdo()->prepare($requestDeleteOne);

        $queryDeleteOne->execute($params);
    }

    public function buildGet($fields, $params)
    {
        $selectedFields = [];
        $where = [];
        if (count($params) == 0) {
            $sql = "SELECT * FROM " . $this->tableName;
        } else {
            foreach ($params as $key => $value) {
                foreach($fields as $field) {                   
                    if ($key == $field['alias']) {
                        $selectedFields[] = $this->tableName . '.' . $field['field'] . ' AS ' . $field['alias'];
                        if ($value != '') {
                            $where[] = $field['field'] . ' =' . $value;
                        }
                    }
                }
            }
            $where = implode(' AND ', $where);
            $sql = $where == '' ?
                "SELECT " . implode(', ', $selectedFields) . " FROM " . $this->tableName
                :
                "SELECT " . implode(', ', $selectedFields) . " FROM " . $this->tableName . " WHERE " . $where;
        }
        return $sql;
    }

    public function buildPost($params) {
        $fields = [];
        $values = [];
        foreach ($params as $key => $value) {
            // if ($value != '') {
                $fields[] = $key;
                $values[] = ':' . $key;
            // }
        }
        $fields = implode(', ', $fields);
        $values = implode(', ', $values);
        $sql = "INSERT INTO " . $this->tableName . " (" . $fields . ") VALUES (" . $values . ")";
        return $sql;
    }

    public function buildPut($fields, $params) {
        $set = [];
        $where = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $fields)) {
                if ($value != '') {
                    $set[] = $key . ' = :' . $key;
                }
                else {
                    $where[] = $key . ' = :' . $key;
                }
            }
        }
        $set = implode(', ', $set);
        $where = implode(' AND ', $where);
        $sql = "UPDATE " . $this->tableName . " SET " . $set . " WHERE " . $where;
        return $sql;
    }

    public function buildExecute($params)
    {
        $execute = [];
        foreach ($params as $key => $value) {
            if ($value != '') {
                $execute[':' . $key] = $value;
            }
        }
        if (count($execute) == 0) {
            $execute = null;
        }
        return $execute;
    }
}
