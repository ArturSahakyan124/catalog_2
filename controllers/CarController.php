<?php
require_once __DIR__ . '/../models/Car.php';

class CarController
{
    private $carModel;
    private $photoPath;
    private $name;
    private $model;
    private $year;
    private $userId;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            echo json_encode(['status' => false, 'message' => 'User not authorized']);
            exit;
        }

        $this->userId = $_SESSION['user']['id'];
        $this->carModel = new Car();
    }

    private function loadData()
    {
        $this->name = trim($_POST['name'] ?? '');
        $this->model = trim($_POST['model'] ?? '');
        $this->year = trim($_POST['year'] ?? '');

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {

            $uploadDir = __DIR__ . '/../assets/uploads/carPhoto/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $uploadPath = $uploadDir . $fileName;

            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
            $this->photoPath = 'uploads/carPhoto/' . $fileName;
        } 
    }

    private function validate()
    {
        $errors = [];

        if ($this->name === ''){
            $errors[] = 'Enter name';
        } 

        if ($this->model === ''){
            $errors[] = 'Enter model';
        }

        if (!is_numeric($this->year) || $this->year < 1900 || $this->year > date('Y') + 1){
            $errors[] = 'Invalid year';
        }
            

        if (!empty($errors)) {
            echo json_encode(['status' => false, 'message' => $errors]);
            exit;
        }
    }

    public function create()
    {
        $this->loadData();
        $this->validate();

        $photo = $this->photoPath;

        $success = $this->carModel->create($this->userId, $this->name, $this->model, $this->year, $photo);

        echo json_encode([
            'status' => $success,
            'message' => $success ? 'Car added!' : 'Error adding car'
        ]);
    }

    public function update()
    {
         
        $this->loadData();
        $this->validate();

        $id = $_POST['id'] ?? null;
 
        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID not provided']);
            return;
        }

        $car = $this->carModel->getById($id);

        if (!$car || $car['user_id'] != $this->userId) {
            echo json_encode(['status' => false, 'message' => 'Access denied']);
            return;
        }

        if ($this->photoPath) {
            $s = 1;
        } else {
            $s = 2;
        }
        $photo = $this->photoPath ?? $car['photo']; 
       

        $success = $this->carModel->update($id, $this->name, $this->model, $this->year, $photo);
        $this->photoPath = null;
        echo json_encode([
            'status' => $success,
            'message' => $s
            //$success ? 'Car updated!' : 'Error updating car'
        ]);
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID not provided']);
            return;
        }

        $success = $this->carModel->delete($id, $this->userId);

        echo json_encode([
            'status' => $success,
            'message' => $success ? 'Car deleted!' : 'Error deleting car'
        ]);
    }

 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CarController();
    $action = $_POST['status'] ?? 'create';

    switch ($action) {
        case 'delete':
            $controller->delete();
            break;
        case 'update':
            $controller->update();
            break;
        default:
            $controller->create();
            break;
    }
}
?>
