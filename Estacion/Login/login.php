<?php
session_start(); // Inicia la sesión al principio

// Destruye cualquier sesión anterior
session_unset(); // Libera todas las variables de sesión
session_destroy(); // Destruye la sesión actual

// Inicia una nueva sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking";
$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Verifica el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE Correo = '$email' AND Contraseña = '$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email; // Guarda el correo en la sesión
        header("Location: /Estacion/Estacion/Index.html"); // Redirige al perfil
        exit;
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}

mysqli_close($con);
?>
