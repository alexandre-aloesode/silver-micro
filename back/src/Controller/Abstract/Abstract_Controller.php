<?php

namespace App\Controller\Abstract;

use App\Helper\Token_Helper;
use APP\Helper\Status_Helper;
use App\Helper\Proprietaire_Helper;
use App\Helper\Gerant_Helper;
use App\Helper\Client_Helper;
require_once '/var/www/html/silver-micro/back/src/Helper/token_helper.php';
require_once '/var/www/html/silver-micro/back/src/Helper/status_helper.php';
require_once '/var/www/html/silver-micro/back/src/Helper/api_helper.php';

abstract class Abstract_Controller
{
    public bool $is_verified;
    public $helper;
    public $model;
    public $payload;
    public $status_helper;

    public function __construct()
    {
        $token = new Token_Helper();
        $token_verify = $token->verifyToken($_POST['token']);
        if (!$token_verify) {
            echo json_encode(['success' => false, 'message' => 'Token invalide']);
            return;
        }

        $this->is_verified = true;
        $this->payload = $token_verify;

        $this->status_helper = new Status_Helper();

        if ($this->payload->role == 'proprietaire') {
            require_once '/var/www/html/silver-micro/back/src/Helper/proprietaire_helper.php';
            $this->helper = new Proprietaire_Helper();
        }
        if ($this->payload->role == 'gerant') {
            require_once '/var/www/html/silver-micro/back/src/Helper/gerant_helper.php';
            $this->helper = new Gerant_Helper();
        }
        if ($this->payload->role == 'client') {
            require_once '/var/www/html/silver-micro/back/src/Helper/client_helper.php';
            $this->helper = new Client_Helper();
        }
    }
}
