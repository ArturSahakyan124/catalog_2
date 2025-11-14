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
        $db = Database::getInstance();
        $this->userModel = new User($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleAction($_POST['action']);
        } else {
            $this->renderPage();
        }
    }

    private function handleAction(string $action): void {
        switch ($action) {
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

            default:
                jsonStatus(false, "Unknown action");
        }
    }

    private function getLoginData(): void {
        $this->login = trim($_POST['login'] ?? '');
        $this->password = trim($_POST['password'] ?? '');
    }

    private function validateLogin(): void {
        if ($this->login === '' || $this->password === '') {
            $this->error[] = 'Enter login and password';
        }

        if (!empty($this->error)) {
            jsonStatus(false, $this->error);
            exit;
        }
    }

    private function auth(): void {
        if ($this->userModel->login($this->login, $this->password)) {
            jsonStatus(true, "Login successful");
        } else {
            jsonStatus(false, "Invalid login or password");
        }
    }

    private function getRegisterData(): void {
        $this->username = trim($_POST['login'] ?? '');
        $this->email = trim($_POST['email'] ?? '');
        $this->password = trim($_POST['password'] ?? '');
        $this->avatarPath = uploadPhoto('avatar', 'userPhoto');
    }

    private function validateRegister(): void {
        if ($this->username === '' || $this->email === '' || $this->password === '') {
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

    private function register(): void {
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

    private function logout(): void {
        session_destroy();
        header('Location: ../views/auth.tpl?page=login');
        exit;
    }

    private function renderPage(): void {
        $view = new View();
        $type = $_GET['page'] ?? 'login';
        $view->render('auth.tpl', ['type' => $type]);
    }
}

new AuthController();
