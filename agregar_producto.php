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

            <?php include 'Cargando.php'; ?>

            <!-- Sidebar Start -->
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    
                    <a href="inicio.php?usuario=<?php echo urlencode($nombreusuario); ?>&detalle=<?php echo urlencode($nombredetalle); ?>" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary">Scan Market Demo</h3>
                    </a>
                    <div class="d-flex align-items-center ms-4 mb-4">
                        <div class="position-relative">
                            <img class="rounded-circle" src="img/Perfil.jpg" alt="" style="width: 40px; height: 40px;">
                            <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                        </div>
                        <div class="ms-3">
                            <?php
                            include 'config.php';
                            $conn = new mysqli($servername, $username, $password, $database);
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            $nombreusuario = $_REQUEST ["usuario"];
                            $nombredetalle = $_REQUEST ["detalle"];
                            $sql = "SELECT * FROM `users` WHERE username='$nombreusuario' AND bodega_detalle_id ='$nombredetalle';";

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
                        <a href="inicio.php?usuario=<?php echo urlencode($nombreusuario); ?>&detalle=<?php echo urlencode($nombredetalle); ?>" class="nav-item nav-link"><i class="fas fa-tags me-2"></i>Todo</a>
                        <?php
                        include 'config.php';

                        $conn = new mysqli($servername, $username, $password, $database);
                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }

                        $nombreusuario = $_REQUEST["usuario"];
                        $nombredetalle = $_REQUEST["detalle"];

                        $sql = "SELECT * FROM categoria;";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $codigo_categoria = $row["codigo"];
                                $nombre_categoria = $row["nombre"];
                                $link = 'Catalogo.php?codigo=' . $codigo_categoria . '&usuario=' . urlencode($nombreusuario) . '&detalle=' . urlencode($nombredetalle);

                                // Si la categoría es 0, mostramos todos los productos
                                if ($codigo_categoria == 0) {
                                    $link = 'inicio.php?usuario=' . urlencode($nombreusuario) . '&detalle=' . urlencode($nombredetalle); // Mostrar todos los productos
                                }

                                echo '<a href="' . $link . '" class="nav-item nav-link"><i class="fas fa-tags me-2"></i>' . $nombre_categoria . '</a>';
                            }
                        } else {
                            echo "0 resultados";
                        }
                        $conn->close();
                        ?>


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
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-6">
                            <div class="bg-light text-center rounded p-4">
                               
                            </div>
                        </div>

                        
                    </div>
                </div>

            </div>





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