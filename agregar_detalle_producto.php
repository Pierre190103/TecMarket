<?php
session_start();
$username_post = $_SESSION["usuario"];
include 'config.php';
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
            <div class="content">
                <?php include 'Navbar.php'; ?>
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="bg-light text-center rounded p-4">
                                <h4 class="mb-4">Nuevo Producto</h4>
                                <form action="subir_detalle_producto.php" method="POST">
                                    <div class="mb-3 text-start">
                                        <label for="codigo" class="form-label">Código de Barras</label>
                                        <div class="input-group">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="codigo" 
                                                name="codigo" 
                                                placeholder="Ingrese código de barras" 
                                                required
                                                />
                                            <button 
                                                class="btn btn-primary scan-btn" 
                                                type="button" 
                                                onclick="openScanner(this)">
                                                Escanear
                                            </button>
                                        </div>
                                    </div>
                                    <div class="overlay" id="scanner-overlay" style="display: none;">
                                        <div class="scanner-window">
                                            <button class="close-btn btn btn-danger" onclick="closeScanner()">X</button>
                                            <div id="scanner-container"></div>
                                        </div>
                                    </div>
                                    <div class="overlay" id="scanner-overlay">
                                        <div class="scanner-window">
                                            <button class="close-btn" onclick="closeScanner()">X</button>
                                            <div id="scanner-container"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label for="nombe" class="form-label">nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="stock" placeholder="Ingrese la cantidad en stock" required>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label for="detalleEmpaqueId" class="form-label">Tipo de Empaque</label>
                                        <select class="form-control" id="detalleEmpaqueId" name="detalleEmpaqueId" required>
                                            <option value="" disabled selected>Seleccione Empaque</option>
                                            <?php
                                            $conn = new mysqli($servername, $username, $password, $database, $port);
                                            if ($conn->connect_error) {
                                                die("Conexión fallida: " . $conn->connect_error);
                                            }
                                            $sqlProductos = "SELECT codigo, nombre FROM empaque";
                                            $resultadoProductos = $conn->query($sqlProductos);
                                            if ($resultadoProductos->num_rows > 0) {
                                                while ($fila = $resultadoProductos->fetch_assoc()) {
                                                    echo "<option value='" . $fila['codigo'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value='' disabled>No hay productos disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label for="peso" class="form-label">Peso</label>
                                        <input type="number" class="form-control" id="peso" name="peso" placeholder="Ingrese el peso del producto" required>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label for="unidadId" class="form-label">Unidades</label>
                                        <select class="form-control" id="unidadId" name="unidadId" required>
                                            <option value="" disabled selected>Seleccione una unidad</option>
                                            <?php
                                            $sqlUnidades = "SELECT codigo, nombre FROM unidades";
                                            $resultadoUnidades = $conn->query($sqlUnidades);
                                            if ($resultadoUnidades->num_rows > 0) {
                                                while ($fila = $resultadoUnidades->fetch_assoc()) {
                                                    echo "<option value='" . $fila['codigo'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value='' disabled>No hay unidades disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label for="unidadId" class="form-label">Categoria</label>
                                        <select class="form-control" id="categoriaID" name="categoriaID" required>
                                            <option value="" disabled selected>Seleccione una categoria</option>
                                            <?php
                                            // Consulta directa a la tabla unidades
                                            $sqlCategorias = "SELECT codigo, nombre FROM categoria";
                                            $resultadoCategorias = $conn->query($sqlCategorias);
                                            if ($resultadoCategorias->num_rows > 0) {
                                                while ($fila = $resultadoUnidades->fetch_assoc()) {
                                                    echo "<option value='" . $fila['codigo'] . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value='' disabled>No hay unidades disponibles</option>";
                                            }
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