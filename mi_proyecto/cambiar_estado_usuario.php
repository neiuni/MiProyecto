<?php
session_start();
include 'includes/config.php';

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'A') {
    header('Location: lregistro_acceso.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $nuevo_estado = $_POST['estado'];

    // Conexión a la base de datos
    $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conexion->connect_error) {
        die("La conexión ha fallado: " . $conexion->connect_error);
    }

    // Actualizar el estado del usuario
    $sql = "UPDATE Usuarios SET estado = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $nuevo_estado, $user_id);
    $stmt->execute();

    $stmt->close();
    $conexion->close();

    header("Location: index.php");
    exit();
}
?>
