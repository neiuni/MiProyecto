<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Mi Proyecto</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Maps Embed API -->
    <style>
        /* Estilo para el contenedor del mapa */
        #map {
            height: 400px;
            width: 100%;
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="accesoinicio.php">Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="generos.php">Géneros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registro_acceso.php">Acceso</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h2>Contacto</h2>
                <p>Si tienes alguna pregunta, no dudes en ponerte en contacto con nosotros a través del siguiente formulario:</p>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Tu mensaje" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
            <div class="col-lg-6">
                <h2>Encuéntranos</h2>
                <p>Cebanc, San Sebastián</p>
                <!-- Google Maps Embed API -->
                <div id="map" class="mb-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5806.91369557685!2d-2.0194686233610186!3d43.30469507490066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd51b0708baa02bb%3A0x4b55a087d653821b!2sCebanc!5e0!3m2!1ses!2ses!4v1721642957961!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                     
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Mi Proyecto 2024</h5>
                    <p>
                        Bienvenido a nuestro sitio web. Aquí puedes encontrar la mejor colección de películas, descubrir nuevos géneros y mantenerte actualizado con nuestras novedades.
                    </p>
                    <p class="mb-0">&copy; 2024 Mi Proyecto. Todos los derechos reservados.</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white text-decoration-none">Inicio</a></li>
                        <li><a href="peliculas.php" class="text-white text-decoration-none">Películas</a></li>
                        <li><a href="generos.php" class="text-white text-decoration-none">Géneros</a></li>
                        <li><a href="contacto.php" class="text-white text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Síguenos</h5>
                    <a href="#" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-dark">
            <p class="mb-0">© 2024 Mi Proyecto. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JavaScript y Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>

