<?php
include('session.php');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sótanos</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Agregar Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <style>
        .camera-img {
            width: 100%;
            height: auto;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .camera-img:hover {
            transform: scale(1.05);
        }
        .modal-dialog {
            max-width: 100%;
            margin: 0;
        }
        .modal-content {
            height: 90vh;
        }
        .modal-body {
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .modal-img {
            width: auto;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
        }
        .btn-group .btn {
            margin: 5px;
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


    <div class="container mt-5">
        <h1 class="text-primary">Sótanos</h1>
        <div class="btn-group mb-4" role="group" aria-label="Niveles">
            <button type="button" class="btn btn-primary" onclick="showLevel(1)">Sótano 1</button>
            <button type="button" class="btn btn-primary" onclick="showLevel(2)">Sótano 2</button>
            <button type="button" class="btn btn-primary" onclick="showLevel(3)">Sótano 3</button>
            <button type="button" class="btn btn-primary" onclick="showLevel(4)">Sótano 4</button>
        </div>
        <div id="cameras" class="row">
            <!-- Contenido de las cámaras -->
        </div>
    </div>

    <!-- Modal para mostrar la imagen en grande -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cameraModalLabel">Cámara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" class="modal-img" src="" alt="Cámara">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios para Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showLevel(level) {
            const camerasDiv = document.getElementById('cameras');
            camerasDiv.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const imgSrc = `camara_sotano${level}_${i}.jpg`;
                const cameraCard = `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Cámara ${i} Sótano ${level}</h5>
                                <img src="${imgSrc}" class="camera-img" alt="Cámara ${i} Sótano ${level}" onclick="showImage('${imgSrc}')">
                            </div>
                        </div>
                    </div>
                `;
                camerasDiv.innerHTML += cameraCard;
            }
        }

        function showImage(src) {
            document.getElementById('modalImage').src = src;
            $('#cameraModal').modal('show');
        }

        // Mostrar el Sótano 1 por defecto al cargar la página
        showLevel(1);
    </script>
    <footer class="bg-body-tertiary text-center">
  <!-- Grid container -->
  <div class="container p-4"></div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: #0F2F42; color: white;">
    © 2024 Copyright:
    <a style="color: white !important;">Universidad Tecnologica Metropolitana de Aguascalientes</a>
    <div class="logos" style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
      <a href="https://utma.edu.mx" style="margin-right: 10px;">
        <img src="utma.jpeg" height="50px">
      </a>
      <a href="https://campestreags.com">
        <img src="logo.png" height="50px">
      </a>
    </div>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>
