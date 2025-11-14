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
    }

    // --- LOGIN ---
    public function login() {
        $this->login = $_POST['login'] ?? '';
        $this->password = $_POST['password'] ?? '';

        if (empty($this->login) || empty($this->password)) {
            jsonStatus(false, 'Enter login and password');
            return;
        }

        if ($this->userModel->login($this->login, $this->password)) {
            jsonStatus(true, "Login successful");
        } else {
            jsonStatus(false, "Invalid login or password");
        }
    }

    // --- REGISTER ---
    public function register() {
        $this->username = $_POST['login'] ?? '';
        $this->email = $_POST['email'] ?? '';
        $this->password = $_POST['password'] ?? '';
        $this->avatarPath = uploadPhoto('avatar', 'userPhoto');

        if (empty($this->username) || empty($this->email) || empty($this->password)) {
            jsonStatus(false, 'Fill in all fields');
            return;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            jsonStatus(false, 'Invalid email');
            return;
        }

        if (strlen($this->password) < 4) {
            jsonStatus(false, 'Password must be at least 4 characters');
            return;
        }

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

    // --- LOGOUT ---
    public function logout() {
        unset($_SESSION['user']);
        header('Location: /login');
        exit;
    }

    // --- PAGE RENDERING ---
    public function showLogin() {
        $view = new View();
        $view->render('auth.tpl', ['type' => 'login']);
    }

    public function showRegister() {
        $view = new View();
        $view->render('auth.tpl', ['type' => 'register']);
    }
}

// ------------------- ROUTER -------------------

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            $controller->login();
            break;
        case 'register':
            $controller->register();
            break;
        case 'logout':
            $controller->logout();
            break;
        default:
            jsonStatus(false, 'Unknown action');
            break;
    }
    exit;
}

switch ($uri) {
    case 'login':
        $controller->showLogin();
        break;

    case 'register':
        $controller->showRegister();
        break;

    case 'logout':
        $controller->logout();
        break;

    default:
        header('Location: ../login');
        break;
}
