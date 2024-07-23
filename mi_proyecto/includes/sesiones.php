<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
session_start();

// Aquí puedes agregar la lógica para manejar sesiones
