<?php


session_start();

require_once 'config/database.php';
require_once 'controllers/AuthController.php';
 
 
         header('Location: views/auth/login.php');
 
?>