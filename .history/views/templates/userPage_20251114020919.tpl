<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Management</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <div class="wrap">
        <div class="toolbar">
            <div class="title">
                Cars
                <input id="search" class="search" type="search" placeholder="Search" />
            </div>
            <div>
                <button id="add-btn" class="primary-btn">+ Add Car</button>
                <button id="myCarBtn" class="primary-btn">My Cars</button>
            </div>
            <div class="user">
                <div class="user-img">
                    <img src="../assets/{$user.avatar}" width="200" alt="User Avatar">
                </div>
                <div class="user-info">
                    <h2 style="margin: 10px 0;">
                        <a href="vendor/profilePage/userProfile.php?id={$user.id}">{$user.login}</a>
                    </h2>
                    <a href="#">{$user.email}</a>
                    <form method="post" action="../controllers/AuthController.php">
                        <input type="hidden" name="logout">
                        <button class="secondary-btn logout-btn">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <main id="main"></main>

    <div id="modal" class="modal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-header">
                <div id="modalTitle" class="modal-title">New Car</div>
                <button class="close" id="close-modal" aria-label="Close">×</button>
            </div>

            <form id="carForm" enctype="multipart/form-data">
                <div class="row form-2col">
                    <input type="hidden" name="id" id="form-id">
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
                        <p>Drop he</p>
                        <input type="file" class="img-input" id="photo" name="photo" accept="image/*">
                    </div>

          
                </div>

                <div class="actions">
                    <button type="submit" class="save-btn btn btn-primary">Save</button>
                </div>
                <p class="msg none">e</p>
            </form>
        </div>
    </div>

    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/ajaxHelper.js"></script>
    <script src="../assets/js/profile/profile.js"></script>
    <script src="../assets/js/profile/profileAjax.js"></script>
    <script src="../assets/components/carCard.js"></script>
</body>
</html>
