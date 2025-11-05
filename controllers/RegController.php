<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helper.php';

class RegController {
    private $username;
    private $email;
    private $password;
    private $avatarPath;
    private $userModel;
    private array $error = [];

    public function __construct() {
        $this->get();
        $this->validation();
        $this->register();
    }

    private function get() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->username = $_POST['login'] ?? '';
            $this->email = $_POST['email'] ?? '';
            $this->password = $_POST['password'] ?? '';
            $this->avatarPath = uploadPhoto('avatar', 'userPhoto');
        }
    }

    private function validation() {
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
}

new RegController();
?>
