<?php
include('session.php');

// Configuración de la conexión a la base de datos
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

// Procesar solicitud POST para actualizar el estado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spot_id = $_POST['spot_id'];
    $status = $_POST['status'];
    
    // Actualizar el estado en la base de datos
    $update_sql = "UPDATE cajones SET disponibilidad = ? WHERE N_Cajon = ? AND N_Nivel = 8";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('ii', $status, $spot_id);
    $stmt->execute();
    $stmt->close();
    
    echo "Estado actualizado.";
    $conn->close();
    exit;
}

// Consulta para obtener los spots del nivel 8
$sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 8";
$result = $conn->query($sql);

$spots = [];
if ($result->num_rows > 0) {
    // Guardar los resultados en un array
    while($row = $result->fetch_assoc()) {
        $spots[$row['N_Cajon']] = $row['disponibilidad'];
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
    <style>
        .spot-yellow {
            background-color: yellow !important;
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
        <h2 class="text-center mb-4">Sótano 4</h2>

        <div class="parking-container">
            <img src="B4.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <div class="spots-container">
                <?php
                // Inicializa todos los spots con el color basado en la disponibilidad
                for ($i = 1; $i <= 26; $i++) {
                    $color = isset($spots[$i]) ? ($spots[$i] == 2 ? 'yellow' : ($spots[$i] == 1 ? 'red' : 'green')) : 'green'; // Color verde por defecto
                    echo "<div class='parking-spot' id='spot$i' style='background-color: $color;' onclick='toggleSpot($i)'>$i</div>";
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

    <div class="container mt-3">
        <button class="btn btn-primary mr-2" onclick="toggleAllSpots()">Cambiar Estado de Todos los Spots</button>
        <button class="btn btn-warning" onclick="disableSelectedSpots()">Deshabilitar Spots Seleccionados</button>
    </div>

    <script>
        function toggleSpot(spotId) {
            const spot = document.getElementById('spot' + spotId);
            const currentColor = spot.style.backgroundColor;
            let newColor;
            let status;

            if (currentColor === 'yellow') {
                newColor = 'green';
                status = 1; // Disponible
            } else {
                newColor = 'yellow';
                status = 2; // Deshabilitado
            }
            
            spot.style.backgroundColor = newColor;

            // Enviar solicitud POST al servidor para actualizar el estado
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // El mismo archivo PHP
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log(xhr.responseText); // Mensaje de respuesta del servidor
                }
            };
            xhr.send('spot_id=' + spotId + '&status=' + status);

            // Actualizar el estado en localStorage
            if (status === 2) {
                addToLocalStorage(spotId);
            } else {
                removeFromLocalStorage(spotId);
            }
        }

        function addToLocalStorage(spotId) {
            let selectedSpots = JSON.parse(localStorage.getItem('selected_spots')) || [];
            if (!selectedSpots.includes(spotId)) {
                selectedSpots.push(spotId);
                localStorage.setItem('selected_spots', JSON.stringify(selectedSpots));
            }
        }

        function removeFromLocalStorage(spotId) {
            let selectedSpots = JSON.parse(localStorage.getItem('selected_spots')) || [];
            selectedSpots = selectedSpots.filter(id => id !== spotId);
            localStorage.setItem('selected_spots', JSON.stringify(selectedSpots));
        }

        window.onload = function() {
            const selectedSpots = JSON.parse(localStorage.getItem('selected_spots')) || [];
            selectedSpots.forEach(spotId => {
                const spot = document.getElementById('spot' + spotId);
                if (spot) {
                    spot.style.backgroundColor = 'yellow';
                }
            });
        }
    </script>
    <footer class="bg-body-tertiary text-center">
        <!-- Contenido del pie de página -->
    </footer>
</body>
</html>
