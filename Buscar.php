<?php
session_start();
$username_post = $_SESSION["usuario"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'head.php'; ?>
    </head>
    <body>
        <div class="container-fluid position-relative bg-white d-flex p-0">
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    <a href="inicio.php" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary">Click Bodega Demo</h3>
                    </a>
                    <div class="d-flex align-items-center ms-4 mb-4">
                        <div class="position-relative">
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
            <div class="content">
                <?php include 'Navbar.php'; ?>
                <div class="container-fluid pt-4 px-4">
                    <div class="bg-light text-center rounded p-4">
                        <div class="m-n2">
                            <?php
                            include 'config.php';
                            $conn = new mysqli($servername, $username, $password, $database, $port);
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            $nombreusuario = $username_post;
                            $sql = "SELECT DISTINCT c.codigo AS categoria_id, c.nombre AS nombre_categoria 
                                    FROM productos p 
                                    JOIN detalle_producto d ON p.detalle_producto_id = d.id 
                                    JOIN categoria c ON d.Categoria = c.codigo 
                                    WHERE p.detalle_bodega_id = (SELECT bodega_detalle_id FROM users WHERE username = '$nombreusuario')";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $codigo_categoria = $row["categoria_id"];
                                    $nombre_categoria = $row["nombre_categoria"];
                                    $link = 'Catalogo.php?codigo=' . $codigo_categoria;
                                    if ($codigo_categoria == 0) {
                                        $link = 'inicio.php';
                                    }
                                    echo'<a type="button" href="' . $link . '" class="btn btn-primary m-2">' . $nombre_categoria . '</a>';
                                }
                            } else {
                                echo "0 resultados";
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="container-fluid pt-4 px-4">
                    <?php
                    if (isset($_GET['busqueda'])) {
                        include 'config.php';
                        $conexion = new mysqli($servername, $username, $password, $database);
                        if ($conexion->connect_error) {
                            die("Error en la conexión: " . $conexion->connect_error);
                        }
                        $busqueda = $conexion->real_escape_string($_GET['busqueda']);
                        $consulta = "SELECT 
                                    p.id, 
                                    d.codigo, 
                                    d.Empaque, 
                                    e.nombre AS nombre_empaque, 
                                    d.Categoria, 
                                    d.Unidades, 
                                    u.nombre AS nombre_unidades, 
                                    d.nombre, 
                                    d.peso, 
                                    p.detalle_bodega_id, 
                                    p.stock, 
                                    p.fechaVencimiento, 
                                    p.precioCompra, 
                                    p.precioVenta, 
                                    p.ganancia 
                                FROM 
                                    productos p 
                                JOIN 
                                    detalle_producto d ON p.detalle_producto_id = d.id 
                                JOIN 
                                    empaque e ON d.Empaque = e.codigo 
                                JOIN 
                                    unidades u ON d.Unidades = u.codigo 
                                WHERE 
                                    p.detalle_bodega_id = ( 
                                        SELECT 
                                            bodega_detalle_id 
                                        FROM 
                                            users 
                                        WHERE 
                                            username = '$username_post'
                                    )
                                    AND d.codigo = '$busqueda';";
                        $resultado = $conexion->query($consulta);
                        if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<div class="d-flex align-items-center border-bottom py-3">';
                                echo '     <img class="rounded flex-shrink-0 me-3" src="img/9284424.png" alt="Producto" style="width: 80px; height: 80px;">';
                                echo '     <div class="w-100">';
                                echo '         <div class="d-flex w-100 justify-content-between">';
                                echo '             <h6 class="mb-0">' . $row["nombre"] . '</h6>';
                                echo '             <span class="text-muted">S/ ' . $row["precioVenta"] . '</span>';
                                echo '         </div>';
                                echo '         <p class="mb-0">' . $row["nombre_empaque"] . ' de ' . $row["peso"] . ' ' . $row["nombre_unidades"] . ' Stock Disponible: ' . $row["stock"] . '</p>';
                                echo '         <form method="post" action="agregar_carrito.php">';
                                echo '             <input type="hidden" name="codigo_categoria" value="' . $row["Categoria"] . '">';
                                echo '             <input type="hidden" name="id" value="' . $row["id"] . '">';
                                echo '             <input type="hidden" name="cantidad" value="1">'; // Por defecto, la cantidad es 1
                                echo '             <input type="hidden" name="precioVenta" value="' . $row["precioVenta"] . '">';
                                echo '             <button type="submit" class="btn btn-primary btn-sm mt-2">Agregar al carrito</button>';
                                echo '         </form>';
                                echo '     </div>';
                                echo ' </div>';
                            }
                        } else {
                            echo "<p>No se encontraron resultados.</p>";
                        }
                        $conexion->close();
                    } else {
                        echo "<p>No se ha realizado una búsqueda.</p>";
                    }
                    ?>
                </div>
            </div>
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>