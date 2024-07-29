<?php
include('session.php');



// Verifica si el correo electrónico está almacenado en la sesión
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    echo "Error: Sesión no iniciada o correo electrónico no disponible.";
    exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking";
$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consultar datos del usuario
$query = "SELECT * FROM usuarios WHERE Correo = '$email'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $perfil = mysqli_fetch_assoc($result);
} else {
    echo "Error: No se encontró el perfil del usuario.";
    exit;
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>
<body>
<header class="header d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="/Estacion/Index.php">
                <img src="logo.png" height="50px" margin-right="10px">
            </a>
        </div>
        <nav class="ml-auto">
            <!-- Botón Dashboards -->
            <a href="/Estacion/Index.php" class="mr-3">
                Inicio
                <i class="bi bi-speedometer2"></i>
            </a>
            
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="levelsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Niveles
                    <i class="bi bi-layers"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="levelsDropdown">
                    <a class="dropdown-item" href="/Estacion/Level/Level1/level.php">Nivel 1</a>
                    <a class="dropdown-item" href="/Estacion/Level/Level2/level.php">Nivel 2</a>
                    <a class="dropdown-item" href="/Estacion/Level/Level3/level.php">Nivel 3</a>
                    <a class="dropdown-item" href="/Estacion/Level/Level4/level.php">Nivel 4</a>
                </div>
            </div>
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="basementsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sótanos
                    <i class="bi bi-building"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="basementsDropdown">
                    <a class="dropdown-item" href="/Estacion/Basement/Basement1/basement.php">Sótano 1</a>
                    <a class="dropdown-item" href="/Estacion/Basement/Basement2/basement.php">Sótano 2</a>
                    <a class="dropdown-item" href="/Estacion/Basement/Basement3/basement.php">Sótano 3</a>
                    <a class="dropdown-item" href="/Estacion/Basement/Basement4/basement.php">Sótano 4</a>
                </div>
            </div>
            
            <!-- Botón Cámaras -->
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="camerasDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cámaras
                    <i class="bi bi-camera"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="camerasDropdown">
                    <a class="dropdown-item" href="/Estacion/Cameras/niveles.php">Niveles</a>
                    <a class="dropdown-item" href="/Estacion/Cameras/sotano.php">Sótanos</a>
                </div>
            </div>

            <a href="/Estacion/Statistics/statistics.php" class="mr-3">Estadísticas
                <i class="bi bi-bar-chart-line"></i>
            </a>

            <div class="user-icon">
                <a href="/Estacion/Profile/profile.php">
                    <lord-icon
                    src="https://cdn.lordicon.com/bgebyztw.json"
                    trigger="hover"
                    colors="primary:#109173,secondary:#08a88a"
                    style="width:35px;height:35px">
                    </lord-icon>
                </a>
            </div>
        </nav>
    </header>


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <lord-icon
                src="https://cdn.lordicon.com/dxjqoygy.json"
                trigger="hover"
                colors="primary:#109173,secondary:#08a88a"
                style="width:100px;height:100px;cursor:pointer"
                data-toggle="modal" data-target="#profilePhotoModal">
                </lord-icon>
                <h2><?php echo $perfil['Nombre'] . ' ' . $perfil['Apellido']; ?></h2>
                <a href="#">Ver el perfil</a>
                <div class="list-group mt-3">
                    <a href="#" class="list-group-item list-group-item-action active">Cuenta <i class="fas fa-user"></i></a>
                    <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#privacyModal">Privacidad <i class="fas fa-shield-alt"></i></a>
                    <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#changeAccountModal">Cambiar cuenta <i class="fas fa-exchange-alt"></i></a>
                    <a href="#" class="list-group-item list-group-item-action btn-red" data-toggle="modal" data-target="#logoutModal">Cerrar sesión <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Información Personal <i class="fas fa-info-circle"></i></h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nombre:</strong> <?php echo $perfil['Nombre']; ?> <i class="fas fa-id-card"></i></li>
                            <li class="list-group-item"><strong>Apellidos:</strong> <?php echo $perfil['Apellido']; ?> <i class="fas fa-id-card-alt"></i></li>
                            <li class="list-group-item"><strong>Email:</strong> <?php echo $perfil['Correo']; ?> <i class="fas fa-at"></i></li>
                            <li class="list-group-item"><strong>Teléfono:</strong> <?php echo $perfil['Numero_Telefono']; ?> <i class="fas fa-phone"></i></li>
                            <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> <?php echo $perfil['Fecha_Nacimiento']; ?> <i class="fas fa-birthday-cake"></i></li>
                            <li class="list-group-item"><strong>Miembro Desde:</strong> <?php echo $perfil['Miembro_desde']; ?> <i class="fas fa-calendar-alt"></i></li>
                        </ul>
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#updateProfileModal">Actualizar Perfil <i class="fas fa-edit"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modales -->
    <!-- Modal Seleccionar Foto de Perfil -->
    <div class="modal fade" id="profilePhotoModal" tabindex="-1" aria-labelledby="profilePhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilePhotoModalLabel">Seleccionar Foto de Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" class="form-control-file" id="profilePhotoInput">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal Privacidad -->
   <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Privacidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Aquí puedes ajustar tus configuraciones de privacidad.</p>
                    <form>
                        <div class="form-group">
                            <label for="password">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirmPassword">
                        </div>
                        <button type="button" class="btn btn-danger mt-3" id="deleteAccountButton">Borrar Cuenta <i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar <i class="fas fa-times"></i></button>
                    <button type="button" class="btn btn-primary">Guardar <i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('deleteAccountButton').addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas borrar la cuenta?')) {
                // Aquí puedes agregar la lógica para borrar la cuenta.
                alert('Cuenta borrada');
            } else {
                // Lógica para cancelar la eliminación de la cuenta.
                alert('Eliminación de cuenta cancelada');
            }
        });
    </script>

    <!-- Modal Cambiar Cuenta -->
    <div class="modal fade" id="changeAccountModal" tabindex="-1" aria-labelledby="changeAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeAccountModalLabel">Cambiar Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del modal de cambiar cuenta -->
                    Aquí puedes cambiar a otra cuenta.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Cambiar</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal Cerrar Sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Cerrar Sesión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres cerrar sesión?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmLogout">Cerrar sesión</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmLogout').addEventListener('click', function() {
        window.location.href = '/Estacion/Estacion/Login/logout.php';
    });
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
