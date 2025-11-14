public function update()
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

    $car = $this->carModel->getById($id);
    if (!$car || $car['user_id'] != $this->userId) {
        jsonStatus(false, 'Access denied');
        return;
    }

    $this->loadData();
    $this->validate(true);

    // если фото не загружено — оставляем старое
    $photo = $this->photoPath ?: $car['photo'];

    $success = $this->carModel->update($id, $this->name, $this->model, $this->year, $photo);
    jsonStatus($success, $success ? 'Car updated!' : 'Error updating car');
}
