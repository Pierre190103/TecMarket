<?php
session_start();

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "scanmarket";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database, "3306");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $username_post = $_POST["username"];
    $password_post = $_POST["password"];

    // Consulta SQL para verificar el usuario y contraseña
    $sql = "SELECT * FROM users WHERE username = '$username_post' AND password = '$password_post'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["usuario"] = $username_post;
        // Usuario y contraseña correctos
        $row = $result->fetch_assoc();
        if ($row["cargo"] == "Administrador") {
            // Si es administrador, redirigir a inicio.php con la variable usuario y detalle
            $username_post = urlencode($username_post); // Para evitar problemas con caracteres especiales en la URL
            // Realizar una consulta para obtener el valor de detalle
            $sql_detalle = "SELECT bodega_detalle_id FROM users WHERE username = '$username_post'";
            $result_detalle = $conn->query($sql_detalle);

            if ($result_detalle->num_rows > 0) {
                $row_detalle = $result_detalle->fetch_assoc();
                $detalle = urlencode($row_detalle["bodega_detalle_id"]);
                header("Location: dashboard.php");
                exit();
            } else {
                // Si no se encuentra el detalle, redirigir sin él
                $error_message = 'Usuario Restringido';
            }
        } elseif ($row["cargo"] == "Empleado") {
            // Si es administrador, redirigir a inicio.php con la variable usuario y detalle
            $username_post = urlencode($username_post); // Para evitar problemas con caracteres especiales en la URL
            // Realizar una consulta para obtener el valor de detalle
            $sql_detalle = "SELECT bodega_detalle_id FROM users WHERE username = '$username_post'";
            $result_detalle = $conn->query($sql_detalle);

            $row_detalle = $result_detalle->fetch_assoc();
            $detalle = urlencode($row_detalle["bodega_detalle_id"]);
            header("Location: inicio.php");
            exit();
        } else {
            // Rol no reconocido
            $error_message = 'Usuario Restringido';
        }
    } else {
        // Usuario o contraseña incorrectos
        $error_message = 'Nombre de usuario o contraseña incorrectos.';
    }
}

// Cerrar conexión
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'Cargando.php'; ?>
<div class="container-fluid position-relative bg-white d-flex p-0">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="img2/Logo_Unico.png" alt="Logo" width="150">
                    </div>
                    <div class="card-body">
                        <?php
                        if (!empty($error_message)) {
                            echo '<h6 style="color: red;">' . $error_message . '</h6>';
                        }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" class="form-control" id="username" name="username" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                        </form>
                        <div class="text-center mt-3">
                            ¿Necesitas ayuda? <a href="mailto:scanmarket.soporte@gmail.com?subject=Soporte%20Cambio%20Contraseña&amp;body=Cambio%20de%20contraseña%20para%20usuario">Contacta con soporte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
