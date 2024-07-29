<?php
session_start();
session_unset();
session_destroy();
header("Location: /Estacion/Login/Login.html");
exit;
?>