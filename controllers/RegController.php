<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

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

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '../../assets/uploads/userPhoto/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = uniqid() . '_' . basename($_FILES['avatar']['name']);
                $uploadPath = $uploadDir . $fileName;

                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath);

                $this->avatarPath = 'uploads/userPhoto/' . $fileName;

            }
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
            echo json_encode([
                "status" => false,
                "type" => 1,
                "message" => $this->error
            ]);
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
            echo json_encode([
                "status" => true,
                "message" => "Registration successful"
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "User with this email already exists"
            ]);
        }
    }
}

new RegController();
?>
