<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../libs/View.php';
require_once __DIR__ . '/../helper.php';

class AuthController
{
    private $view;
    private $userModel;
    private $username;
    private $email;
    private $password;
    private $avatarPath;

    public function __construct()
    {
        $this->view = new View();
        $this->userModel = new User();

        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->avatarPath = '';
    }

    private function loadData()
    {
        $this->username = trim($_POST['username'] ?? '');
        $this->email = trim($_POST['email'] ?? '');
        $this->password = trim($_POST['password'] ?? '');
        $this->avatarPath = uploadPhoto('avatar', 'avatars');
    }

    // ✅ регистрация
    public function register()
    {
        $this->loadData();

        if (empty($this->username) || empty($this->email) || empty($this->password)) {
            jsonStatus(false, 'Please fill all fields');
            return;
        }

        $success = $this->userModel->register($this->username, $this->email, $this->password, $this->avatarPath);

        jsonStatus($success, $success ? 'User registered!' : 'User already exists');
    }

    // ✅ вход
    public function login()
    {
        $this->loadData();

        if (empty($this->username) || empty($this->password)) {
            jsonStatus(false, 'Fill all fields');
            return;
        }

        $success = $this->userModel->login($this->username, $this->password);
        jsonStatus($success, $success ? 'Login successful' : 'Invalid credentials');
    }

    // ✅ выход
    public function logout()
    {
        session_destroy();
        jsonStatus(true, 'Logged out');
    }

    // ✅ отображение auth.tpl без редиректа
    public function showAuthPage()
    {
        $this->view->render('auth.tpl');
    }
}

// ====== запуск ======
$controller = new AuthController();
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'register':
        $controller->register();
        break;
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->showAuthPage();
        break;
}
