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

    // Obtiene el sótano actual desde la URL o usa un valor predeterminado
    $current_basement = isset($_GET['basement']) ? intval($_GET['basement']) : 1;

    $sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Nivel = 2 AND N_Cajon BETWEEN 1 AND 29";
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

    if (!isset($_SESSION['selected_spots'][$current_basement])) {
        $_SESSION['selected_spots'][$current_basement] = array();
    }

    if (isset($_GET['toggle_spot'])) {
        $spotId = intval($_GET['toggle_spot']);
        if (in_array($spotId, $_SESSION['selected_spots'][$current_basement])) {
            $_SESSION['selected_spots'][$current_basement] = array_diff($_SESSION['selected_spots'][$current_basement], array($spotId));
            // Cambiar disponibilidad a 0 (verde)
            $update_sql = "UPDATE cajones SET disponibilidad = 0 WHERE N_Cajon = $spotId";
        } else {
            $_SESSION['selected_spots'][$current_basement][] = $spotId;
            // Cambiar disponibilidad a 2 (amarillo)
            $update_sql = "UPDATE cajones SET disponibilidad = 2 WHERE N_Cajon = $spotId";
        }
        $conn->query($update_sql);
        echo 'success';
        exit;
    }

    $conn->close();

    if (isset($_GET['check_new_data']) && $_GET['check_new_data'] == 'true') {
        echo $new_data ? 'true' : 'false';
        exit;
    }
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
            background-color: rgba(0, 255, 0, 0.5); /* Verde con opacidad */
        }
        .spot-disabled {
            border: 2px solid grey;
            background-color: rgba(255, 0, 0, 0.5); /* Rojo con opacidad */
        }
        .spot-yellow {
            border: 2px solid yellow;
            background-color: rgba(255, 255, 0, 0.5); /* Amarillo con opacidad */
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
            background-color: red;
        }
        .green-box {
            background-color: green;
        }
        .yellow-box {
            background-color: yellow;
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
                    <a class="dropdown-item" href="/Estacion/Basement/Basement1/basement.php?basement=1">Sótano 1</a>
                    <a class="dropdown-item" href="/Estacion/Basement/Basement2/basement.php?basement=2">Sótano 2</a>
                    <a class="dropdown-item" href="/Estacion/Basement/Basement3/basement.php?basement=3">Sótano 3</a>
                    <a class="dropdown-item" href="/Estacion/Basement/Basement4/basement.php?basement=4">Sótano 4</a>
                </div>
            </div>
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="camerasDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cámaras
                    <i class="bi bi-camera"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="camerasDropdown">
                    <a class="dropdown-item" href="/Cameras/niveles.php">Niveles</a>
                    <a class="dropdown-item" href="/Cameras/sotano.php">Sótanos</a>
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
        <h2 class="text-center mb-4">Nivel 2</h2>

        <div class="parking-container">
            <img src="L2.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <div class="spots-container">
                <?php
                    // Imprimir los cajones
                    foreach ($disponibilidades as $n_cajon => $disponibilidad) {
                        $color = $disponibilidad == 0 ? 'spot-enabled' : 'spot-disabled';
                        $selectedClass = isset($_SESSION['selected_spots'][$current_basement]) && in_array($n_cajon, $_SESSION['selected_spots'][$current_basement]) ? 'spot-yellow' : '';
                        echo "<div class='parking-spot $color $selectedClass' id='spot$n_cajon' onclick='toggleSpot($n_cajon)'>$n_cajon</div>";
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
        <button class="btn btn-secondary">Otro Botón</button>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.lordicon.com/pzdvqjqy.js"></script>
    <script>
        const basement = <?php echo $current_basement; ?>;

        function toggleSpot(spotId) {
            const spotElement = document.getElementById(`spot${spotId}`);
            if (spotElement.classList.contains('spot-yellow')) {
                spotElement.classList.remove('spot-yellow');
                spotElement.classList.add('spot-enabled');
            } else if (spotElement.classList.contains('spot-enabled')) {
                spotElement.classList.remove('spot-enabled');
                spotElement.classList.add('spot-yellow');
            } else {
                spotElement.classList.remove('spot-disabled');
                spotElement.classList.add('spot-yellow');
            }
            updateSpotStatus(spotId);
        }

        function updateSpotStatus(spotId) {
            fetch(`?toggle_spot=${spotId}&basement=${basement}`)
                .then(response => response.text())
                .then(data => {
                    console.log('Estado del cajón actualizado:', data);
                })
                .catch(error => {
                    console.error('Error al actualizar el estado del cajón:', error);
                });
        }

        function checkForNewData() {
            fetch('?check_new_data=true')
                .then(response => response.text())
                .then(data => {
                    if (data === 'true') {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error al verificar nuevos datos:', error);
                });
        }

        setInterval(checkForNewData, 60000); // Comprobar cada minuto
    </script>
</body>
</html>
