<?php
// Incluir la configuración de conexión
include('config.php');

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que los datos han sido enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $stock = $_POST['stock'];
    $precioCompra = $_POST['precioCompra'];
    $precioVenta = $_POST['precioVenta'];
    $ganancia = $_POST['ganancia'];

    // Preparar la consulta de actualización
    $sql = "UPDATE productos SET 
            Stock = ?, 
            PrecioCompra = ?, 
            PrecioVenta = ?, 
            Ganancia = ? 
            WHERE id = ?";

    // Ajustar el tipo de datos: "i" para enteros, "d" para decimales
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iddii", $stock, $precioCompra, $precioVenta, $ganancia, $id); // Ajustamos la cantidad de parámetros

    // Ejecutar la consulta y verificar si se ha actualizado correctamente
    if ($stmt->execute()) {
        echo "<script>alert('Producto actualizado correctamente'); window.location.href='Consulta.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el producto'); window.location.href='Consulta.php';</script>";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
