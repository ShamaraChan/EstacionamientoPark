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

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Actualizar la disponibilidad del cajón en la base de datos
    if (isset($_GET['toggle_spot'])) {
        $spotId = $_GET['toggle_spot'];
        $currentDisponibilidad = $_GET['current_disponibilidad'];

        $newDisponibilidad = $currentDisponibilidad == 0 ? 2 : 0;

        $updateSql = "UPDATE cajones SET disponibilidad = $newDisponibilidad WHERE N_Cajon = $spotId";
        if ($conn->query($updateSql) === TRUE) {
            echo 'success';
        } else {
            echo 'error';
        }
        exit;
    }

    $sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 1 AND N_Cajon BETWEEN 1 AND 17";
    $result = $conn->query($sql);

    $disponibilidades = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $n_cajon = $row["N_Cajon"];
            $disponibilidad = $row["disponibilidad"];
            $disponibilidades[$n_cajon] = $disponibilidad;
        }
    } else {
        echo "0 results";
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <style>
        .spot-enabled {
            border: 2px solid black;
        }
        .spot-disabled {
            border: 2px solid grey;
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
            background-color: rgba(0, 255, 0, 0.5); /* Verde con 50% de opacidad */
        }
        .yellow-box {
            background-color: rgba(255, 255, 0, 0.5); /* Amarillo con 50% de opacidad */
        }
        .parking-image {
            width: 100%;
            height: auto;
        }
        .spots-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
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
                    src="https://cdn.lordicon.com/dxjqoygy.json"
                    trigger="hover"
                    colors="primary:#109173,secondary:#08a88a"
                    style="width:30px;height:30px">
                </lord-icon>
            </a>
        </div>
    </header>

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Nivel 1</h2>

        <div class="parking-container">
            <img src="L1.jpeg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <div class="spots-container">
                <?php
                    // Imprimir los cajones
                    foreach ($disponibilidades as $n_cajon => $disponibilidad) {
                        $color = $disponibilidad == 0 ? 'rgba(0, 255, 0, 0.5)' : ($disponibilidad == 2 ? 'rgba(255, 255, 0, 0.5)' : 'rgba(255, 0, 0, 0.5)');
                        echo "<div class='parking-spot spot-enabled' id='spot$n_cajon' style='background-color: $color;' onclick='toggleSpot($n_cajon, $disponibilidad)'>$n_cajon</div>";
                    }
                ?>
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

    <script>
        function toggleSpot(spotId, currentDisponibilidad) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'level.php?toggle_spot=' + spotId + '&current_disponibilidad=' + currentDisponibilidad, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == 'success') {
                        location.reload();
                    } else {
                        alert('Error al cambiar la disponibilidad del cajón');
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
