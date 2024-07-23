<?php
session_start();
require 'db.php'; // Asegúrate de que este archivo se conecta a la base de datos 'mispeliculas'
include ("public/index.php");

if (!isset($_SESSION['email'])) {
    header("Location: registro_acceso.php");
    exit();
}

$user_email = $_SESSION['email'];
$user_name = $_SESSION['nombre'] ?? 'Invitado'; // Valor predeterminado si 'nombre' no está definido

// Función para obtener las películas desde TMDb
function obtener_peliculas_tmdb($api_key) {
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=$api_key&language=es-ES";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Función para agregar una película a la base de datos
function agregar_pelicula_db($tmdb_id, $titulo, $poster, $estreno, $overview, $conn) {
    $sql = "INSERT INTO peliculas (tmdb_id, titulo, poster, estado, estreno, overview) VALUES (?, ?, ?, 'A', ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $tmdb_id, $titulo, $poster, $estreno, $overview);
    $stmt->execute();
    $stmt->close();
}

// Función para activar una película
function activar_pelicula($pelicula_id, $conn) {
    $sql = "UPDATE peliculas SET estado = 'A' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pelicula_id);
    $stmt->execute();
    $stmt->close();
}

// Función para eliminar una película
function eliminar_pelicula($pelicula_id, $conn) {
    $sql = "DELETE FROM peliculas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pelicula_id);
    $stmt->execute();
    $stmt->close();
}

// Función para modificar una película
function modificar_pelicula($pelicula_id, $titulo, $poster, $estreno, $overview, $conn) {
    $sql = "UPDATE peliculas SET titulo = ?, poster = ?, estreno = ?, overview = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $titulo, $poster, $estreno, $overview, $pelicula_id);
    $stmt->execute();
    $stmt->close();
}

// Manejo de acciones
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        $tmdb_id = $_POST['tmdb_id'];
        $titulo = $_POST['titulo'];
        $poster = $_POST['poster'];
        $estreno = $_POST['estreno'];
        $overview = $_POST['overview'];
        agregar_pelicula_db($tmdb_id, $titulo, $poster, $estreno, $overview, $conn);
    }
}

if (isset($_GET['activar'])) {
    $pelicula_id = $_GET['activar'];
    activar_pelicula($pelicula_id, $conn);
}

if (isset($_GET['eliminar'])) {
    $pelicula_id = $_GET['eliminar'];
    eliminar_pelicula($pelicula_id, $conn);
}

if (isset($_GET['modificar'])) {
    $pelicula_id = $_GET['modificar'];
    // Aquí se debería redirigir a una página de modificación con el id de la película
    header("Location: modificar_pelicula.php?id=$pelicula_id");
    exit();
}

// Obtener películas de TMDb
$api_key = 'd88ba9ba1569e78c86d0716612d08dd1'; // Reemplaza con tu clave de API de TMDb
$peliculas_tmdb = obtener_peliculas_tmdb($api_key);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .welcome-message {
            background-color: #007bff; /* Color de fondo azul */
            color: white; /* Color del texto blanco */
            padding: 0.5rem 1rem; /* Espaciado interno */
            border-radius: 0.25rem; /* Bordes redondeados */
            font-weight: bold; /* Negrita */
            margin-right: 1rem; /* Margen derecho */
        }
        .card-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn-sm {
            font-size: 0.875rem; /* Tamaño del texto más pequeño */
            padding: 0.25rem 0.5rem; /* Espaciado interno más pequeño */
        }
    </style>
</head>
<body>
    <!-- Menú de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Mi Proyecto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text ms-3 welcome-message">
                            Bienvenido, <?= htmlspecialchars($user_name) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Ultimas novedades desde TMDb</h1>
        <div class="row">
            <?php if (!empty($peliculas_tmdb['results'])): ?>
                <?php foreach ($peliculas_tmdb['results'] as $pelicula): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($pelicula['poster_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pelicula['title']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($pelicula['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($pelicula['overview']) ?></p>
                                <div class="card-actions">
                                    <form method="POST" action="">
                                        <input type="hidden" name="tmdb_id" value="<?= htmlspecialchars($pelicula['id']) ?>">
                                        <input type="hidden" name="titulo" value="<?= htmlspecialchars($pelicula['title']) ?>">
                                        <input type="hidden" name="poster" value="<?= htmlspecialchars($pelicula['poster_path']) ?>">
                                        <input type="hidden" name="estreno" value="<?= htmlspecialchars($pelicula['release_date']) ?>">
                                        <input type="hidden" name="overview" value="<?= htmlspecialchars($pelicula['overview']) ?>">
                                        <button type="submit" name="agregar" class="btn btn-primary btn-sm">Agregar</button>
                                    </form>
                                    <a href="?activar=<?= htmlspecialchars($pelicula['id']) ?>" class="btn btn-success btn-sm">Activar</a>
                                    <a href="?modificar=<?= htmlspecialchars($pelicula['id']) ?>" class="btn btn-warning btn-sm text-white">Modificar</a>
                                    <a href="?eliminar=<?= htmlspecialchars($pelicula['id']) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron películas.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>




