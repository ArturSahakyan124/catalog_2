<?php
require_once '../../config/database.php';
session_start();

$connection = Database::getInstance(); 
$user_id = $_SESSION['user']['id'] ?? 0;
$status = $_POST['status'] ?? 'all';  
try {

    if ($status === 'myCar') {
        $stmt = $connection->prepare("SELECT * FROM cars WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$user_id]);
    } else {
        $stmt = $connection->query("SELECT * FROM cars ORDER BY id DESC");
    }
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . htmlspecialchars($e->getMessage());
    exit;
}

if (!$cars) {
    echo "<div>No cars found</div>";
    return;
}

foreach ($cars as $car):

    $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$car['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="product-box">
    <img 
        class="product-img" 
        src="../../assets/<?= htmlspecialchars($car['photo']) ?>" 
        alt="Photo"
    >
    <div class="product-info">
        <div class="product-title">
            <div class="car-name"><?= htmlspecialchars($car['name']) ?></div>
            <div class="model"><?= htmlspecialchars($car['model']) ?></div>
        </div>
        <div class="product-details">
            Year: <?= htmlspecialchars($car['year']) ?>
        </div>
        <div>ID: <?= htmlspecialchars($car['id']) ?></div>
        <div>User: <?= htmlspecialchars($user['username']) ?></div>
        <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>" class="car-id">
    </div>
     
    
    <?php if ($user_id == $car['user_id']): ?>
        <div class="product-actions">
            <button class="action-btn action-edit">Edit</button>
            <form>
                <input type="hidden" name="CarId" value="<?= htmlspecialchars($car['id']) ?>">
                <button class="action-btn action-delete">Delete</button>
            </form>
        </div>
    <?php endif; ?>

    
</div>
<?php endforeach; ?>
