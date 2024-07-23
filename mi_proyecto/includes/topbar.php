
<?php
session_start();

if (isset($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
} else {
    $nombre_usuario = "Invitado"; // O cualquier valor predeterminado que desees
}
?>
<div class="topbar">
    <p>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></p>
    <!-- Otros elementos de la barra superior -->
</div>

