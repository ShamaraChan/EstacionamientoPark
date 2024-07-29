<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking";
$port = 3306;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function obtenerDatos($last_id) {
    global $conn;

    $sql = "SELECT id, lugares_ocupados, lugares_disponibles FROM disponibilidadautomatico WHERE id > ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $last_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lugares_ocupados = $row["lugares_ocupados"];
        $lugares_disponibles = $row["lugares_disponibles"];
        $new_id = $row["id"];
        
        $sql_niveles = "SELECT disponibles_n1, disponibles_n2, disponibles_n3, disponibles_n4 FROM disponibilidadnivel WHERE id = 1";
        $result_niveles = $conn->query($sql_niveles);

        $niveles = array();
        if ($result_niveles->num_rows > 0) {
            $row_niveles = $result_niveles->fetch_assoc();
            $niveles[] = array('nivel' => '1', 'lugares_disponibles' => $row_niveles["disponibles_n1"]);
            $niveles[] = array('nivel' => '2', 'lugares_disponibles' => $row_niveles["disponibles_n2"]);
            $niveles[] = array('nivel' => '3', 'lugares_disponibles' => $row_niveles["disponibles_n3"]);
            $niveles[] = array('nivel' => '4', 'lugares_disponibles' => $row_niveles["disponibles_n4"]);
        }

        echo json_encode(array(
            'new_id' => $new_id,
            'lugares_ocupados' => $lugares_ocupados,
            'lugares_disponibles' => $lugares_disponibles,
            'niveles' => $niveles
        ));
    } else {
        echo json_encode(array(
            'error' => 'No se encontraron nuevos resultados'
        ));
    }

    $conn->close();
}

if (isset($_GET['obtener_datos'])) {
    $last_id = isset($_GET['last_id']) ? intval($_GET['last_id']) : 0;
    obtenerDatos($last_id);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Agregar Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9; /* Color de fondo deseado */
            margin: 0;
            padding: 0;
        }
        .bg-total {
            background-color: #708090; /* Verde claro para total */
        }

        .bg-occupied {
            background-color: #CD5C5C; /* Rojo claro para ocupados */
        }

        .bg-available {
            background-color: #90EE90; /* Azul claro para disponibles */
        }

        .bg-levels {
            background-color: #D3D3D3; /* Amarillo claro para niveles */
        }

        .bg-stats {
            background-color: #D3D3D3; /* Púrpura claro para estadísticas */
        }
    </style>
</head>

<body>
    <header class="header d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="/Estacion/Index.php">
                <img src="logo.png" height="50px" margin-right="10px">
            </a>
        </div>
        <nav class="ml-auto">
            <!-- Botón Dashboards -->
            <a href="/Estacion/Index.php" class="mr-3">
                Inicio
                <i class="bi bi-speedometer2"></i>
            </a>
            
            <!-- Botón Lugares -->
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
            
            <!-- Botón Cámaras -->
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

            <a href="/EStacion/Statistics/statistics.php" class="mr-3">Estadísticas
                <i class="bi bi-bar-chart-line"></i>
            </a>

            <div class="user-icon">
                <a href="/Estacion/Profile/profile.php">
                    <lord-icon
                    src="https://cdn.lordicon.com/bgebyztw.json"
                    trigger="hover"
                    colors="primary:#109173,secondary:#08a88a"
                    style="width:35px;height:35px">
                    </lord-icon>
                </a>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="dashboard">
            <h1 class="mb-4 text-center">Estacionamiento Dashboard</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-total mb-3 shadow-lg">
                        <div class="card-body text-center">
                            <i class="bi bi-car-front-fill display-1 mb-3"></i>
                            <h5 class="card-title">Espacios Totales</h5>
                            <p class="card-text display-4">185</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-occupied mb-3 shadow-lg">
                        <div class="card-body text-center">
                            <i class="bi bi-x-circle-fill display-1 mb-3"></i>
                            <h5 class="card-title">Espacios Ocupados</h5>
                            <p class="card-text display-4" id="lugares_ocupados">-</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-available mb-3 shadow-lg">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle-fill display-1 mb-3"></i>
                            <h5 class="card-title">Espacios Disponibles</h5>
                            <p class="card-text display-4" id="lugares_disponibles">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card text-white bg-levels mb-3 shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title">Niveles del Estacionamiento</h5>
                            <ul class="list-group list-group-flush text-dark">
                                <li class="list-group-item bg-level" id="s1-disponibles">S1: -</li>
                                <li class="list-group-item bg-level" id="s2-disponibles">S2: -</li>
                                <li class="list-group-item bg-level" id="s3-disponibles">S3: -</li>
                                <li class="list-group-item bg-level" id="s4-disponibles">S4: -</li>
                                <li class="list-group-item bg-level">N1</li>
                                <li class="list-group-item bg-level">N2</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-stats mb-3 shadow-lg">
                        <div class="card-body text-center">
                            <i class="bi bi-bar-chart-fill display-1 mb-3"></i>
                            <h5 class="card-title">Estadísticas</h5>
                            <p class="card-text">Sótano más usado: S4</p>
                            <p class="card-text">Tiempo con más ocupación: 5 PM - 7 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- Agregar Bootstrap JS al final del cuerpo -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
    <script>
        function fetchData(last_id) {
            $.ajax({
                url: 'index.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    obtener_datos: true,
                    last_id: last_id
                },
                success: function(data) {
                    if (!data.error) {
                        $('#lugares_ocupados').text(data.lugares_ocupados);
                        $('#lugares_disponibles').text(data.lugares_disponibles);

                        var niveles = data.niveles;
                        niveles.forEach(function(nivel) {
                            var nivelId = 's' + nivel.nivel + '-disponibles';
                            var nivelText = 'S' + nivel.nivel + ': Disponibles: ' + nivel.lugares_disponibles;
                            $('#' + nivelId).text(nivelText);
                        });

                        last_id = data.new_id;
                    } else {
                        console.log("No new data");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: " + error);
                }
            });
        }

        $(document).ready(function() {
            let last_id = 0;
            fetchData(last_id);

            setInterval(function() {
                fetchData(last_id);
            }, 5000);
        });
    </script>
    
</body>

</html>
    <!-- Corregido -->