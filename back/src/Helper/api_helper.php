<?php
namespace App\Helper;
class API_Helper
{
    private $db;
    private $table;

    public function __construct($db, $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function addLimitAndOffset($params)
    {
        $limit = 0;
        $offset = 0;
        if (isset($params['offset']) && !empty($params['offset']))
        {
            $offset = intval($params['offset']);
        }
        if (isset($params['limit']) && !empty($params['limit']))
        {
            $limit = intval($params['limit']);
        }

        if ($limit != 0)
        {
            $this->db->limit($limit, $offset);
        }
    }

    public function checkParameters(&$params, $constraints)
    {
        $clean_params = [];
        foreach ($constraints as $constraint => $value)
        { 
            if (isset($params[$value[0]]))
            {
                if ($this->checkParameter($params[$value[0]], $value) == false)
                {
                    // var_dump($params[$value[0]]);
                    return (false);
                }
                $clean_params[$value[0]] = $params[$value[0]];
            }
            else
            {
                  if ($value[1] == "mandatory")
                {
                    // var_dump("error on mandatory ".$value[0]);
                    return (false);
                }
            }
        }

        if (count($clean_params) == 0)
        {
            return (false);
        }

        if (isset($params['order']) && gettype($params['order']) == "string")
        {
       
            $clean_params['order'] = $params['order'];
            if (isset($params['desc']))
            {
                $clean_params['desc'] = '';
            }
        }

        if (isset($params['limit']) && gettype($params['limit']) == "string" && is_numeric($params['limit']))
        {
            $clean_params['limit'] = $params['limit'];
        }
        if (isset($params['offset']) && gettype($params['offset']) == "string" && is_numeric($params['offset']))
        {
            $clean_params['offset'] = $params['offset'];
        }

        $params = $clean_params;
        return (true);
    }

    private function checkParameter(&$param, $constraint)
    {
        $type = gettype($param);
        $mandatory = $constraint[1] == "mandatory" ? true : false;
        $expected_type = $constraint[2];
        $can_be_array = false;
        if (isset($constraint[3]) && $constraint[3] === true)
            $can_be_array = true;

        if ($type == "string")
        {
            if ($expected_type == "array") { return (false); }
            if (strlen($param) <= 0)
            {
                if ($mandatory) { return (false);}
                return (true);
            }
            else
            {
                if ($this->checkType($param, $expected_type) == false) 
                return (false);
            }
        }
        else if ($type == "array")
        {
            if ($expected_type != 'array' && $can_be_array == false)
            {
                return (false);
            }
            if (count($param) <= 0)
            {
                if ($mandatory) { return (false); }
                return (true);
            }
            else
            {
                if ($expected_type == "array") { $expected_type = $constraint[3]; }
                if ($expected_type == "other") { return (true); }
                foreach ($param as $key => &$value)
                {
                    if (gettype($value) != "string" || strlen($value) <= 0)
                    {
                        return (false);
                    }
                    if ($this->checkType($value, $expected_type) == false)
                        return (false);
                }
            }
        }
        else
        {
            return (false);
        }

        return (true);
    }

    private function checkType(&$value, $type)
    {
        $value = trim($value);
        if ($type == 'none') { return (false); }
        if ($type == "boolean" && $value != '0' && $value != '1')
        {
            return (false);
        }
        else if ($type == "number" && !is_numeric($value))
        {
            return (false);
        }
        else if ($type != "string" && $type != "boolean" && $type != "number")
        {
            return (false);
        }        
        return (true);
    }
}

?>