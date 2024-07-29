<?php
session_start();
session_unset();
session_destroy();
header("Location: /Estacion/Estacion/Login/Login.html");
exit;
?>