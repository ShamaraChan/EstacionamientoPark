<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $numero_telefono = $_POST['numero_telefono'];
    $miembro_desde = $_POST['miembro_desde'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $email = $_POST['email'];

    // Verificar que todos los campos estén completos
    if (empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || empty($numero_telefono) || empty($miembro_desde) || empty($password) || empty($confirm_password) || empty($email)) {
        echo "Todos los campos son obligatorios.";
    } else {
        // Verificar que las contraseñas coincidan
        if ($password !== $confirm_password) {
            echo "Las contraseñas no coinciden.";
        } else {
            // Verificar si el correo ya existe en la base de datos
            $email_check_query = "SELECT * FROM usuarios WHERE Correo = '$email' ";
            $result = $conn->query($email_check_query);

            if ($result->num_rows > 0) {
                echo "El correo electrónico ya está registrado.";
            } else {
                // Insertar en la base de datos
                $sql = "INSERT INTO usuarios (Correo, Contraseña, Nombre, Apellido, Fecha_Nacimiento, Numero_Telefono, Miembro_desde)
                        VALUES ('$email', '$password', '$nombre', '$apellido', '$fecha_nacimiento', '$numero_telefono', '$miembro_desde')";

                if ($conn->query($sql) === TRUE) {
                    // Registro exitoso, redirigir a login.html
                    header("Location: /Estacion/Estacion/Login/Login.html");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
}

$conn->close();
?>
