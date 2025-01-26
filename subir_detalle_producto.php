<?php
session_start();
include 'config.php'; // Archivo de configuración de la base de datos

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener datos del formulario
    $codigo = $_POST['codigo'];
    $nombre = $_POST['stock'];
    $detalleEmpaqueId = $_POST['detalleEmpaqueId'];
    $peso = $_POST['peso'];
    $unidadId = $_POST['unidadId'];
    $categoriaID = $_POST['categoriaID'];

    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar los datos en la tabla detalle_producto
    $sql = "INSERT INTO detalle_producto (Codigo, Nombre, Empaque, Peso, Unidades, Categoria)
            VALUES ('$codigo', '$nombre', '$detalleEmpaqueId', '$peso', '$unidadId', '$categoriaID')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto agregado correctamente'); window.location.href = 'agregar_detalle_producto.php';</script>";
    } else {
        echo "<script>alert('Error al agregar el producto: " . $conn->error . "'); window.history.back();</script>";
    }

    // Cerrar conexión
    $conn->close();
} else {
    echo "<script>alert('Acceso no autorizado'); window.location.href = 'agregar_producto.php';</script>";
}
?>
