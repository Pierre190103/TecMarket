

<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="inicio.php" class="navbar-brand d-flex d-lg-none me-4">
        <img class="rounded flex-shrink-0 me-3" src="img/Logo_Unico.png" alt="Producto 1" style="width: 40px; height: 40px;">
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    <form class="d-none d-md-flex ms-4" action="Buscar.php" method="GET">
        <input id="busquedaInput" class="form-control border-0" type="search" name="busqueda" placeholder="Buscar">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <script>
    document.getElementById('busquedaInput').addEventListener('input', function() {
        if (this.value.length === 13) {
            // Envía el formulario automáticamente cuando se ingresan 13 dígitos
            this.parentNode.submit();
        }
    });
</script>





    <div class="navbar-nav align-items-center ms-auto">

        <div class="nav-item dropdown">



            <?php
            include 'config.php';

            $conn = new mysqli($servername, $username, $password, $database, $port);
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $sql = "SELECT SUM(precio) AS suma_precios FROM carrito WHERE trabajador = '$nombreusuario';";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {


                    echo '<span class="d-none d-lg-inline-flex">Total: S/ ' . $row["suma_precios"] . '</span>';
                }
            } else {
                echo '<span>Total: S/ 0</span>';
            }
            $conn->close();
            ?>

        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
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

                        echo '<img class="rounded-circle me-lg-2" src="' . $row["fotografia"] . '" alt="" style="width: 40px; height: 40px;">';
                        echo '<span class="d-none d-lg-inline-flex">' . $row["nombre"] . '</span>';
                    }
                } else {
                    echo "0 resultados";
                }
                $conn->close();
                ?>

            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">Mi Perfil</a>
                <a href="#" class="dropdown-item">Configuración</a>
                <a href="#" class="dropdown-item">Agregar</a>
                <a href="cerrar.php" class="dropdown-item" >Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>
