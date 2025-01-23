<?php
session_start();
include 'config.php'; // Archivo de configuración de la base de datos

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener datos del formulario
    $detalleProductoId = $_POST['detalleProductoId'];
    $stock = $_POST['stock'];
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $precioCompra = $_POST['precioCompra'];
    $precioVenta = $_POST['precioVenta'];
    $ganancia = $precioVenta - $precioCompra;
    $detalleBodegaId = $_POST['detalleBodegaId'];

    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar los datos en la tabla productos
    $sql = "INSERT INTO productos (detalle_producto_id, Stock, FechaVencimiento, PrecioCompra, PrecioVenta, Ganancia, detalle_bodega_id)
            VALUES ('$detalleProductoId', '$stock', '$fechaVencimiento', '$precioCompra', '$precioVenta', '$ganancia', '$detalleBodegaId')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto agregado correctamente'); window.location.href = 'agregar_producto.php';</script>";
    } else {
        echo "<script>alert('Error al agregar el producto: " . $conn->error . "'); window.history.back();</script>";
    }

    // Cerrar conexión
    $conn->close();
} else {
    echo "<script>alert('Acceso no autorizado'); window.location.href = 'agregar_producto.php';</script>";
}
?>
