<?php
session_start();
require 'db.php'; // Asegúrate de que este archivo se conecta a la base de datos 'mispeliculas'
include ("public/index.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Verificar si el correo electrónico está registrado
    $query = "SELECT * FROM Usuarios WHERE mail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['email'] = $user['mail'];
            header("Location: lista_peliculas2.php");
            exit();
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Contraseña incorrecta.</div>';
        }
    } else {
        $alert = '<div class="alert alert-warning" role="alert">El correo electrónico no está registrado.</div>';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Acceso</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Acceso</h3>
                        <?php if (isset($alert)) echo $alert; ?>
                        <form method="POST" action="registro_acceso.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Acceder</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="accesoinicio.php" class="small">¿Olvidaste contraseña?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>















