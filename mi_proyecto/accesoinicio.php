<?php
session_start();
require 'db.php'; // Asegúrate de que este archivo se conecta a la base de datos 'peliculas'
include("public/index.php");

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

function registrar_usuario($nombre, $email, $password) {
    global $conn;

    $nombre = $conn->real_escape_string($nombre);
    $email = $conn->real_escape_string($email);
    $password = password_hash($password, PASSWORD_BCRYPT); // Encriptar la contraseña

    // Verificar si el correo ya está registrado
    $sql_check = "SELECT * FROM Usuarios WHERE mail = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        return '<div class="alert alert-warning" role="alert">El correo electrónico ya está registrado.</div>';
    } else {
        $sql = "INSERT INTO Usuarios (nombre, mail, password, rol, estado) VALUES ('$nombre', '$email', '$password', 'U', 'P')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id; // Iniciar sesión del nuevo usuario
            return '<div class="alert alert-success" role="alert">Cuenta creada exitosamente. Redirigiendo...</div>';
        } else {
            return '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['repeat_password'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];

        if ($password === $repeat_password) {
            $mensaje = registrar_usuario($nombre, $email, $password);
        } else {
            $mensaje = '<div class="alert alert-warning" role="alert">Las contraseñas no coinciden.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelis - Registro de Cuenta</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item {
            padding: 20px;
        }
        .card {
            width: 200px; /* Tamaño de la tarjeta ajustado */
            border: none;
            margin: 10px; /* Espacio entre las tarjetas */
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
        /* Estilos para el formulario de registro */
        .registration-form {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .registration-form h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .registration-form .form-group {
            margin-bottom: 15px;
        }
        .registration-form .form-control {
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
        }
        .registration-form .btn-primary {
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
        }
    </style>
</head>
<body>

<?php include("search.php"); ?>

<div class="container mt-5">
    <h1 class="text-center">Últimas novedades desde TMDb</h1>
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
                                        <button class="btn btn-primary btn-description" type="button" data-bs-toggle="collapse" data-bs-target="#description<?= $movie['id'] ?>" aria-expanded="false" aria-controls="description<?= $movie['id'] ?>">
                                            Ver Descripción
                                        </button>
                                        <div class="collapse mt-2" id="description<?= $movie['id'] ?>">
                                            <div class="card card-body">
                                                <p><?= htmlspecialchars($movie['overview']) ?: 'No hay descripción disponible.' ?></p>
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

        <!-- Formulario de Registro -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="registration-form">
                    <h1 class="text-center">Crear Cuenta</h1>
                    <?php if (isset($mensaje)) echo $mensaje; ?>
                    <form class="user" action="accesoinicio.php" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" placeholder="Nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" placeholder="Correo Electrónico" name="email" required>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user" placeholder="Contraseña" name="password" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user" placeholder="Repetir Contraseña" name="repeat_password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Registrar Cuenta
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.php">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="registro_acceso.php">¿Ya tienes una cuenta? ¡Inicia Sesión!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Bootstrap para notificar al usuario que debe registrarse -->
    <div class="modal fade" id="registrationAlertModal" tabindex="-1" aria-labelledby="registrationAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationAlertModalLabel">Registro Requerido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Debes registrarte para obtener más información sobre las películas.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="registro_acceso.php" class="btn btn-primary">Registrar Ahora</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JavaScript y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const descriptionButtons = document.querySelectorAll('.btn-description');

        descriptionButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                // Evitar la acción predeterminada si el usuario no está registrado
                <?php if (!isset($_SESSION['user_id'])): ?>
                    event.preventDefault(); // Prevenir la acción por defecto del botón
                    const registrationAlertModal = new bootstrap.Modal(document.getElementById('registrationAlertModal'));
                    registrationAlertModal.show();
                <?php endif; ?>
            });
        });
    });
</script>
</body>
</html>

<?php
include("includes/footer.php");
?>



















                       




