<?php
// Incluir el archivo de sesión
include('session.php');

// Inicia la sesión antes de cualquier salida
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
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

// Consulta para obtener los cajones del nivel 3
$sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 3";
$result = $conn->query($sql);

// Verificar si se obtuvieron resultados
$spots = [];
if ($result->num_rows > 0) {
    // Guardar resultados en un array
    while ($row = $result->fetch_assoc()) {
        $spots[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $spotId = $_POST['spot_id'];
    $disponibilidad = $_POST['disponibilidad'];

    $sql = "UPDATE cajones SET disponibilidad = ? WHERE N_Cajon = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $disponibilidad, $spotId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conn->close();
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Niveles - Parking Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <style>
        .spot-enabled {
            border: 2px solid black;
            background-color: rgba(0, 128, 0, 0.5); /* Verde con 50% de opacidad */
        }
        .spot-disabled {
            border: 2px solid grey;
            background-color: rgba(255, 0, 0, 0.5); /* Rojo con 50% de opacidad */
        }
        .spot-yellow {
            border: 2px solid black;
            background-color: rgba(255, 255, 0, 0.5); /* Amarillo con 50% de opacidad */
        }
        .selected {
            border: 2px solid yellow;
        }
        .simbologia-item {
            margin-bottom: 10px;
        }
        .color-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 10px;
        }
        .red-box {
            background-color: rgba(255, 0, 0, 0.5); /* Rojo con 50% de opacidad */
        }
        .green-box {
            background-color: rgba(0, 128, 0, 0.5); /* Verde con 50% de opacidad */
        }
        .yellow-box {
            background-color: rgba(255, 255, 0, 0.5); /* Amarillo con 50% de opacidad */
        }
    </style>
</head>
<body>
    <header class="header d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="https://campestreags.com">
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
                    <a class="dropdown-item" href="/Estacion/camaras/niveles.php">Niveles</a>
                    <a class="dropdown-item" href="/Estacion/camaras/sotano.php">Sótanos</a>
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
                    src="https://cdn.lordicon.com/dxjqoygy.json"
                    trigger="hover"
                    colors="primary:#109173,secondary:#08a88a"
                    style="width:30px;height:30px">
                </lord-icon>
            </a>
        </div>
    </header>

    <!-- Contenedor principal -->
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Nivel 3</h2>

        <!-- Contenedor para la imagen y los spots -->
        <div class="parking-container">
            <img src="L3.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <!-- Spots para los lugares de estacionamiento -->
            <div class="spots-container">
                <?php foreach ($spots as $spot): ?>
                    <div class="parking-spot" id="spot<?php echo $spot['N_Cajon']; ?>"
                        style="background-color: <?php echo isset($_COOKIE['spot' . $spot['N_Cajon']]) ? $_COOKIE['spot' . $spot['N_Cajon']] : ($spot['disponibilidad'] == 0 ? 'rgba(0, 128, 0, 0.5)' : 'rgba(255, 0, 0, 0.5)'); ?>;"
                        data-original-color="<?php echo $spot['disponibilidad'] == 0 ? 'rgba(0, 128, 0, 0.5)' : 'rgba(255, 0, 0, 0.5)'; ?>"
                        data-available="<?php echo $spot['disponibilidad']; ?>">
                        <?php echo $spot['N_Cajon']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="background-container">
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

    <div class="container mt-3">
        <button class="btn btn-primary mr-2" onclick="toggleAllSpots()">Cambiar Estado de Todos los Spots</button>
        <button class="btn btn-secondary">Otro Botón</button>
    </div>

    <!-- Scripts de Bootstrap y otros -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lord-icon-element@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var spots = document.querySelectorAll('.parking-spot');

            spots.forEach(function(spot) {
                spot.addEventListener('click', function() {
                    var spotId = spot.id.replace('spot', '');
                    var greenColor = 'rgba(0, 128, 0, 0.5)'; // Verde
                    var yellowColor = 'rgba(255, 255, 0, 0.5)'; // Amarillo
                    var currentColor = spot.style.backgroundColor;
                    var newDisponibilidad = 0;

                    // Cambiar el color del spot
                    if (currentColor === yellowColor) {
                        spot.style.backgroundColor = greenColor;
                        document.cookie = "spot" + spotId + "=" + greenColor + "; path=/";
                        newDisponibilidad = 0; // Verde
                    } else if (currentColor === greenColor) {
                        spot.style.backgroundColor = yellowColor;
                        document.cookie = "spot" + spotId + "=" + yellowColor + "; path=/";
                        newDisponibilidad = 2; // Amarillo
                    }

                    // Enviar solicitud AJAX para actualizar el estado
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status !== 'success') {
                                console.error('Error al actualizar el estado del cajón.');
                            }
                        }
                    };
                    xhr.send('spot_id=' + spotId + '&disponibilidad=' + newDisponibilidad);
                });

                // Restaurar color original si es necesario
                var spotId = spot.id.replace('spot', '');
                var storedColor = getCookie('spot' + spotId);
                if (storedColor) {
                    spot.style.backgroundColor = storedColor;
                }
            });

            function getCookie(name) {
                var value = "; " + document.cookie;
                var parts = value.split("; " + name + "=");
                if (parts.length == 2) return parts.pop().split(";").shift();
            }

            function checkForNewData() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '?check_new_data=true', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        if (xhr.responseText === 'true') {
                            location.reload();
                        }
                    }
                };
                xhr.send();
            }

            setInterval(checkForNewData, 5000);
        });
    </script>
</body>
</html>
