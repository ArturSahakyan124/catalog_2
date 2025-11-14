<?php
/* Smarty version 5.6.0, created on 2025-11-13 23:21:55
  from 'file:userPage.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_69165a039228c2_94382900',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6333948602066f9da0c200c8f6b20e5adfe971c1' => 
    array (
      0 => 'userPage.tpl',
      1 => 1763072295,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69165a039228c2_94382900 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\less\\project\\views\\templates';
?><!doctype html>
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
                    <img src="../assets/<?php echo $_smarty_tpl->getValue('user')['avatar'];?>
" width="200" alt="User Avatar">
                </div>
                <div class="user-info">
                    <h2 style="margin: 10px 0;">
                        <a href="vendor/profilePage/userProfile.php?id=<?php echo $_smarty_tpl->getValue('user')['id'];?>
"><?php echo $_smarty_tpl->getValue('user')['login'];?>
</a>
                    </h2>
                    <a href="#"><?php echo $_smarty_tpl->getValue('user')['email'];?>
</a>
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
                        <p class="drop-area-p"></p>
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

    <?php echo '<script'; ?>
 src="../assets/js/jquery-3.4.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../assets/js/ajaxHelper.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../assets/js/profile/profile.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../assets/js/profile/profileAjax.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../assets/components/carCard.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
