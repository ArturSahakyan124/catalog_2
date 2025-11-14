<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../libs/View.php';
require_once __DIR__ . '/../helper.php';

class AuthController {
    private $login;
    private $password;
    private $email;
    private $username;
    private $avatarPath;
    private $userModel;
    private array $error = [];

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'login':
                    $this->getLoginData();
                    $this->validateLogin();
                    $this->auth();
                    break;

                case 'register':
                    $this->getRegisterData();
                    $this->validateRegister();
                    $this->register();
                    break;

                case 'logout':
                    $this->logout();
                    break;
            }
        } else {
            $this->renderPage();
        }
    }

    private function getLoginData() {
        $this->login = $_POST['login'] ?? '';
        $this->password = $_POST['password'] ?? '';
    }

    private function validateLogin() {
        if (empty($this->login) || empty($this->password)) {
            $this->error[] = 'Enter login and password';
        }

        if (!empty($this->error)) {
            jsonStatus(false, $this->error);
            exit;
        }
    }

    private function auth() {
        $db = Database::getInstance();
        $this->userModel = new User($db);

        if ($this->userModel->login($this->login, $this->password)) {
            jsonStatus(true, "Login successful");
        } else {
            jsonStatus(false, "Invalid login or password");
        }
    }

    private function getRegisterData() {
        $this->username = $_POST['login'] ?? '';
        $this->email = $_POST['email'] ?? '';
        $this->password = $_POST['password'] ?? '';
        $this->avatarPath = uploadPhoto('avatar', 'userPhoto');
    }

    private function validateRegister() {
        if (empty($this->username) || empty($this->email) || empty($this->password)) {
            $this->error[] = 'Fill in all fields';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error[] = 'Invalid email';
        }

        if (strlen($this->password) < 4) {
            $this->error[] = 'Password must be at least 4 characters';
        }

        if (!empty($this->error)) {
            jsonStatus(false, $this->error);
            exit;
        }
    }

    private function register() {
        $db = Database::getInstance();
        $this->userModel = new User($db);

        $success = $this->userModel->register(
            $this->username,
            $this->email,
            $this->password,
            $this->avatarPath
        );

        if ($success) {
            jsonStatus(true, 'Registration successful');
        } else {
            jsonStatus(false, 'User with this email already exists');
        }
    }

    private function logout() {
        unset($_SESSION['user']);
        header('Location: ../views/auth/login.php');
        exit;
    }

    private function renderPage() {
        $view = new View();

        $type = $_GET['page'] ?? 'login';
        if ($type === 'register') {
            $view->render('auth.tpl', ['type' => 'register']);
        } else {
            $view->render('auth.tpl', ['type' => 'login']);
        }
    }
}

new AuthController();
