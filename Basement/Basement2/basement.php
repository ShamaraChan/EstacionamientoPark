<?php
include('session.php');

// Datos de conexión a la base de datos
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

// Consulta a la base de datos
$sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 6";
$result = $conn->query($sql);

$cajones = array();
if ($result->num_rows > 0) {
    // Recorrer resultados
    while ($row = $result->fetch_assoc()) {
        $cajones[$row["N_Cajon"]] = $row["disponibilidad"];
    }
} else {
    echo "0 resultados";
}
$conn->close();

// Procesar solicitud AJAX para actualizar el estado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = intval($_POST['status']);

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar la base de datos
    $sql = "UPDATE cajones SET disponibilidad = ? WHERE N_Cajon = ? AND N_Nivel = 6";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo "Estado actualizado correctamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit; // Salir del script después de procesar la solicitud AJAX
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Sótanos - Parking Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>
<body>
<header class="header d-flex justify-content-between align-items-center">
    <div class="logo">
        <a href="/Estacion/Index.php">
            <img src="logo.png" height="50px" style="margin-right: 10px;">
        </a>
    </div>
    <nav class="ml-auto">
        <!-- Botones del menú de navegación -->
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
        <a href="/Estacion/Statistics/statistics.php" class="mr-3">
            Estadísticas
            <i class="bi bi-bar-chart-line"></i>
        </a>
    </nav>
    <div class="user-icon">
        <a href="/Estacion/Profile/profile.php">
            <lord-icon
                src="https://cdn.lordicon.com/bgebyztw.json"
                trigger="hover"
                colors="primary:#109173,secondary:#08a88a"
                style="width:30px;height:30px">
            </lord-icon>
        </a>
    </div>
</header>


<!-- Contenedor principal -->
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Sótano 2</h2>
    <div class="parking-container">
        <img src="B2.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">
        <div class="spots-container">
            <?php
            // Generar los spots dinámicamente
            for ($i = 1; $i <= 24; $i++) {
                // Obtener el estado del cajón, usando 0 (disponible) si no está en el array
                $status = $cajones[$i] ?? 0; // 0 si no existe
                $color = ($status == 1) ? 'red' : (($status == 2) ? 'yellow' : 'green');
                echo "<div class='parking-spot' id='spot$i' data-status='$status' style='background-color: $color;'>$i</div>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Contenedor de fondo blanco -->
<div class="background-container">
    <!-- Contenedor de simbología -->
    <div class="simbologia-container text-center mt-5">
        <h2>Simbología</h2>
        <div class="d-flex justify-content-center">
            <div class="simbologia">
                <div class="simbologia-item d-flex align-items-center">
                    <div class="color-box red-box"></div>
                    <i class="fas fa-times-circle red-icon ml-2"></i>
                    <span class="ml-2" style="color: red; font-weight: bold;">Ocupado</span>
                </div>
                <div class="simbologia-item d-flex align-items-center">
                    <div class="color-box green-box"></div>
                    <i class="fas fa-check-circle green-icon ml-2"></i>
                    <span class="ml-2" style="color: green; font-weight: bold;">Disponible</span>
                </div>
                <div class="simbologia-item d-flex align-items-center">
                    <div class="color-box yellow-box"></div>
                    <i class="fas fa-ban yellow-icon ml-2"></i>
                    <span class="ml-2" style="color: yellow; font-weight: bold;">Inhabilitado</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botones para controlar los spots -->
<div class="container mt-3">
    <button class="btn btn-primary mr-2" onclick="toggleAllSpots()">Cambiar Estado de Todos los Spots</button>
    <button class="btn btn-warning" onclick="disableSelectedSpots()">Deshabilitar Spots Seleccionados</button>
</div>

<!-- Scripts necesarios para Bootstrap y JavaScript personalizado -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script personalizado para controlar los spots -->
<script>
    // Selecciona todos los spots
    var spots = document.querySelectorAll('.parking-spot');

    // Añade un listener de clic para cada spot
    spots.forEach(function(spot) {
        spot.addEventListener('click', function() {
            var spotId = spot.id;
            var status = spot.dataset.status;
            var newStatus;
            var newColor;

            if (status === '0') {
                newStatus = 2; // Cambia a inhabilitado
                newColor = 'yellow';
            } else {
                newStatus = 0; // Cambia a disponible
                newColor = 'green';
            }

            spot.style.backgroundColor = newColor;
            spot.dataset.status = newStatus;

            // Envía la solicitud AJAX para actualizar el estado en la base de datos
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Enviar la solicitud al mismo archivo
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + spotId.replace('spot', '') + '&status=' + newStatus);
        });
    });

    // Función para cambiar el estado de todos los spots
    function toggleAllSpots() {
        spots.forEach(function(spot) {
            spot.classList.toggle('spot-enabled');
        });
    }

    // Función para deshabilitar los spots seleccionados
    function disableSelectedSpots() {
        spots.forEach(function(spot) {
            if (spot.classList.contains('spot-enabled')) {
                spot.style.backgroundColor = 'yellow';  // Cambiar el color de fondo a amarillo
                spot.dataset.status = '2';
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true); // Enviar la solicitud al mismo archivo
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + spot.id.replace('spot', '') + '&status=2');
            }
        });
    }
</script>
</body>
</html>
