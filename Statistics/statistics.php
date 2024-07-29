<?php
include('session.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <a href="/Estacion/Statistics/statistics.php" class="mr-3">Estadísticas
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

    <div class="container mt-4" >
        <div class="dashboard">
            <h1></h1>
            <div class="row mb-4">
                <div class="col-md-4">
                    <!-- Ocupación del Estacionamiento en Diferentes Niveles -->
                    <canvas id="occupancyChart" width="400" height="400"></canvas>
                </div>
                <div class="col-md-4">
                    <!-- Patrones de Entrada y Salida de Vehículos -->
                    <canvas id="entryExitPatternChart" width="400" height="400"></canvas>
                </div>
                <div class="col-md-4">
                    <!-- Disponibilidad de Lugares a lo Largo del Día -->
                    <canvas id="availabilityOverDayChart" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!-- Tiempo Promedio de Estacionamiento -->
                    <canvas id="averageParkingTimeChart" width ="100" height="100"></canvas>
                </div>
                <div class="col-md-4">
                    <!-- Predicción de Lugares Disponibles en Tiempo Real -->
                    <canvas id="realTimePredictionChart" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    $(document).ready(function() {
        // Obtener datos para los gráficos
        $.getJSON('tabla.php', function(data) {
            // Ocupación del Estacionamiento en Diferentes Niveles
            const occupancyData = {
                labels: data.ocupacion_niveles.niveles,
                datasets: [{
                    label: 'Ocupación por Nivel',
                    data: data.ocupacion_niveles.cantidades,
                    borderColor: '#FF6384',
                    fill: false
                }]
            };
            const ctx1 = document.getElementById('occupancyChart').getContext('2d');
            const occupancyChart = new Chart(ctx1, {
                type: 'line',
                data: occupancyData
            });

            // Patrones de Entrada y Salida de Vehículos
            const entryExitData = {
                labels: data.entrada_salida.labels,
                datasets: [{
                    label: 'Entradas',
                    data: data.entrada_salida.entradas,
                    borderColor: '#FF6384',
                    fill: false
                }]
            };
            const ctx2 = document.getElementById('entryExitPatternChart').getContext('2d');
            const entryExitPatternChart = new Chart(ctx2, {
                type: 'line',
                data: entryExitData
            });

            // Disponibilidad de Lugares a lo Largo del Día
            const availabilityOverDayData = {
                labels: data.disponibilidad_dia.horas.map(hour => `${hour}:00`),
                datasets: [{
                    label: 'Disponibilidad',
                    data: data.disponibilidad_dia.disponibilidad,
                    borderColor: '#FFCE56',
                    fill: false
                }]
            };
            const ctx3 = document.getElementById('availabilityOverDayChart').getContext('2d');
            const availabilityOverDayChart = new Chart(ctx3, {
                type: 'line',
                data: availabilityOverDayData
            });

            // Tiempo Promedio de Estacionamiento
            const averageParkingTimeData = {
                labels: ['0-30 min', '30-60 min', '60-90 min', '90-120 min'],
                datasets: [{
                    label: 'Número de Vehículos',
                    data: [data.tiempo_promedio.tiempos.filter(t => t <= 30).length,
                           data.tiempo_promedio.tiempos.filter(t => t > 30 && t <= 60).length,
                           data.tiempo_promedio.tiempos.filter(t => t > 60 && t <= 90).length,
                           data.tiempo_promedio.tiempos.filter(t => t > 90).length],
                    backgroundColor: '#FFCE56'
                }]
            };
            const ctx4 = document.getElementById('averageParkingTimeChart').getContext('2d');
            const averageParkingTimeChart = new Chart(ctx4, {
                type: 'bar',
                data: averageParkingTimeData
            });

            // Predicción de Lugares Disponibles en Tiempo Real
            const realTimePredictionData = {
                labels: ['Ahora'],
                datasets: [{
                    label: 'Predicción de Lugares Disponibles',
                    data: data.prediccion,
                    borderColor: '#4BC0C0',
                    fill: false
                }]
            };
            const ctx5 = document.getElementById('realTimePredictionChart').getContext('2d');
            const realTimePredictionChart = new Chart(ctx5, {
                type: 'line',
                data: realTimePredictionData
            });
        });
    });
    </script>
</body>
</html>

