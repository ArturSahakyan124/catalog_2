<?php
/* Smarty version 5.6.0, created on 2025-11-13 19:30:27
  from 'file:views/templates/auth.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_691623c3091f72_23847503',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '56cc79f2204bdb24c70df815907fd0685c82ecd6' => 
    array (
      0 => 'views/templates/auth.tpl',
      1 => 1763058299,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_691623c3091f72_23847503 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\less\\project\\views\\templates';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo '<?'; ?>
= $type === 'register' ? 'Register' : 'Login' <?php echo '?>'; ?>
</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>
<body>

<div class="auth-container">
    <h2><?php echo '<?'; ?>
= $type === 'register' ? 'Registration' : 'Authorization' <?php echo '?>'; ?>
</h2>

    <form id="auth-form" enctype="multipart/form-data" method="POST">
        <?php echo '<?php'; ?>
 if ($type === 'register'): <?php echo '?>'; ?>

            <input type="hidden" name="action" value="register">

            <label>Login:</label>
            <input type="text" name="login" placeholder="Enter your login">

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter your email">

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password">

            <label>Avatar (optional):</label>
            <input type="file" name="avatar" accept="image/*">

            <button type="submit" class="register-btn">Register</button>
            <p class="auth-link">Already have an account? <a href="?page=login">Login</a></p>

        <?php echo '<?php'; ?>
 else: <?php echo '?>'; ?>

            <input type="hidden" name="action" value="login">

            <label>Login:</label>
            <input type="text" name="login" placeholder="Enter your login">

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password">

            <button type="submit" class="login-btn">Login</button>
            <p class="auth-link">Don't have an account? <a href="?page=register">Register</a></p>
        <?php echo '<?php'; ?>
 endif; <?php echo '?>'; ?>

    </form>

    <div class="msg none"></div>
</div>

<?php echo '<script'; ?>
 src="../../assets/js/jquery-3.4.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../../assets/js/ajaxHelper.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../../assets/js/main.js"><?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
