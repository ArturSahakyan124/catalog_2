<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helper.php';

class AuthController {
    private $login;
    private $password;
    private $userModel;
    private array $error = [];

    public function __construct() {


        if(isset($_POST['logout'])){

            $this->logout();
            exit;

        }
      
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

            jsonStatus(false,$this->error);
            return false;
        }
    }

    private function auth() {

        $db = Database::getInstance();
        $this->userModel = new User($);

        if ($this->userModel->login($this->login, $this->password)) {

            jsonStatus(true,"Login successful");

        } else {
            jsonStatus(false, "Invalid login or password");
        }
    }
    public function logout() {
                
        session_start();
        unset($_SESSION['user']);
        header('Location: ../views/auth/login.php');

    }
}

new AuthController();
?>
