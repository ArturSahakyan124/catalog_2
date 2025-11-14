<?php

use Smarty\Smarty;

require_once __DIR__ . '/../models/Car.php';
require_once __DIR__ . '/../helper.php'; 
require_once __DIR__ . '/../libs/smarty/libs/Smarty.class.php';

$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/../views/templates/');
$smarty->setCompileDir(__DIR__ . '/../views/templates_c/');

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
            jsonStatus(false, 'User not authorized');
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

        $this->photoPath = uploadPhoto('photo','carPhoto');
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

        if (!$this->photoPath && ($_POST['status'] ?? '') !== 'update'){
            $errors[] = 'Enter photo';
        }

        if (!empty($errors)) {
            jsonStatus(false, $errors);
            exit;
        }
    }

    public function create()
    {
        $this->loadData();
        $this->validate();

        $photo = $this->photoPath;

        $success = $this->carModel->create($this->userId, $this->name, $this->model, $this->year, $photo);

        jsonStatus($success, $success ? 'Car added!' : 'Error adding car');
    }

    public function update()
    {
        $this->loadData();
        $this->validate();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            jsonStatus(false, 'ID not provided');
            return;
        }

        $car = $this->carModel->getById($id);

        if (!$car || $car['user_id'] != $this->userId) {
            jsonStatus(false, 'Access denied');
            return;
        }

        $photo = $this->photoPath ?? $car['photo']; 

        $success = $this->carModel->update($id, $this->name, $this->model, $this->year, $photo);
        $this->photoPath = null;

        jsonStatus($success, $success ? 'Car updated!' : 'Error updating car');
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            jsonStatus(false, 'ID not provided');
            return;
        }

        $success = $this->carModel->delete($id, $this->userId);

        jsonStatus($success, $success ? 'Car deleted!' : 'Error deleting car');
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
