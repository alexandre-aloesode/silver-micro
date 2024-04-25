<?php

namespace App\Controller;
// require_once 'vendor/autoload.php';
use App\Model\User_Model;
use App\Helper\Token_Helper;
require_once '/var/www/html/silver-micro/back/src/Helper/token_helper.php';

class Auth_Controller
{
    private int $id;
    private string $email;
    private string $password;
    private string $role;
    private string $phone;

    public function __construct($array)
    {
        isset($array['id']) ? $this->id = $array['id'] : null;
        $this->email = $array['email'];
        $this->password = $array['password'];
        isset($array['role']) ? $this->role = $array['role'] : null;
        isset($array['phone']) ? $this->phone = $array['phone'] : null;
    }

    public function login()
    {
        $user = new User_Model();
        $checkExistingUser = $user->readOneByString('email', $this->email);
        if ($checkExistingUser) {
            if (password_verify($this->password, $checkExistingUser[0]['password'])) {
                $payload = [
                    'id' => $checkExistingUser[0]['id'],
                    'email' => $checkExistingUser[0]['email'],
                    'role' => $checkExistingUser[0]['role']
                ];
                $token = new Token_Helper();
                $jwt = $token->generateToken($payload);
                echo json_encode([
                    'success' => true, 
                    'token' => $jwt,
                    'user' => $payload,
                    'message' => 'Connexion réussie'
                ]);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Mot de passe incorrect']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Informations incorrectes']);
            return;
        }
    }

    public function login_post()
    {
        var_dump($_POST);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        // header('Location: /my-little-mvc/');
        exit;
    }

    public function register()
    {
        $register = new User_Model();
        $mail_already_exist = $register->readOnebyString('email', $this->email);
        if ($mail_already_exist) {
            echo json_encode(['success' => false, 'message' => 'Cet email existe déjà']);
        } else {
            $register->createOne([
                ':email' => $this->email,
                ':password' => password_hash($this->password, PASSWORD_DEFAULT),
                ':role' => $this->role == "3" ? "1" : $this->role
            ]);
            echo json_encode(['success' => true, 'message' => 'Utilisateur créé avec succès']);
        }
    }
}
