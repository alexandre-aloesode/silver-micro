<?php

namespace App\Controller\Abstract;

use App\Helper\Token_Helper;
use App\Helper\Restaurant_Helper;

require_once '/var/www/html/silver-micro/back/src/helpers/token_helper.php';

abstract class Abstract_Controller
{

    public int $id;
    public string $email;
    public string $role;
    public bool $is_verified;
    public $helper;
    public $model;

    public function __construct()
    {
        $token = new Token_Helper();
        $token_verify = $token->verifyToken($_POST['token']);
        if (!$token_verify) {
            echo json_encode(['success' => false, 'message' => 'Token invalide']);
            return;
        }
        $this->id = $token_verify->id;
        $this->email = $token_verify->email;
        $this->role = $token_verify->role;
        $this->is_verified = true;

        if ($this->role == 'restaurant') {
            require_once '/var/www/html/silver-micro/back/src/helpers/restaurant_helper.php';
            $this->helper = new Restaurant_Helper();
        }
    }
}
