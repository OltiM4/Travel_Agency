<?php
session_start();


$_SESSION = [];


session_destroy();


header('Location: ../../Presentation.Layer/UserInterface/pages/login.php');
exit();
?>
