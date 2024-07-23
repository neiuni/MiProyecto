<?php
session_start();
require 'db.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    // Conexión a la base de datos
    $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conexion->connect_error) {
        die("La conexión ha fallado: " . $conexion->connect_error);
    }

    // Consultar el usuario
    $sql = "SELECT id, nombre, password FROM Usuarios WHERE mail = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $nombre, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Iniciar sesión
            $_SESSION['user_id'] = $id;
            $_SESSION['nombre'] = $nombre;
            header("Location: mi_lista_peliculas.php");
            exit();
        } else {
            $error = "Credenciales incorrectas";
        }
    } else {
        $error = "Credenciales incorrectas";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="mail" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="mail" name="mail" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>





