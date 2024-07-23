<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
header("Location: registro_acceso.php"); // Redirige a la página de inicio de sesión
exit();
?>




