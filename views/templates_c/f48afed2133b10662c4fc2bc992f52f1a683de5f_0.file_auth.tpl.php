<?php
/* Smarty version 5.6.0, created on 2025-11-13 22:54:41
  from 'file:auth.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_691653a137e396_18625787',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f48afed2133b10662c4fc2bc992f52f1a683de5f' => 
    array (
      0 => 'auth.tpl',
      1 => 1763070753,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_691653a137e396_18625787 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\less\\project\\views\\templates';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo '<?'; ?>
= $type === 'register' ? 'Register' : 'Login' <?php echo '?>'; ?>
</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<?php if ($_smarty_tpl->getValue('type') == 'register') {?>
    <form id="auth-form" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" value="register">
        <label>Login:</label>
        <input type="text" name="login" placeholder="Enter your login">

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter your email">

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password">

        <label>Avatar (optional):</label>
        <input type="file" name="avatar" accept="image/*">

        <button type="submit" class="primary-btn register-btn">Register</button>
        <p class="auth-link">Already have an account? <a href="?page=login">Login</a></p>
    </form>
<?php } else { ?>
    <form id="auth-form" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" value="login">

        <label>Login:</label>
        <input type="text" name="login" placeholder="Enter your login">

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password">

        <button type="submit" class="primary-btn login-btn">Login</button>
        <p class="auth-link">Don't have an account? <a href="?page=register">Register</a></p>
    </form>
<?php }?>


<?php echo '<script'; ?>
 src="../assets/js/jquery-3.4.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../assets/js/ajaxHelper.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../assets/js/main.js"><?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
