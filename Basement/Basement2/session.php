<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: /Estacion/Login/Login.html');
    exit();
}
?>