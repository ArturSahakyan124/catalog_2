<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $login;
    private $password;
    private $userModel;
    private array $error = [];

    public function __construct() {
        $this->get();
        $this->validation();
        $this->auth();
    }

    public function get() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->login = $_POST['login'] ?? '';
            $this->password = $_POST['password'] ?? '';
        }
    }

    public function validation() {
        if ($this->login == '' || $this->password == '') {
            $this->error[] = 'wrong login or password';
        }

        if (!empty($this->error)) {
            echo json_encode([
                "status" => false,
                "type" => 1,
                "message" => $this->error
            ]);
            return false;
        }
    }

    private function auth() {
        $db = Database::getInstance();
        $this->userModel = new User($db);

        if ($this->userModel->login($this->login, $this->password)) {
            echo json_encode([
                "status" => true,
                "message" => "Login successful"
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Invalid login or password"
            ]);
        }
    }
}

new AuthController();
?>
