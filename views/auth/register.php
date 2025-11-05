<?php
    session_start();
    if (!empty($_SESSION['user'])) {
        header('Location: ../profile/userPage.php');
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authorization and Registration</title>
        <link rel="stylesheet" href="../../assets/css/auth.css">
        <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>

    <!-- Registration form -->

    <form>
 
        <label>Username</label>
        <input type="text" name="login" placeholder="Enter your username">
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email address">
        <label>Profile Picture</label>
        <input type="file" name="avatar">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password">
        <button type="submit" class="register-btn">Register</button>
        <p>
            Already have an account? - <a href="login.php">Log in</a>!
        </p>
        <p class="msg none">Lorem ipsum.</p>
    </form>
    <script src="../../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>
