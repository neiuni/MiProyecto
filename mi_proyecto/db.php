<?php
// Archivo: db.php
$db_host = 'localhost'; // Cambia esto si es necesario
$db_user = 'root'; // Cambia esto si es necesario
$db_pass = ''; // Cambia esto si es necesario
$db_name = 'mispeliculas'; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
?>





