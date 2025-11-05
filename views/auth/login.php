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

        <form>
            <label>Username</label>
            <input type="text" name="login" placeholder="Enter your username">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">
            <button type="submit" class="login-btn">Log In</button>
            <p>
                Don’t have an account? – <a href="register.php">Register</a>!
            </p>
            <p class="msg none">Lorem ipsum dolor sit amet.</p>
        </form>

        <script src="../../assets/js/jquery-3.4.1.min.js"></script>
        <script src="../../assets/js/main.js"></script>

    </body>
    </html>
