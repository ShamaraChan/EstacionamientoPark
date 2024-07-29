<?php
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

// Obtener datos para el gráfico de Ocupación del Estacionamiento en Diferentes Niveles
$ocupacion_sql = "
    SELECT N_Nivel, COUNT(*) AS cantidad
    FROM cajones
    GROUP BY N_Nivel
";
$ocupacion_result = $conn->query($ocupacion_sql);

$niveles = [];
$cantidades = [];

if ($ocupacion_result->num_rows > 0) {
    while ($row = $ocupacion_result->fetch_assoc()) {
        $niveles[] = $row['N_Nivel'];
        $cantidades[] = (int)$row['cantidad'];
    }
}

// Obtener datos para el gráfico de Patrones de Entrada y Salida de Vehículos
$entrada_salida_sql = "
    SELECT DAYOFWEEK(hora_entrada) AS dia, COUNT(*) AS entradas
    FROM estacionamiento_entrada
    WHERE hora_entrada BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
    GROUP BY DAYOFWEEK(hora_entrada)
";
$entrada_salida_result = $conn->query($entrada_salida_sql);

$entradas = array_fill(1, 7, 0);

if ($entrada_salida_result->num_rows > 0) {
    while ($row = $entrada_salida_result->fetch_assoc()) {
        $entradas[$row['dia']] = (int) $row['entradas'];
    }
}

// Obtener datos para el gráfico de Disponibilidad de Lugares a lo Largo del Día
$disponibilidad_sql = "
    SELECT HOUR(hora_entrada) AS hora, AVG(disponibilidad) AS disponibilidad
    FROM cajones
    GROUP BY HOUR(hora_entrada)
";
$disponibilidad_result = $conn->query($disponibilidad_sql);

$horas = [];
$disponibilidades = [];

if ($disponibilidad_result->num_rows > 0) {
    while ($row = $disponibilidad_result->fetch_assoc()) {
        $horas[] = $row['hora'];
        $disponibilidades[] = (int) $row['disponibilidad'];
    }
}

// Obtener datos para el gráfico de Tiempo Promedio de Estacionamiento
$tiempo_sql = "
    SELECT TIME_TO_SEC(TIMEDIFF(hora_salida, hora_entrada)) / 60 AS tiempo
    FROM estacionamiento_salida
    JOIN estacionamiento_entrada ON estacionamiento_salida.id_carro = estacionamiento_entrada.id_carro
";
$tiempo_result = $conn->query($tiempo_sql);

$tiempos = [];

if ($tiempo_result->num_rows > 0) {
    while ($row = $tiempo_result->fetch_assoc()) {
        $tiempos[] = (int) $row['tiempo'];
    }
}

// Obtener datos para el gráfico de Predicción de Lugares Disponibles en Tiempo Real
$prediccion_sql = "
    SELECT NOW() AS hora_actual, COUNT(*) AS disponibles
    FROM cajones
    WHERE disponibilidad = 'disponible'
";
$prediccion_result = $conn->query($prediccion_sql);

$prediccion = [];

if ($prediccion_result->num_rows > 0) {
    $row = $prediccion_result->fetch_assoc();
    $prediccion = [(int) $row['disponibles']];
}

$conn->close();

// Enviar los datos en formato JSON
echo json_encode(array(
    "ocupacion_niveles" => array("niveles" => $niveles, "cantidades" => $cantidades),
    "entrada_salida" => array("labels" => ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'], "entradas" => $entradas),
    "disponibilidad_dia" => array("horas" => $horas, "disponibilidad" => $disponibilidades),
    "tiempo_promedio" => array("tiempos" => $tiempos),
    "prediccion" => $prediccion
));
?>
