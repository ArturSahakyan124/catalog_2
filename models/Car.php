<?php
require_once __DIR__ . '/../config/database.php';

class Car {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM cars ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM cars WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM cars WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($userId, $name, $model, $year, $photo) {
        $stmt = $this->db->prepare("
            INSERT INTO cars (user_id, name, model, year, photo) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$userId, $name, $model, $year, $photo]);
    }
    
    public function update($id, $name, $model, $year, $photo) {
        $stmt = $this->db->prepare("
            UPDATE cars SET name = ?, model = ?, year = ?, photo = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$name, $model, $year, $photo, $id]);
    }
    
    public function delete($id, $userId) {
        $stmt = $this->db->prepare("DELETE FROM cars WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }
}
?>
