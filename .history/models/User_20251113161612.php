<?php

session_start();
class User {
    private $db;
    public $id;
    public $username;
    public $email;
    public $password_hash;

    public function __construct($database) {
        $this->db = $database;
    }

 
    public function register($username, $email, $password, $avatar) {
 
    $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        return false;  
    }

 
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

 
    $stmt = $this->db->prepare("
        INSERT INTO users (username, email, password_hash, avatar)
        VALUES (?, ?, ?, ?)
    ");

    return $stmt->execute([$username, $email, $password_hash, $avatar]);

    }

 
    public function login($username, $password) {
 
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

 
        if ($user && password_verify($password, $user['password_hash'])) {
 
            $_SESSION['user'] = [
                        "id" => $user['id'],
                        "avatar" => $user['avatar'],
                        "email" => $user['email'],
                        "login" => $user['username']
                ];

            return true;
        }
        return false;
    }
 

 
}
?>