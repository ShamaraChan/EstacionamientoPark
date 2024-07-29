<?php
include('session.php');

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

// Procesar solicitudes AJAX para actualizar el color de los spots
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spotId = $_POST['id'] ?? '';
    $color = $_POST['color'] ?? '';

    if ($spotId && $color) {
        $disponibilidad = $color === 'rgba(255, 255, 0, 0.5)' ? 2 : ($color === 'rgba(0, 128, 0, 0.5)' ? 0 : 1);
        $spotNumber = str_replace('spot', '', $spotId);

        $updateSql = "UPDATE cajones SET disponibilidad = ? WHERE N_Cajon = ? AND N_Nivel = 4";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $disponibilidad, $spotNumber);
        $stmt->execute();
        $stmt->close();
    }
}

// Consultar los cajones del nivel 4
$sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 4 AND N_Cajon BETWEEN 1 AND 22";
$result = $conn->query($sql);

// Verificar si se obtuvieron resultados
$spots = [];
if ($result->num_rows > 0) {
    // Guardar resultados en un array
    while ($row = $result->fetch_assoc()) {
        $spots[] = $row;
    }
} else {
    // Si no hay resultados, agregar un mensaje para depuración
    $spots[] = ['N_Cajon' => 'No Data', 'disponibilidad' => '0'];
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
            background-color: rgba(0, 128, 0, 0.5); /* Verde con 50% de opacidad */
        }
        .spot-disabled {
            background-color: rgba(255, 0, 0, 0.5); /* Rojo con 50% de opacidad */
        }
        .spot-yellow {
            background-color: rgba(255, 255, 0, 0.5); /* Amarillo con 50% de opacidad */
        }
        .spot-green {
            background-color: rgba(0, 128, 0, 0.5); /* Verde con 50% de opacidad */
        }
        .no-data-message {
            text-align: center;
            color: grey;
            font-weight: bold;
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
        <h2 class="text-center mb-4">Nivel 4</h2>

        <!-- Contenedor para la imagen y los spots -->
        <div class="parking-container">
            <img src="L4.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <!-- Spots para los lugares de estacionamiento -->
            <div class="spots-container" id="spots-container">
                <?php foreach ($spots as $spot): ?>
                    <?php if ($spot['N_Cajon'] !== 'No Data'): ?>
                        <div class="parking-spot spot" id="spot<?php echo $spot['N_Cajon']; ?>"
                            style="background-color: <?php
                                $spotId = 'spot' . $spot['N_Cajon'];
                                $color = 'rgba(255, 255, 255, 0.5)'; // Color predeterminado

                                if (isset($_COOKIE[$spotId])) {
                                    $cookieColor = $_COOKIE[$spotId];
                                    if ($cookieColor === 'rgba(255, 255, 0, 0.5)') {
                                        $color = 'rgba(255, 255, 0, 0.5)';
                                    } elseif ($cookieColor === 'rgba(0, 128, 0, 0.5)') {
                                        $color = 'rgba(0, 128, 0, 0.5)';
                                    } elseif ($cookieColor === 'rgba(255, 0, 0, 0.5)') {
                                        $color = 'rgba(255, 0, 0, 0.5)';
                                    }
                                } else {
                                    $color = $spot['disponibilidad'] == 0 ? 'rgba(0, 128, 0, 0.5)' : ($spot['disponibilidad'] == 1 ? 'rgba(255, 0, 0, 0.5)' : 'rgba(255, 255, 0, 0.5)');
                                }
                                echo $color;
                            ?>;"
                            class="<?php
                                if ($spot['disponibilidad'] == 0) {
                                    echo 'spot-green';
                                } elseif ($spot['disponibilidad'] == 1) {
                                    echo 'spot-disabled';
                                } else {
                                    echo 'spot-yellow';
                                }
                            ?>">
                            <?php echo $spot['N_Cajon']; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-data-message">No hay datos disponibles para mostrar</div>
                    <?php endif; ?>
                <?php endforeach; ?>
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

    <!-- Scripts necesarios para Bootstrap y JavaScript personalizado -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script personalizado para controlar los spots -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const spots = document.querySelectorAll('.parking-spot');

            spots.forEach(spot => {
                spot.addEventListener('click', function() {
                    const spotId = this.id;
                    const currentColor = this.style.backgroundColor;

                    let newColor;
                    if (currentColor === 'rgba(255, 255, 0, 0.5)') {
                        newColor = 'rgba(0, 128, 0, 0.5)'; // Verde
                    } else {
                        newColor = 'rgba(255, 255, 0, 0.5)'; // Amarillo
                    }

                    // Cambia el color del spot y guarda en cookies
                    this.style.backgroundColor = newColor;
                    document.cookie = `${spotId}=${newColor};path=/`;

                    // Actualiza la base de datos
                    fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${spotId}&color=${newColor}`
                    });
                });
            });

            // Actualizar los colores de los spots cada 5 segundos
            function updateSpotColors() {
                fetch('')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(spot => {
                            const spotElement = document.getElementById(`spot${spot.N_Cajon}`);
                            if (spotElement) {
                                let color;
                                if (spot.disponibilidad == 0) {
                                    color = 'rgba(0, 128, 0, 0.5)'; // Verde
                                } else if (spot.disponibilidad == 1) {
                                    color = 'rgba(255, 0, 0, 0.5)'; // Rojo
                                } else {
                                    color = 'rgba(255, 255, 0, 0.5)'; // Amarillo
                                }

                                // Si el color en la base de datos es diferente del color guardado en la cookie
                                if (document.cookie.includes(`spot${spot.N_Cajon}=`)) {
                                    const cookieColor = document.cookie.split(`spot${spot.N_Cajon}=`)[1].split(';')[0];
                                    if (cookieColor !== color) {
                                        color = cookieColor;
                                    }
                                }

                                spotElement.style.backgroundColor = color;
                            }
                        });
                    });
            }

            setInterval(updateSpotColors, 5000); // Actualiza cada 5 segundos
        });

        function toggleAllSpots() {
            const spots = document.querySelectorAll('.parking-spot');
            spots.forEach(spot => {
                spot.click();
            });
        }
    </script>
</body>
</html>
