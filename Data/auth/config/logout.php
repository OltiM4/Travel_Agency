<?php
session_start();


$_SESSION = [];


session_destroy();


header('Location: ../../../Models/web-design/pages/login.php');
exit();
?>
