<?php


session_start();

require_once 'config/database.php';
require_once 'controllers/AuthController.php';
 
    if (!empty($_SESSION['user'])) {
        header('Location: views/profile/userPage.php');
    }
    else{
         header('Location: views/auth/login.php');
 
?>