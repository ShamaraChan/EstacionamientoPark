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

// Actualizar el estado del spot si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spotId = intval($_POST['spotId']);
    $newStatus = intval($_POST['newStatus']);

    // Actualizar la base de datos
    $sql = "UPDATE cajones SET disponibilidad = ? WHERE N_Cajon = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newStatus, $spotId);

    if ($stmt->execute()) {
        echo "Estado actualizado correctamente.";
    } else {
        echo "Error actualizando el estado: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit(); // Termina el script después de procesar la solicitud POST
}

// Consulta a la base de datos
$sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 5";
$result = $conn->query($sql);

$cajones = array();
if ($result->num_rows > 0) {
    // Recorrer resultados
    while($row = $result->fetch_assoc()) {
        $cajones[$row["N_Cajon"]] = $row["disponibilidad"];
    }
} else {
    echo "0 resultados";
}
$conn->close();
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
    <style>
        .spot-red {
            background-color: rgba(255, 0, 0, 0.5) !important; /* Rojo con 50% de opacidad */
        }
        .spot-green {
            background-color: rgba(0, 255, 0, 0.5) !important; /* Verde con 50% de opacidad */
        }
        .spot-yellow {
            background-color: rgba(255, 255, 0, 0.5) !important; /* Amarillo con 50% de opacidad */
        }
    </style>
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
    <h2 class="text-center mb-4">Sótano 1</h2>

    <!-- Contenedor para la imagen y los spots -->
    <div class="parking-container">
        <img src="B1.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

        <!-- Spots para los lugares de estacionamiento -->
        <div class="spots-container">
            <?php
            // Generar los spots dinámicamente
            for ($i = 1; $i <= 24; $i++) {
                $colorClass = isset($cajones[$i]) ? 
                    ($cajones[$i] == 2 ? 'spot-yellow' : 
                    ($cajones[$i] == 1 ? 'spot-red' : 'spot-green')) : 'spot-green';
                echo "<div class='parking-spot $colorClass' id='spot$i'>$i</div>";
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
                    <div class="color-box red-box" style="background-color: rgba(255, 0, 0, 0.5);"></div>
                    <i class="fas fa-times-circle red-icon ml-2" style="color: rgba(255, 0, 0, 0.5);"></i>
                    <span class="ml-2" style="color: rgba(255, 0, 0, 0.5); font-weight: bold;">Ocupado</span>
                </div>
                <div class="simbologia-item d-flex align-items-center">
                    <div class="color-box green-box" style="background-color: rgba(0, 255, 0, 0.5);"></div>
                    <i class="fas fa-check-circle green-icon ml-2" style="color: rgba(0, 255, 0, 0.5);"></i>
                    <span class="ml-2" style="color: rgba(0, 255, 0, 0.5); font-weight: bold;">Disponible</span>
                </div>
                <div class="simbologia-item d-flex align-items-center">
                    <div class="color-box yellow-box" style="background-color: rgba(255, 255, 0, 0.5);"></div>
                    <i class="fas fa-ban yellow-icon ml-2" style="color: rgba(255, 255, 0, 0.5);"></i>
                    <span class="ml-2" style="color: rgba(255, 255, 0, 0.5); font-weight: bold;">Inhabilitado</span>
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
    // Define el ID del sótano (para Sótano 1, usa 1; ajusta según corresponda para otros sótanos)
    const basementId = 1;

    // Selecciona todos los spots
    var spots = document.querySelectorAll('.parking-spot');

    // Cargar estados desde localStorage
    document.addEventListener('DOMContentLoaded', function() {
        spots.forEach(function(spot) {
            var spotId = spot.id;
            if (localStorage.getItem(basementId + '-' + spotId) === 'spot-yellow') {
                spot.classList.add('spot-yellow');
            }
        });
    });

    // Añade un listener de clic para cada spot
    spots.forEach(function(spot) {
        spot.addEventListener('click', function() {
            var spotId = spot.id.replace('spot', '');
            var currentClass = spot.classList.contains('spot-yellow') ? 'spot-yellow' : 
                               (spot.classList.contains('spot-red') ? 'spot-red' : 'spot-green');

            // Determina el nuevo estado y clase
            var newClass = currentClass === 'spot-yellow' ? 'spot-green' : 'spot-yellow';
            var newStatus = newClass === 'spot-yellow' ? 2 : 0;

            // Actualiza el color del spot localmente
            spot.classList.remove(currentClass);
            spot.classList.add(newClass);

            // Guarda el estado en localStorage
            if (newClass === 'spot-yellow') {
                localStorage.setItem(basementId + '-' + spot.id, 'spot-yellow');
            } else {
                localStorage.removeItem(basementId + '-' + spot.id);
            }

            // Enviar una solicitud AJAX para actualizar el estado en la base de datos
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Enviar la solicitud a este mismo archivo
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send('spotId=' + encodeURIComponent(spotId) + '&newStatus=' + encodeURIComponent(newStatus));
        });
    });

    // Función para cambiar el estado de todos los spots (sin cambios)
    function toggleAllSpots() {
        spots.forEach(function(spot) {
            spot.classList.toggle('spot-enabled');
        });
    }

    // Función para deshabilitar los spots seleccionados (sin cambios)
    function disableSelectedSpots() {
        spots.forEach(function(spot) {
            if (spot.classList.contains('spot-enabled')) {
                spot.classList.remove('spot-green');
                spot.classList.add('spot-yellow');
            }
        });
    }
</script>
</body>
</html>
