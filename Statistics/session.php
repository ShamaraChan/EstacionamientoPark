<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: /Estacion/Estacion/Login/Login.php');
    exit();
}
?>