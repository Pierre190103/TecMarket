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
                        <h6 class="mb-4">Responsive Table</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Codigo Barras</th>
                                        <th scope="col">Nombre Producto</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Unidades</th>
                                        <th scope="col">Precio Compra</th>
                                        <th scope="col">Precio Venta</th>
                                        <th scope="col">Ganancia</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                               <tbody>
    <?php
    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database, $port);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para obtener los datos de la base de datos
    $sql = "SELECT p.id, d.codigo, d.Empaque, e.nombre AS nombre_empaque, d.Categoria, c.nombre AS nombre_categoria, d.Unidades, u.nombre AS nombre_unidades, d.nombre, d.peso, p.detalle_bodega_id, p.stock, p.fechaVencimiento, p.precioCompra, p.precioVenta, p.ganancia FROM productos p JOIN detalle_producto d ON p.detalle_producto_id = d.id JOIN empaque e ON d.Empaque = e.codigo JOIN unidades u ON d.Unidades = u.codigo JOIN categoria c ON d.Categoria = c.codigo WHERE p.detalle_bodega_id = ( SELECT bodega_detalle_id FROM users WHERE username = '$username_post' );";

    // Ejecutar consulta
    $result = $conn->query($sql);

    // Verificar si la consulta fue exitosa
    if ($result === false) {
        // Si hay un error en la consulta, mostrar el error
        die("Error en la consulta: " . $conn->error);
    }

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        // Muestra cada fila de resultados
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <th scope='row'>" . $row["id"] . "</th>
                <td>" . $row["codigo"] . "</td>
                <td>" . $row["nombre"] . "</td>
                <td>" . $row["stock"] . " " . $row["nombre_empaque"] . "</td>
                <td>" . $row["nombre_categoria"] . "</td>
                <td>" . $row["peso"] . " " . $row["nombre_unidades"] . "</td>
                <td>" . $row["precioCompra"] . "</td>
                <td>" . $row["precioVenta"] . "</td>
                <td>" . $row["ganancia"] . "</td>
                <td>
                    <a href='editar_producto.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Editar</a>
                    <a href='eliminar_producto.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
    }

    // Cerrar la conexión
    $conn->close();
    ?>
</tbody>

                            </table>
                        </div>
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
