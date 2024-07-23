<?php
session_start();
include 'includes/config.php';

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'A') {
    header('Location: registro_acceso.php');
    exit;
}

// Verifica si se recibieron los datos necesarios
if (isset($_POST['id'], $_POST['type'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $type = $_POST['type'];
    $action = $_POST['action'];

    if ($type === 'pelicula') {
        if ($action === 'activar') {
            $sql = "UPDATE peliculas SET estado='A' WHERE id=$id";
        } elseif ($action === 'desactivar') {
            $sql = "UPDATE peliculas SET estado='D' WHERE id=$id";
        }
    } elseif ($type === 'usuario') {
        if ($action === 'activar') {
            $sql = "UPDATE Usuarios SET estado='A' WHERE id=$id";
        } elseif ($action === 'desactivar') {
            $sql = "UPDATE Usuarios SET estado='D' WHERE id=$id";
        } elseif ($action === 'borrar') {
            $sql = "UPDATE Usuarios SET estado='B' WHERE id=$id";
        }
    }

    if (mysqli_query($conpel, $sql)) {
        header('Location: index.php');
    } else {
        echo "Error al actualizar el estado: " . mysqli_error($conpel);
    }
} else {
    echo "Datos incompletos.";
}

// Cerrar conexión
mysqli_close($conpel);
?>

