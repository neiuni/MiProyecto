<?php
session_start();
require 'db.php'; // Conexión a la base de datos
include('public/index.php'); // Conexión
// Función para obtener los géneros desde TMDb
function obtener_generos_tmdb($api_key) {
    $url = "https://api.themoviedb.org/3/genre/movie/list?api_key=$api_key&language=es-ES";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Función para obtener películas por género
function obtener_peliculas_por_genero_tmdb($api_key, $genero_id) {
    $url = "https://api.themoviedb.org/3/discover/movie?api_key=$api_key&with_genres=$genero_id&language=es-ES";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Configuración de API
$api_key = 'd88ba9ba1569e78c86d0716612d08dd1'; // Reemplaza con tu clave de API

// Obtener géneros de TMDb
$generos_tmdb = obtener_generos_tmdb($api_key);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Géneros de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .welcome-message {
            background-color: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: bold;
            margin-right: 1rem;
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
                            Bienvenido, <?= htmlspecialchars($_SESSION['nombre'] ?? 'Invitado') ?>
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
        <h1>Géneros de Películas</h1>
        <h3>Nuestras recomendaciones</h3>
        <div class="accordion" id="accordionExample">
            <?php if (!empty($generos_tmdb['genres'])): ?>
                <?php foreach ($generos_tmdb['genres'] as $genero): ?>
                    <?php
                    // Obtener películas para cada género
                    $peliculas_genero = obtener_peliculas_por_genero_tmdb($api_key, $genero['id']);
                    $num_peliculas = count($peliculas_genero['results']);
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= htmlspecialchars($genero['id']) ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= htmlspecialchars($genero['id']) ?>" aria-expanded="true" aria-controls="collapse<?= htmlspecialchars($genero['id']) ?>">
                                <?= htmlspecialchars($genero['name']) ?> (<?= $num_peliculas ?>)
                            </button>
                        </h2>
                        <div id="collapse<?= htmlspecialchars($genero['id']) ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= htmlspecialchars($genero['id']) ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php if ($num_peliculas > 0): ?>
                                    <ul class="list-unstyled">
                                        <?php foreach ($peliculas_genero['results'] as $pelicula): ?>
                                            <li>
                                                <a href="pelicula_detalle.php?id=<?= htmlspecialchars($pelicula['id']) ?>">
                                                    <?= htmlspecialchars($pelicula['title']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>No se encontraron películas para este género.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron géneros.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php

include ("includes/footer.php");




