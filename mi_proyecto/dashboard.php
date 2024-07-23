<?php
session_start();

// Verificar si el usuario tiene permisos de administrador (rol 'A')
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'A') {
    header("Location: acceso.php"); // Redirigir si no tiene permisos
    exit();
}

// Verificar si se ha recibido el ID del usuario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['usuario_id'])) {
    $usuario_id = intval($_POST['usuario_id']);

    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mispeliculas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar y ejecutar la consulta para actualizar el estado del usuario
    $query = "UPDATE Usuarios SET estado = 'A' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $usuario_id);

    if ($stmt->execute()) {
        echo "Usuario activado correctamente.";
    } else {
        echo "Error al activar usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Redirigir de vuelta a la página de usuarios después de activar
header("Location: usuarios.php");
exit();
?>


