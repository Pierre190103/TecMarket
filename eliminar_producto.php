<?php
session_start();
include 'config.php'; // Incluye el archivo de configuración

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el ID está presente en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto = $_GET['id']; // Obtener ID del producto desde la URL

    // Eliminar los registros dependientes en la tabla carrito
    $delete_carrito_sql = "DELETE FROM carrito WHERE id_producto = ?";
    $stmt_carrito = $conn->prepare($delete_carrito_sql);
    $stmt_carrito->bind_param("i", $id_producto);

    if ($stmt_carrito->execute()) {
        // Ahora eliminar el producto de la tabla productos
        $delete_sql = "DELETE FROM productos WHERE id = ?";
        $stmt_producto = $conn->prepare($delete_sql);
        $stmt_producto->bind_param("i", $id_producto);

        if ($stmt_producto->execute()) {
            echo "<script>alert('Registro eliminado correctamente'); window.location.href = 'consulta.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar el producto. Error: " . $stmt_producto->error . "'); window.location.href = 'inicio.php';</script>";
        }

        $stmt_producto->close();
    } else {
        echo "<script>alert('Error al eliminar los registros del carrito. Error: " . $stmt_carrito->error . "'); window.location.href = 'inicio.php';</script>";
    }

    $stmt_carrito->close();
} else {
    echo "<script>alert('ID de producto no válido'); window.location.href = 'inicio.php';</script>";
}

// Cerrar la conexión
$conn->close();
?>
