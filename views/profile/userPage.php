

<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../auth/login.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authorization and Registration</title>
    <link rel="stylesheet" href="../../assets/css/profile.css">
	<link rel="stylesheet" href="../../assets/css/main.css">
</head>
 

    <!-- Profile -->
 
<body>
	<div class="wrap">
		<div class="toolbar">
			<div class="title">Cars
			<input id="search" class="search" type="search" placeholder="Search" /></div>
			<div>

				<button id="addBtn" class="btn btn-primary">+ Add car</button>
				<button id="myCarBtn" class="btn btn-primary">My cars</button>
		
			</div>
			
		<div class="user">
			<div class="user-img">
				<img src="../../assets/<?= $_SESSION['user']['avatar'] ?>" width="200" alt="">
			</div>
				<div class="user-info">
				<h2 style="margin: 10px 0;"><a href="vendor/profilePage/userProfile.php?id=<?= $_SESSION['user']['id'] ?>"><?= $_SESSION['user']['login'] ?></a></h2>
				<a href="#"><?= $_SESSION['user']['email'] ?></a>
				<!-- <a href="../../controllers/LogoutController.php" class="logout">logout</a> -->

				<form method="post" action="../../controllers/AuthController.php">
                	<input type="hidden" name="logout">
                	<button class="action-btn logout-btn">logout</button>
            	</form>

			</div>
 		</div>
			
		</div>
	</div>

	<main id="main">
	 
		
	</main>

	<div id="modal" class="modal" aria-hidden="true">
		<div class="modal-card">
			<div class="modal-header">
				<div id="modalTitle" class="modal-title">New Card</div>
				<button class="close-x" id="closeModal" aria-label="Close">×</button>
			</div>

			<form id="carForm" enctype="multipart/form-data">
				<div class="row form-2col">
					<input type="hidden" name="id" value="0" id="FormID">
					<input type="hidden" name="old_photo" value="">

					<div>
						<label class="label" for="name">Name</label>
						<input id="name" class="input" name="name" type="text" value="">
					</div>

					<div>
						<label class="label" for="model">Model</label>
						<input id="model" class="input" name="model" type="text" value="">
					</div>
				</div>

				<div class="row form-2col">
					<div>
						<label class="label" for="year">Year</label>
						<input id="year" class="input" name="year" type="number" value="">
					</div>
				</div>

				<div class="row">
					<label class="label" for="photo">Photo</label>

					<div class="drop-area" id="dropArea">
						<p> Select file </p>
						<input type="file" id="photo" name="photo" accept="image/*">
					</div>

					<div class="preview" id="preview">
						<img id="previewImg" alt="Preview">
					</div>
				</div>

				<div class="actions">
					<button type="submit" class="save-btn btn btn-primary">Save</button>
				</div>
				<p class="msg none">e</p>
			</form>
		</div>
	</div>
        <script src="../../assets/js/jquery-3.4.1.min.js"></script>
	<script src="../../assets/js/profile/profile.js"></script>
		<script src="../../assets/js/profile/dragAndDrop.js"></script>
	<script src="../../assets/js/profile/profile_ajax.js"></script>

</body>
 
</html>
