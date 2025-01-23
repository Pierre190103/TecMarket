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
        <?php include 'Cargando.php'; ?>

        <div class="container-fluid position-relative bg-white d-flex p-0">


            <!-- Sidebar Start -->
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    <a href="inicio.php" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary">Scan Market Demo</h3>
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
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">

        <!-- Navbar Start -->
        <?php include 'Navbar.php'; ?>

        <!-- Navbar End -->








        <!-- Widgets Start -->
        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-line fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Categorias</p>
                            <?php
                            include 'config.php';
                            $conn = new mysqli($servername, $username, $password, $database);
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            $sql = "SELECT COUNT(DISTINCT d.Categoria) AS total_categorias
FROM productos p
JOIN detalle_producto d ON p.detalle_producto_id = d.id
JOIN empaque e ON d.Empaque = e.codigo
JOIN unidades u ON d.Unidades = u.codigo
WHERE p.detalle_bodega_id = (
    SELECT bodega_detalle_id
    FROM users
    WHERE username = '$username_post'
);

";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    echo ' <h6 class="mb-0">' . $row["total_categorias"] . '</h6>';
                                }
                            } else {
                                
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-bar fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Productos</p>
                            <?php
                            include 'config.php';
                            $conn = new mysqli($servername, $username, $password, $database);
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            $sql = "SELECT COUNT(*) AS total_productos
FROM productos p
JOIN detalle_producto d ON p.detalle_producto_id = d.id
JOIN empaque e ON d.Empaque = e.codigo
JOIN unidades u ON d.Unidades = u.codigo
WHERE p.detalle_bodega_id = (
    SELECT bodega_detalle_id
    FROM users
    WHERE username = '$username_post'
);
";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    echo ' <h6 class="mb-0">' . $row["total_productos"] . '</h6>';
                                }
                            } else {
                                
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-area fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Ingresos</p>
                            <h6 class="mb-0">s/ 3000</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-pie fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Egresos</p>
                            <h6 class="mb-0">s/ 3000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sale & Revenue End -->


        <!-- Sales Chart Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Ventas</h6>
                            <a href="">Actualizar</a>
                        </div>
                        <canvas id="worldwide-sales"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Clientes</h6>
                            <a href="">Actualizar</a>
                        </div>
                        <canvas id="salse-revenue"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sales Chart End -->


        <!-- Recent Sales Start -->
<!--        <div class="container-fluid pt-4 px-4">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Recent Salse</h6>
                    <a href="">Show All</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                <th scope="col">Date</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>01 Jan 2045</td>
                                <td>INV-0123</td>
                                <td>Jhon Doe</td>
                                <td>$123</td>
                                <td>Paid</td>
                                <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>01 Jan 2045</td>
                                <td>INV-0123</td>
                                <td>Jhon Doe</td>
                                <td>$123</td>
                                <td>Paid</td>
                                <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>01 Jan 2045</td>
                                <td>INV-0123</td>
                                <td>Jhon Doe</td>
                                <td>$123</td>
                                <td>Paid</td>
                                <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>01 Jan 2045</td>
                                <td>INV-0123</td>
                                <td>Jhon Doe</td>
                                <td>$123</td>
                                <td>Paid</td>
                                <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" type="checkbox"></td>
                                <td>01 Jan 2045</td>
                                <td>INV-0123</td>
                                <td>Jhon Doe</td>
                                <td>$123</td>
                                <td>Paid</td>
                                <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>-->
        <!-- Recent Sales End -->



    </div>





    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib2/chart/chart.min.js"></script>
<script src="lib2/easing/easing.min.js"></script>
<script src="lib2/waypoints/waypoints.min.js"></script>
<script src="lib2/owlcarousel/owl.carousel.min.js"></script>
<script src="lib2/tempusdominus/js/moment.min.js"></script>
<script src="lib2/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib2/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="js2/main.js"></script>
</body>

</html>