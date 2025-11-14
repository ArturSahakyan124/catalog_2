<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $type === 'register' ? 'Register' : 'Login' ?></title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

{if $type == 'register'}
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

        <button type="submit" class="register-btn">Register</button>
        <p class="auth-link">Already have an account? <a href="?page=login">Login</a></p>
    </form>
{else}
    <form id="auth-form" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" value="login">

        <label>Login:</label>
        <input type="text" name="login" placeholder="Enter your login">

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password">

        <button type="submit" class=" btn-primary login-btn">Login</button>
        <p class="auth-link">Don't have an account? <a href="?page=register">Register</a></p>
    </form>
{/if}


<script src="../assets/js/jquery-3.4.1.min.js"></script>
<script src="../assets/js/ajaxHelper.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>
