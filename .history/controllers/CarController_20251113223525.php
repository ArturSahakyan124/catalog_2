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
    private $login;
    private $password;
    private $email;
    private $username;
    private $avatarPath;

    public function __construct()
    {
        $this->view = new View();
        $this->userModel = new User();

        $this->login = '';
        $this->password = '';
        $this->email = '';
        $this->username = '';
        $this->avatarPath = '';
    }

    private function loadData()
    {
        $this->login = trim($_POST['login'] ?? '');
        $this->password = trim($_POST['password'] ?? '');
        $this->email = trim($_POST['email'] ?? '');
        $this->username = trim($_POST['username'] ?? '');
        $this->avatarPath = uploadPhoto('avatar', 'avatars');
    }

    public function register()
    {
        $this->loadData();

        if (empty($this->login) || empty($this->password) || empty($this->email) || empty($this->username)) {
            jsonStatus(false, 'Please fill all fields');
            return;
        }

        if ($this->userModel->getUserByLogin($this->login)) {
            jsonStatus(false, 'Login already exists');
            return;
        }

        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $success = $this->userModel->createUser($this->username, $this->login, $this->email, $hashedPassword, $this->avatarPath);

        jsonStatus($success, $success ? 'User registered!' : 'Error during registration');
    }

    public function login()
    {
        $this->loadData();

        if (empty($this->login) || empty($this->password)) {
            jsonStatus(false, 'Fill all fields');
            return;
        }

        $user = $this->userModel->getUserByLogin($this->login);

        if (!$user || !password_verify($this->password, $user['password'])) {
            jsonStatus(false, 'Invalid login or password');
            return;
        }

        $_SESSION['user'] = $user;
        jsonStatus(true, 'Login successful');
    }

    public function logout()
    {
        session_destroy();
        jsonStatus(true, 'Logged out');
    }

    public function showAuthPage()
    {
        // ✅ Вместо перехода по URL — просто рендерим шаблон
        $this->view->render('auth.tpl');
    }
}

// ====== Запуск контроллера ======
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
        // ✅ показываем auth.tpl через контроллер, не через URL
        $controller->showAuthPage();
        break;
}
