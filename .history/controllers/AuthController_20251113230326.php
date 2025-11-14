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
        try {
            $this->avatarPath = uploadPhoto('avatar', 'avatars');
        } catch (\Exception $e) {
            $this->avatarPath = '';
            jsonStatus(false, 'Avatar upload failed: ' . $e->getMessage());
            exit;
        }
    }

    private function respond($success, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }

    public function register()
    {
        $this->loadData();

        if (empty($this->username) || empty($this->email) || empty($this->password)) {
            $this->respond(false, 'Please fill all fields');
        }

        try {
            $success = $this->userModel->register($this->username, $this->email, $this->password, $this->avatarPath);
            $this->respond($success, $success ? 'User registered!' : 'User already exists');
        } catch (\Exception $e) {
            $this->respond(false, 'Registration error: ' . $e->getMessage());
        }
    }

    public function login()
    {
        $this->loadData();

        if (empty($this->username) || empty($this->password)) {
            $this->respond(false, 'Fill all fields');
        }

        try {
            $success = $this->userModel->login($this->username, $this->password);
            $this->respond($success, $success ? 'Login successful' : 'Invalid credentials');
        } catch (\Exception $e) {
            $this->respond(false, 'Login error: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            session_unset();
            session_destroy();
            $this->respond(true, 'Logged out');
        } catch (\Exception $e) {
            $this->respond(false, 'Logout error: ' . $e->getMessage());
        }
    }

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
