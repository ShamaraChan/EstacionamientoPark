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
        .parking-container {
            position: relative;
            max-width: 1000px; /* Ajusta el ancho máximo según sea necesario */
            margin: 0 auto; /* Centra el contenedor horizontalmente */
            border: 2px solid #000; /* Añade un borde para hacer visible el contenedor */
            background-color: #f8f9fa; /* Fondo claro para visibilidad */
            overflow: hidden; /* Asegura que los spots no salgan del contenedor */
        }
    
        .parking-image {
            display: block;
            width: 100%;
            height: auto;
        }
    
        .parking-spot {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 47px 33px; /* Ajusta el tamaño del padding */
            border-radius: 5px;
            cursor: pointer;
            transform: translate(-50%, -50%); /* Ajusta la posición al centro del punto específico */
            color: #a09c9c;
            pointer-events: auto; /* Habilita la respuesta al clic */
        }
    
        /* Estilos para estados de los spots */
        .spot-green {
            background-color: #28a745; /* Verde */
            color: white;
        }
    
        .spot-red {
            background-color: #dc3545; /* Rojo */
            color: white;
        }
    
        /* Ajustes para posiciones específicas */
        #spot67 { top: 20.5%; left: 17.3%; }
        #spot68 { top: 20.5%; left: 25.4%; }
        #spot69 { top: 20.5%; left: 33.5%; }
        #spot70 { top: 20.5%; left: 41.6%; }
        #spot71 { top: 20.5%; left: 49.7%; }
        #spot72 { top: 20.5%; left: 57.8%; }
        #spot73 { top: 20.5%; left: 65.9%; }
        #spot74 { top: 20.5%; left: 73.99%; }
        #spot75 { top: 20.5%; left: 81.9%; }
        #spot76 { top: 82.6%; left: 25.8%; }
        #spot77 { top: 82.6%; left: 33.4%; }
        #spot78 { top: 82.6%; left: 40.9%; }
        #spot79 { top: 82.6%; left: 48.5%; }
        #spot80 { top: 82.6%; left: 56.1%; }
        #spot81 { top: 82.6%; left: 63.75%; }
        #spot82 { top: 82.6%; left: 71.3%; }
        #spot83 { top: 82.6%; left: 78.85%; }
        #spot84 { top: 82.6%; left: 86.5%; }
        #spot85 { top: 82.6%; left: 94.2%; }
        #spot86 { top: 79.5%; left: 4.57%; }
        #spot87 { top: 79.5%; left: 10.5999%; }
        #spot88 { top: 79.5%; left: 17.2%; }
    
        /* Media queries para ajustes de tamaño de pantalla */
        @media (max-width: 768px) {
            .parking-spot {
                padding: 1px 5.5px; /* Ajusta el tamaño del padding para dispositivos móviles */
            }
            #spot67 { padding: 1px 5.5px; }
            #spot68 { padding: 2px 0px; }
            #spot69 { padding: 2px 0px; }
            #spot70 { padding: 2px 0px; }
            #spot71 { padding: 2px 0px; }
            #spot72 { padding: 2px 0px; }
            #spot73 { padding: 2px 0px; }
            #spot74 { padding: 2px 0px; }
            #spot75 { padding: 2px 0px; }
            #spot76 { padding: 2px 0px; }
            #spot77 { padding: 2px 0px; }
            #spot78 { padding: 2px 0px; }
            #spot79 { padding: 2px 0px; }
            #spot80 { padding: 2px 0px; }
            #spot81 { padding: 2px 0px; }
            #spot82 { padding: 2px 0px; }
            #spot83 { padding: 2px 0px; }
            #spot84 { padding: 2px 0px; }
            #spot85 { padding: 2px 0px; }
            #spot86 { padding: 2px 0px; }
            #spot87 { padding: 2px 0px; }
            #spot88 { padding: 2px 0px; }
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
            <img src="N4.jpg" class="parking-image" alt="Vista de niveles del estacionamiento">

            <!-- Spots para los lugares de estacionamiento -->
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

                // Consultar los cajones del 67 al 88
                $sql = "SELECT N_Cajon, disponibilidad FROM cajones WHERE N_Cajon BETWEEN 67 AND 88";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Mostrar los cajones
                    while ($row = $result->fetch_assoc()) {
                        $spotId = "spot" . $row['N_Cajon'];
                        $class = ($row['disponibilidad'] == 0) ? "spot-green" : "spot-red";
                        echo "<div class='parking-spot $class' id='$spotId'>" . $row['N_Cajon'] . "</div>";
                    }
                } else {
                    echo "No se encontraron cajones.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Botones para controlar los spots -->
    <div class="container mt-3">
        <button class="btn btn-primary mr-2" onclick="toggleAllSpots()">Cambiar Estado de Todos los Spots</button>
        <button class="btn btn-secondary">Otro Botón</button>
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
                // Cambia el color del spot al hacer clic
                if (spot.classList.contains('spot-green')) {
                    spot.classList.remove('spot-green');
                    spot.classList.add('spot-red');
                } else if (spot.classList.contains('spot-red')) {
                    spot.classList.remove('spot-red');
                    spot.classList.add('spot-green');
                } else {
                    // Si no tiene clase de color, asigna verde por defecto
                    spot.classList.add('spot-green');
                }
            });
        });

        // Función para cambiar el estado de todos los spots
        function toggleAllSpots() {
            spots.forEach(function(spot) {
                // Alterna entre verde y rojo
                if (spot.classList.contains('spot-green')) {
                    spot.classList.remove('spot-green');
                    spot.classList.add('spot-red');
                } else if (spot.classList.contains('spot-red')) {
                    spot.classList.remove('spot-red');
                    spot.classList.add('spot-green');
                } else {
                    // Si no tiene clase de color, asigna verde por defecto
                    spot.classList.add('spot-green');
                }
            });
        }
    </script>
</body>
</html>
