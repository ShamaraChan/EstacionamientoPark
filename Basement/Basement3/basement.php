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
$sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 7";
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

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Sótano 3</h2>

        <div class="parking-container">
            <img src="B3.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <div class="spots-container">
                <?php
                // Generar los spots dinámicamente
                for ($i = 1; $i <= 29; $i++) {
                    $color = isset($cajones[$i]) ? ($cajones[$i] == 1 ? 'red' : 'green') : 'green'; // Color predeterminado verde para spots sin datos
                    echo "<div class='parking-spot' id='spot$i' data-spot='$i' style='background-color: $color;'>$i</div>";
                }
                ?>
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
<!-- Botones para controlar los spots -->
<div class="container mt-3">
        <button class="btn btn-primary mr-2" onclick="toggleAllSpots()">Cambiar Estado de Todos los Spots</button>
        <button class="btn btn-warning" onclick="disableSelectedSpots()">Deshabilitar Spots Seleccionados</button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const spots = document.querySelectorAll('.parking-spot');
            
            // Recuperar el estado almacenado
            spots.forEach(function(spot) {
                const spotId = spot.dataset.spot;
                const savedColor = localStorage.getItem('spot_' + spotId);
                if (savedColor) {
                    spot.style.backgroundColor = savedColor;
                }
            });

            // Manejar clics en los spots
            spots.forEach(function(spot) {
                spot.addEventListener('click', function() {
                    const spotId = spot.dataset.spot;
                    const currentColor = spot.style.backgroundColor;
                    if (currentColor === 'yellow') {
                        spot.style.backgroundColor = 'green'; // Cambia de amarillo a verde si se hace clic de nuevo
                        localStorage.removeItem('spot_' + spotId);
                    } else {
                        spot.style.backgroundColor = 'yellow'; // Cambia a amarillo si se hace clic
                        localStorage.setItem('spot_' + spotId, 'yellow');
                    }
                });
            });
        });
    </script>
    
</body>
</html>
