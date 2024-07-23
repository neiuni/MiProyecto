<?php
session_start();
include 'includes/config.php';

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'A') {
    // header('Location: login.php');
    // exit;
}

// Consultar películas y usuarios
$sql_peliculas = "SELECT * FROM peliculas";
$result_peliculas = mysqli_query($conpel, $sql_peliculas);

$sql_usuarios = "SELECT * FROM Usuarios";
$result_usuarios = mysqli_query($conpel, $sql_usuarios);

// Obtener el nombre del usuario desde la sesión
$nombre_usuario = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Invitado';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Películas y Usuarios</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Estilo para el sidebar */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            z-index: 100; /* Asegura que el sidebar esté sobre el contenido */
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        /* Estilo para los botones en el panel de control */
        .sidebar .btn-sm {
            margin-left: 5px;
        }

        /* Asegurarse de que las imágenes del poster no se estiren */
        .img-thumbnail {
            max-width: 100px;
            height: auto;
        }

        /* Opcional: estilos adicionales para mejorar la presentación */
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Barra Lateral -->
    <div class="sidebar">
        <div class="card mb-4">
            <div class="card-header">
                Panel de Control
            </div>
            <ul class="nav flex-column">
                <!-- Menú desplegable para películas -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#peliculasMenu" aria-expanded="false" aria-controls="peliculasMenu">
                        Películas
                        <span class="ms-auto">
                            <i class="bi bi-caret-down-fill"></i>
                        </span>
                    </a>
                    <div class="collapse" id="peliculasMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="activas">Activas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="noActivas">No Activas</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Menú desplegable para usuarios -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#usuariosMenu" aria-expanded="false" aria-controls="usuariosMenu">
                        Usuarios
                        <span class="ms-auto">
                            <i class="bi bi-caret-down-fill"></i>
                        </span>
                    </a>
                    <div class="collapse" id="usuariosMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="mostrarUsuarios">Lista de Usuarios</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Estadísticas</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content">
        <!-- Barra de Navegación -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="#">MiPelículas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Películas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Estadísticas</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white">Bienvenido, <?php echo $nombre_usuario; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="logout.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenido Dinámico -->
        <div id="contenido">
            <h1 class="mb-4">Lista de Películas</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Estreno</th>
                            <th>Poster</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result_peliculas) > 0) {
                            while ($row = mysqli_fetch_assoc($result_peliculas)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["titulo"]) . "</td>";
                                echo "<td>" . ($row["estado"] == 'A' ? 'Activo' : ($row["estado"] == 'D' ? 'Desactivado' : 'Borrado')) . "</td>";
                                echo "<td>" . htmlspecialchars($row["estreno"]) . "</td>";
                                echo "<td><img src='" . $tmdb_ruta_poster . "/" . htmlspecialchars($row["poster"]) . "' alt='" . htmlspecialchars($row["titulo"]) . "' class='img-thumbnail'></td>";
                                echo "<td>";
                                echo "<form action='update_status.php' method='POST'>";
                                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>";
                                echo "<input type='hidden' name='type' value='pelicula'>";
                                if ($row["estado"] == 'A') {
                                    echo "<button type='submit' name='action' value='desactivar' class='btn btn-warning btn-sm'>Desactivar</button>";
                                } else {
                                    echo "<button type='submit' name='action' value='activar' class='btn btn-success btn-sm'>Activar</button>";
                                }
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No hay películas disponibles.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="usuarios" style="display: none;">
            <h1 class="mb-4">Lista de Usuarios</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result_usuarios) > 0) {
                            while ($row = mysqli_fetch_assoc($result_usuarios)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["mail"]) . "</td>";
                                echo "<td>" . ($row["rol"] == 'A' ? 'Admin' : 'Usuario') . "</td>";
                                echo "<td>" . ($row["estado"] == 'A' ? 'Activo' : ($row["estado"] == 'D' ? 'Desactivado' : 'Borrado')) . "</td>";
                                echo "<td>" . htmlspecialchars($row["fecha_registro"]) . "</td>";
                                echo "<td>";
                                echo "<form action='update_status.php' method='POST'>";
                                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>";
                                echo "<input type='hidden' name='type' value='usuario'>";
                                if ($row["estado"] == 'A') {
                                    echo "<button type='submit' name='action' value='desactivar' class='btn btn-warning btn-sm'>Desactivar</button>";
                                } else if ($row["estado"] == 'D') {
                                    echo "<button type='submit' name='action' value='activar' class='btn btn-success btn-sm'>Activar</button>";
                                    echo "<button type='submit' name='action' value='borrar' class='btn btn-danger btn-sm'>Borrar</button>";
                                } else {
                                    echo "<button type='submit' name='action' value='activar' class='btn btn-success btn-sm'>Activar</button>";
                                }
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No hay usuarios disponibles.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var contenido = document.getElementById('contenido');
            var usuarios = document.getElementById('usuarios');

            document.getElementById('activas').addEventListener('click', function() {
                contenido.style.display = 'block';
                usuarios.style.display = 'none';
            });

            document.getElementById('noActivas').addEventListener('click', function() {
                contenido.style.display = 'block';
                usuarios.style.display = 'none';
            });

            document.getElementById('mostrarUsuarios').addEventListener('click', function() {
                contenido.style.display = 'none';
                usuarios.style.display = 'block';
            });
        });
    </script>
</body>
</html>

<?php
// Cerrar conexión
mysqli_close($conpel);
?>


    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>



      


