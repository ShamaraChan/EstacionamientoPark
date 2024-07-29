<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de nivel 1</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <style>
        .parking-container {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            border: 2px solid #000;
            background-color: #f8f9fa;
            overflow: hidden;
        }
    
        .parking-image {
            display: block;
            width: 100%;
            height: auto;
        }
    
        .parking-spot {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 45px 33px;
            border-radius: 5px;
            cursor: pointer;
            transform: translate(-50%, -50%);
            color: #a09c9c;
            pointer-events: auto;
            text-align: center;
            font-weight: bold;
        }
    
        /* Estilos para estados de los spots */
        .spot-enabled {
            background-color: #28a745; /* Verde */
            color: white;
        }
    
        .spot-disabled {
            background-color: #dc3545; /* Rojo */
            color: white;
        }
    
        .spot-selected {
            border: 2px solid #000; /* Resalta el cajón seleccionado */
        }
    
        /* Ajustes para posiciones específicas */
        #spot47 { top: 20%; left: 17.3%; }
        #spot48 { top: 20%; left: 25.4%; }
        #spot49 { top: 20%; left: 33.5%; }
        #spot50 { top: 20%; left: 41.5%; }
        #spot51 { top: 20%; left: 49.7%; }
        #spot52 { top: 20%; left: 57.8%; }
        #spot53 { top: 20%; left: 65.9%; }
        #spot54 { top: 20%; left: 73.95%; }
        #spot55 { top: 20%; left: 81.9%; padding: 45px 32px; }
        #spot56 { top: 83%; left: 11.5%; padding: 47px 30px; }
        #spot57 { top: 83%; left: 19.7%; padding: 47px 29px }
        #spot58 { top: 83%; left: 27.89%; padding: 47px 29px; }
        #spot59 { top: 83%; left: 36.1%; padding: 47px 29px; }
        #spot60 { top: 83%; left: 44.3%; padding: 47px 29px; }
        #spot61 { top: 83%; left: 52.5%; padding: 47px 29px; }
        #spot62 { top: 83%; left: 60.8%; padding: 47px 29px; }
        #spot63 { top: 83%; left: 69.1%; padding: 47px 29px; }
        #spot64 { top: 83%; left: 77.2%; padding: 47px 29px; }
        #spot65 { top: 83%; left: 85.5%; padding: 47px 30px; }
        #spot66 { top: 83%; left: 93.9%; padding: 47px 29px; }
    
        /* Media queries para ajustes de tamaño de pantalla */
        @media (max-width: 768px) {
            .parking-spot {
                padding: 1px 5.5px;
            }
            #spot55 { padding: 1px 2.5px; }
            #spot56 { padding: 1px 0.5px; }
            #spot57 { padding: 1px 0.5px; }
            #spot58 { padding: 1px 0.5px; }
            #spot59 { padding: 1px 0.5px; }
            #spot60 { padding: 1px 0.5px; }
            #spot61 { padding: 1px 0.5px; }
            #spot62 { padding: 1px 0.5px; }
            #spot63 { padding: 1px 0.5px; }
            #spot64 { padding: 1px 0.5px; }
            #spot65 { padding: 1px 0.5px; }
            #spot66 { padding: 1px 0.5px; }
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
            <a href="/Estacion/Estacion/Index.html" class="mr-3">
                Dashboards
                <i class="bi bi-speedometer2"></i>
            </a>
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="levelsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Niveles
                    <i class="bi bi-layers"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="levelsDropdown">
                    <a class="dropdown-item" href="/Estacion/Estacion/Level/Level1/level.php">Nivel 1</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/Level/Level2/level.php">Nivel 2</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/Level/Level3/level.php">Nivel 3</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/Level/Level4/level.php">Nivel 4</a>
                </div>
            </div>
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="basementsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sótanos
                    <i class="bi bi-building"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="basementsDropdown">
                    <a class="dropdown-item" href="/Estacion/Estacion/Basement/Basement1/basement.php">Sótano 1</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/Basement/Basement2/basement.php">Sótano 2</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/Basement/Basement3/basement.php">Sótano 3</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/Basement/Basement4/basement.php">Sótano 4</a>
                </div>
            </div>
            <div class="dropdown mr-3">
                <a href="#" class="dropdown-toggle" id="camerasDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cámaras
                    <i class="bi bi-camera"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="camerasDropdown">
                    <a class="dropdown-item" href="/Estacion/Estacion/camaras/niveles.html">Niveles</a>
                    <a class="dropdown-item" href="/Estacion/Estacion/camaras/sotano.html">Sótanos</a>
                </div>
            </div>
            <a href="/Estacion/Estacion/Statistics/statistics.html" class="mr-3">
                Estadísticas
                <i class="bi bi-bar-chart-line"></i>
            </a>
        </nav>
        <div class="user-icon">
            <a href="/Estacion/Estacion/Profile/profile.php">
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
        <h2 class="text-center mb-4">Vista de Niveles - Parking Dashboard</h2>

        <!-- Contenedor para la imagen y los spots -->
        <div class="parking-container">
            <img src="N3.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <!-- Contenedor dinámico de spots -->
            <div class="spots-container">
                <?php
                // Configuración de la base de datos
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

                // Consulta SQL para obtener los cajones del 47 al 66
                $sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Cajon BETWEEN 47 AND 66";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Generar los spots basados en la consulta
                    while($row = $result->fetch_assoc()) {
                        $n_cajon = $row["N_Cajon"];
                        $disponibilidad = $row["disponibilidad"];
                        $class = $disponibilidad == 0 ? "spot-enabled" : "spot-disabled";
                        echo "<div class='parking-spot $class' id='spot$n_cajon' data-cajon='$n_cajon'>$n_cajon</div>";
                    }
                } else {
                    echo "No se encontraron resultados.";
                }

                $conn->close();
                ?>
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
                // Cambia el estado del spot al hacer clic
                spot.classList.toggle('spot-enabled');
                spot.classList.toggle('spot-disabled');
                spot.classList.toggle('spot-selected');
            });
        });

        // Función para cambiar el estado de todos los spots
        function toggleAllSpots() {
            spots.forEach(function(spot) {
                spot.classList.remove('spot-disabled'); // Asegura que no estén deshabilitados
                spot.classList.add('spot-enabled');
            });
        }

        // Función para deshabilitar los spots seleccionados
        function disableSelectedSpots() {
            spots.forEach(function(spot) {
                if (spot.classList.contains('spot-selected')) {
                    spot.classList.remove('spot-enabled');
                    spot.classList.add('spot-disabled');
                    spot.classList.remove('spot-selected');
                }
            });
        }
    </script>
</body>
</html>
