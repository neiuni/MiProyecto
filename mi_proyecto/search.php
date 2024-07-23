<?php
$apiKey = 'd88ba9ba1569e78c86d0716612d08dd1'; // Reemplaza con tu clave API

// Función para buscar películas en TMDB
function buscar_peliculas_tmdb($query) {
    global $apiKey;
    $url = "https://api.themoviedb.org/3/search/movie?api_key={$apiKey}&query=" . urlencode($query) . "&language=es-ES";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Función para obtener detalles de una película en TMDB
function obtener_detalles_pelicula_tmdb($movie_id) {
    global $apiKey;
    $url = "https://api.themoviedb.org/3/movie/{$movie_id}?api_key={$apiKey}&append_to_response=credits";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

$searchResults = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = $_POST['query'];
    $searchResults = buscar_peliculas_tmdb($query)['results'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Películas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .movie-card {
            border: none;
            margin: 10px;
        }
        .movie-card-img {
            height: 300px;
            object-fit: cover;
        }
        .movie-card-body {
            text-align: center;
        }
        .movie-details {
            margin-top: 10px;
        }
        .movie-actors {
            font-size: 0.9em;
            color: #555;
        }
        .search-container {
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="search-container">
        <form method="POST" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="Buscar películas..." required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>

    <?php if (!empty($searchResults)): ?>
        <h1>Resultados de Búsqueda para: <?= htmlspecialchars($_POST['query']) ?></h1>
        <div class="row">
            <?php foreach ($searchResults as $movie): ?>
                <?php
                // Obtener el elenco de la película
                $movieId = $movie['id'];
                $movieDetails = obtener_detalles_pelicula_tmdb($movieId);
                $actors = array_slice($movieDetails['credits']['cast'], 0, 5); // Primeros 5 actores
                ?>
                <div class="col-md-3">
                    <div class="card movie-card">
                        <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']) ?>" class="card-img-top movie-card-img" alt="<?= htmlspecialchars($movie['title']) ?>">
                        <div class="card-body movie-card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                            <p class="card-text"><strong>Fecha de Lanzamiento:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>
                            <p class="movie-actors"><strong>Elenco:</strong> 
                                <?php 
                                if (!empty($actors)) {
                                    $actorNames = array_map(function($actor) {
                                        return htmlspecialchars($actor['name']);
                                    }, $actors);
                                    echo implode(', ', $actorNames);
                                } else {
                                    echo 'No disponible';
                                }
                                ?>
                            </p>
                            <a href="movie_details.php?id=<?= htmlspecialchars($movie['id']) ?>" class="btn btn-primary">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_POST['query'])): ?>
        <p>No se encontraron resultados para tu búsqueda.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap 5 JavaScript y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

