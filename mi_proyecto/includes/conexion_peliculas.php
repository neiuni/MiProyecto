<?php
include("includes/config.php");
?>

<?php
$servername = "sql107.infinityfree.com";
$username = "if0_36843442";
$password = "UCdEIzMBJciad";
$dbname = "if0_36843442_mispeliculas";

// Crear la conexión
$conpel = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conpel->connect_error) {
    die("Conexión fallida: " . $conpel->connect_error);
}

// Aquí puedes agregar la lógica para la conexión a la base de datos
