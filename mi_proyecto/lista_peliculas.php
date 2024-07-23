<?php

// Configuración de la API de TMDb
$apiKey = 'd88ba9ba1569e78c86d0716612d08dd1'; // Reemplaza con tu clave API
$apiUrl = 'https://api.themoviedb.org/3/movie/now_playing?api_key=' . $apiKey . '&language=es-ES';

// Función para obtener datos de la API
function fetchMovies($url) {
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Obtener las películas en cartelera
$movies = fetchMovies($apiUrl)['results'];

// Función para obtener el elenco y el equipo de una película
function fetchMovieDetails($movieId, $apiKey) {
    $detailsUrl = "https://api.themoviedb.org/3/movie/$movieId?api_key=$apiKey&language=es-ES";
    $creditsUrl = "https://api.themoviedb.org/3/movie/$movieId/credits?api_key=$apiKey&language=es-ES";
    $videosUrl = "https://api.themoviedb.org/3/movie/$movieId/videos?api_key=$apiKey&language=es-ES";
    
    $details = file_get_contents($detailsUrl);
    $credits = file_get_contents($creditsUrl);
    $videos = file_get_contents($videosUrl);
    
    return [
        'details' => json_decode($details, true),
        'credits' => json_decode($credits, true),
        'videos' => json_decode($videos, true),
    ];
}

$moviesDetails = [];
foreach ($movies as $movie) {
    $movieDetails = fetchMovieDetails($movie['id'], $apiKey);
    $moviesDetails[] = [
        'movie' => $movie,
        'details' => $movieDetails['details'],
        'credits' => $movieDetails['credits'],
        'videos' => $movieDetails['videos'],
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas en Cartelera</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        .carousel-item {
            padding: 20px;
        }
        .card {
            width: 200px; /* Tamaño de la tarjeta ajustado */
            border: none;
            margin: 20px; /* Espacio entre las tarjetas */
        }
        .card-img-top {
            height: 300px; /* Altura de la imagen ajustada */
            object-fit: cover;
        }
        .card-body {
            padding: 10px;
        }
        .btn-description {
            width: 100%;
        }
        .collapse {
            margin-top: 10px;
        }
        .d-flex {
            justify-content: center;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1>Últimas novedades desde TMDb</h1>
        <div class="row">

    <!-- Carrusel de Películas -->
    <div id="movieCarousel" class="carousel slide mt-5">
        <div class="carousel-inner">
            <?php foreach (array_chunk($moviesDetails, 4) as $index => $moviesChunk): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="d-flex justify-content-center flex-wrap">
                        <?php foreach ($moviesChunk as $movieDetail): ?>
                            <?php
                                $movie = $movieDetail['movie'];
                                $details = $movieDetail['details'];
                                $credits = $movieDetail['credits'];
                                $videos = $movieDetail['videos'];
                            ?>
                            <div class="card">
                                <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?>">
                                <div class="card-body">
                                    <h6 class="card-title"><?= htmlspecialchars($movie['title']) ?></h6>
                                    <p class="card-text">
                                        <strong>Director(es):</strong> 
                                        <?php 
                                            $directors = array_filter($credits['crew'], function($person) {
                                                return $person['job'] === 'Director';
                                            });
                                            echo implode(', ', array_column($directors, 'name')); 
                                        ?>
                                    </p>
                                    <p class="card-text">
                                        <strong>Actor(es):</strong> 
                                        <?php 
                                            $actors = array_slice($credits['cast'], 0, 5); // Primeros 5 actores
                                            echo implode(', ', array_column($actors, 'name')); 
                                        ?>
                                    </p>
                                    <p class="card-text"><strong>Fecha de lanzamiento:</strong> <?= htmlspecialchars($details['release_date']) ?></p>
                                    <?php if (isset($videos['results'][0])): ?>
                                        <p class="card-text"><strong>Trailer:</strong></p>
                                        <iframe width="100%" height="150" src="https://www.youtube.com/embed/<?= htmlspecialchars($videos['results'][0]['key']) ?>" frameborder="0" allowfullscreen></iframe>
                                    <?php endif; ?>
                                    <button class="btn btn-primary btn-description" type="button" data-bs-toggle="modal" data-bs-target="#descriptionModal<?= $movie['id'] ?>">
                                        Ver Descripción
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="descriptionModal<?= $movie['id'] ?>" tabindex="-1" aria-labelledby="descriptionModalLabel<?= $movie['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="descriptionModalLabel<?= $movie['id'] ?>">Registro Necesario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Para obtener más información sobre esta película, por favor regístrate en nuestro sitio.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <a href="registro_acceso.php" class="btn btn-primary">Regístrate</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#movieCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#movieCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <!-- Bootstrap 5 JavaScript y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include ("includes/footer.php");
?>












