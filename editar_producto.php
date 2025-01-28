<?php
session_start();
$username_post = $_SESSION["usuario"];
include 'config.php'; // Incluimos el archivo de configuración
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'head.php'; ?>
</head>

<body>

    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="inicio.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">Tec Market Demo</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <?php
                        $conn = new mysqli($servername, $username, $password, $database, $port);
                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }
                        $nombreusuario = $username_post;
                        $sql = "SELECT * FROM `users` WHERE username='$nombreusuario';";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<img class="rounded-circle" src="' . $row["fotografia"] . '" alt="" style="width: 40px; height: 40px;">';
                            }
                        } else {
                            echo "0 resultados";
                        }
                        $conn->close();
                        ?>
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <?php
                        include 'config.php';
                        $conn = new mysqli($servername, $username, $password, $database, $port);
                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }
                        $nombreusuario = $username_post;
                        $sql = "SELECT * FROM `users` WHERE username='$nombreusuario';";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo'<h6 class="mb-0">' . $row["nombre"] . '</h6>';
                                echo'<span>' . $row["cargo"] . '</span>';
                            }
                        } else {
                            echo "0 resultados";
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <?php include 'contenidoopciones.php'; ?>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include 'Navbar.php'; ?>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <?php
// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del producto desde la URL
$id_producto = $_GET['id'];

// Consulta para obtener los datos del producto
$sql = "SELECT p.id, d.codigo, d.Empaque, e.nombre AS nombre_empaque, d.Categoria, c.nombre AS nombre_categoria, d.Unidades, u.nombre AS nombre_unidades, d.nombre, d.peso, p.detalle_bodega_id, p.stock, p.fechaVencimiento, p.precioCompra, p.precioVenta, p.ganancia 
        FROM productos p 
        JOIN detalle_producto d ON p.detalle_producto_id = d.id 
        JOIN empaque e ON d.Empaque = e.codigo 
        JOIN unidades u ON d.Unidades = u.codigo 
        JOIN categoria c ON d.Categoria = c.codigo 
        WHERE p.id = '$id_producto'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Producto no encontrado.";
    exit;
}
?>

<!-- Formulario de edición del producto -->
<div class="bg-light rounded h-100 p-4">
    <h3 class="text-center mb-4">Editar Producto</h3>

    <form action="guardar_edicion.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<div class="mb-3">
    <label for="codigo" class="form-label">Código</label>
    <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $row['codigo']; ?>" readonly>
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" readonly>
</div>
<div class="mb-3">
    <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
    <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento" value="<?php echo $row['fechaVencimiento']; ?>" readonly>
</div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $row['stock']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre_categoria']; ?>" readonly>

        </div>

        <div class="mb-3">
            <label for="peso" class="form-label">Peso</label>
            <input type="text" class="form-control" id="peso" name="peso" value="<?php echo $row['peso']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="precioCompra" class="form-label">Precio de Compra</label>
            <input type="number" class="form-control" id="precioCompra" name="precioCompra" value="<?php echo $row['precioCompra']; ?>" step="0.01" required oninput="calcularGanancia()">
        </div>

        <div class="mb-3">
            <label for="precioVenta" class="form-label">Precio de Venta</label>
            <input type="number" class="form-control" id="precioVenta" name="precioVenta" value="<?php echo $row['precioVenta']; ?>" step="0.01" required oninput="calcularGanancia()">
        </div>

        <div class="mb-3">
            <label for="ganancia" class="form-label">Ganancia</label>
            <input type="number" class="form-control" id="ganancia" name="ganancia" value="<?php echo $row['ganancia']; ?>" step="0.01" readonly>
        </div>

        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="productos.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    // Función para calcular la ganancia
    function calcularGanancia() {
        var precioCompra = parseFloat(document.getElementById("precioCompra").value) || 0;
        var precioVenta = parseFloat(document.getElementById("precioVenta").value) || 0;
        
        // Calcular ganancia como la diferencia
        var ganancia = precioVenta - precioCompra;
        
        // Mostrar la ganancia calculada en el campo correspondiente
        document.getElementById("ganancia").value = ganancia.toFixed(2);
    }
</script>

<?php
// Cerrar la conexión
$conn->close();
?>


                    </div>
                </div>
            </div>
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
