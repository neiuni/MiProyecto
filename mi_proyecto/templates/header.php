<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Mis peliculas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="directors.php">Directores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="actors.php">Actores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reviews.php">Votaciones</a>
            </li>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Acceso</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Registro</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
