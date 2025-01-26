<?php
session_start();
$username_post = $_SESSION["usuario"];
include 'config.php'; // Incluimos el archivo de configuración
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include 'head.php'; ?>
        <style>
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }
            .scanner-window {
                position: relative;
                width: 80%;
                max-width: 500px;
                height: 60%;
                background: #fff;
                border-radius: 8px;
                overflow: hidden;
            }
            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background: red;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 50%;
                cursor: pointer;
            }
            #scanner-container {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid position-relative bg-white d-flex p-0">

            <?php include 'Cargando.php'; ?>

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
                        <div class="col-12">
                            <div class="bg-light text-center rounded p-4">
                                <h4 class="mb-4">Agregar Producto</h4>
                                <form action="subir_producto.php" method="POST">
                                    <div class="mb-3 text-start">
                                        <div class="form-floating mb-3">
    <select class="form-select" id="detalleProductoId" name="detalleProductoId" required>
        <option value="" disabled selected>Seleccione un producto</option>
        <?php
        // Conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $database, $port);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta de productos
        $sqlProductos = "SELECT id, nombre FROM detalle_producto";
        $resultadoProductos = $conn->query($sqlProductos);
        if ($resultadoProductos->num_rows > 0) {
            while ($fila = $resultadoProductos->fetch_assoc()) {
                echo "<option value='" . $fila['id'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
            }
        } else {
            echo "<option value='' disabled>No hay productos disponibles</option>";
        }
        ?>
    </select>
    <label for="detalleProductoId">Nombre Producto</label>
</div>

                                        <div class="mb-3 text-start">
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Ingrese la cantidad en stock" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
                                            <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento">
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label for="precioCompra" class="form-label">Precio de Compra</label>
                                            <input type="number" step="0.01" class="form-control" id="precioCompra" name="precioCompra" placeholder="Ingrese el precio de compra" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label for="precioVenta" class="form-label">Precio de Venta</label>
                                            <input type="number" step="0.01" class="form-control" id="precioVenta" name="precioVenta" placeholder="Ingrese el precio de venta" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label for="ganancia" class="form-label">Ganancia</label>
                                            <input type="number" step="0.01" class="form-control" id="ganancia" name="ganancia" placeholder="Ganancia calculada automáticamente" readonly>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label for="detalleBodegaId" class="form-label">Detalle Bodega</label>
                                            <select class="form-control" id="detalleBodegaId" name="detalleBodegaId" required>
                                                <option value="" disabled selected>Seleccione una bodega</option>
                                                <?php
                                                // Consulta de bodegas
                                                if (!isset($nombreusuario)) {
                                                    $nombreusuario = $_SESSION['username'] ?? '';
                                                }
                                                $sqlBodegas = "SELECT detalle_bodega.id, detalle_bodega.nombre_bodega 
                                           FROM detalle_bodega 
                                           INNER JOIN users 
                                           ON detalle_bodega.id = users.bodega_detalle_id 
                                           WHERE users.username = ?";
                                                $stmtBodegas = $conn->prepare($sqlBodegas);
                                                $stmtBodegas->bind_param("s", $nombreusuario);
                                                $stmtBodegas->execute();
                                                $resultadoBodegas = $stmtBodegas->get_result();
                                                if ($resultadoBodegas->num_rows > 0) {
                                                    while ($fila = $resultadoBodegas->fetch_assoc()) {
                                                        echo "<option value='" . $fila['id'] . "'>" . htmlspecialchars($fila['nombre_bodega']) . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value='' disabled>No hay bodegas disponibles</option>";
                                                }
                                                $conn->close();
                                                ?>
                                            </select>
                                        </div>


                                        <button type="submit" class="btn btn-primary">Agregar Producto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <script src="https://unpkg.com/quagga/dist/quagga.min.js"></script>
                <script>
                    let currentButton = null;

                    function openScanner(button) {
                        currentButton = button;
                        document.getElementById('scanner-overlay').style.display = 'flex';

                        Quagga.init({
                            inputStream: {
                                name: "Live",
                                type: "LiveStream",
                                target: document.querySelector('#scanner-container'),
                                constraints: {
                                    facingMode: "environment" // Usa la cámara trasera
                                }
                            },
                            decoder: {
                                readers: ["code_128_reader", "ean_reader", "ean_8_reader"]
                            }
                        }, function (err) {
                            if (err) {
                                console.error(err);
                                return;
                            }
                            Quagga.start();
                        });

                        Quagga.onDetected(function (result) {
                            const code = result.codeResult.code;
                            if (code) {
                                // Aquí es donde se pasa el valor al input
                                const inputField = document.getElementById('codigo'); // Selecciona el campo de entrada
                                inputField.value = code; // Escribe el código en el campo
                                closeScanner();
                            }
                        });
                    }

                    function closeScanner() {
                        Quagga.stop();
                        document.getElementById('scanner-overlay').style.display = 'none';
                    }
                    function fetchProductByCode(code) {
                        // Verifica si el código tiene 13 dígitos
                        if (code.length === 13) {
                            fetch('buscar_producto.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({codigo: code})
                            })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            document.getElementById('nombre').value = data.nombre; // Asigna el nombre del producto
                                        } else {
                                            document.getElementById('nombre').value = 'No se encontró';
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                        } else {
                            document.getElementById('nombre').value = 'Código inválido';
                        }
                    }
                </script>


                <script>
                    // Calcular la ganancia automáticamente
                    document.getElementById("precioVenta").addEventListener("input", calcularGanancia);
                    document.getElementById("precioCompra").addEventListener("input", calcularGanancia);

                    function calcularGanancia() {
                        const precioCompra = parseFloat(document.getElementById("precioCompra").value) || 0;
                        const precioVenta = parseFloat(document.getElementById("precioVenta").value) || 0;
                        const ganancia = precioVenta - precioCompra;
                        document.getElementById("ganancia").value = ganancia.toFixed(2);
                    }
                </script>




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