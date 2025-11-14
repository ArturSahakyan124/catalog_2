<?php
require_once __DIR__ . '/../models/Car.php';
require_once __DIR__ . '/../helper.php';
require_once __DIR__ . '/../libs/View.php';

session_start();

class CarController
{
    private $carModel;
    private $view;
    private $userId;
    private $name;
    private $model;
    private $year;
    private $photoPath;

    public function __construct()
    {
        $this->view = new View();
        $this->carModel = new Car();
        $this->userId = $_SESSION['user']['id'] ?? null;

        if ($this->userId) {
            $this->view->assign('user', $_SESSION['user']);
        }

        $this->name = '';
        $this->model = '';
        $this->year = '';
        $this->photoPath = '';
    }

    private function loadData()
    {
        $this->name = trim($_POST['name'] ?? '');
        $this->model = trim($_POST['model'] ?? '');
        $this->year = trim($_POST['year'] ?? '');
        $this->photoPath = uploadPhoto('photo', 'carPhoto');
    }

    private function validate()
    {
        $errors = [];

        if (empty($this->name)) $errors[] = 'Enter name';
        if (empty($this->model)) $errors[] = 'Enter model';
        if (!is_numeric($this->year) || $this->year < 1900 || $this->year > date('Y') + 1) {
            $errors[] = 'Invalid year';
        }
        if (!$this->photoPath && ($_POST['status'] ?? '') !== 'update') {
            $errors[] = 'Enter photo';
        }

        if (!empty($errors)) {
            jsonStatus(false, $errors);
            exit;
        }
    }

    public function create()
    {
        echo 'c';
        if (!$this->userId) {
            jsonStatus(false, 'User not authorized');
            exit;
        }

        $this->loadData();
        $this->validate();

        $success = $this->carModel->create($this->userId, $this->name, $this->model, $this->year, $this->photoPath);
        jsonStatus($success, $success ? 'Car added!' : 'Error adding car');
    }

    public function update()
    {
echo 'c';
        if (!$this->userId) {
            jsonStatus(false, 'User not authorized');
            exit;
        }

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

        $photo = $this->photoPath ?: $car['photo'];
        $success = $this->carModel->update($id, $this->name, $this->model, $this->year, $photo);
        jsonStatus($success, $success ? 'Car updated!' : 'Error updating car');
    }

    public function delete()
    {
        if (!$this->userId) {
            jsonStatus(false, 'User not authorized');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            jsonStatus(false, 'ID not provided');
            return;
        }

        $success = $this->carModel->delete($id, $this->userId);
        jsonStatus($success, $success ? 'Car deleted!' : 'Error deleting car');
    }

    public function showUserPage()
    {
        if (!$this->userId) {
            header('Location: AuthController.php');
            exit;
        }

        $this->view->render('userPage.tpl');
    }

    public function listCarsAjax(string $listStatus)
    {
        if (!$this->userId) {
            jsonStatus(false, 'User not authorized');
            exit;
        }

        $filter = $listStatus ?? 'all';
        $cars = ($filter === 'list')
            ? $this->carModel->getByUserId($this->userId)
            : $this->carModel->getAll();

        foreach ($cars as &$car) {
            $car['username'] = ($car['user_id'] == $this->userId)
                ? $_SESSION['user']['login']
                : 'User ' . $car['user_id'];
        }

        $this->view->assign('cars', $cars);
        $this->view->assign('user_id', $this->userId);
        echo $this->view->fetch('carList.tpl');
    }
}

$controller = new CarController();
$action = $_POST['status'] ?? '';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'list':
    case 'all':
        $controller->listCarsAjax($_POST['status']);
        break;
    default:
        $controller->showUserPage();
        break;
}
