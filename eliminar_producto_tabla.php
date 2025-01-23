<?php

include 'config.php';

// Verificar si se recibieron los datos necesarios
if (isset($_REQUEST['codigo_agregado']) && isset($_REQUEST['categoria']) && isset($_REQUEST['PrecioVenta'])) {
    // Obtener los datos del formulario
    $codigo_agregado = $_POST['codigo_agregado'];
    $codigo_categoria = $_POST['categoria'];
    $PrecioVenta = $_POST['PrecioVenta'];

    // Crear una conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database, $port);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para actualizar la cantidad del producto en el carrito
    $sql = "UPDATE carrito 
SET cantidad = cantidad - 1,
    precio = precio - $PrecioVenta
WHERE id = $codigo_agregado
LIMIT 1;";

    if ($conn->query($sql) === TRUE) {
        header("Location: Catalogo.php?codigo=$codigo_categoria");
    } else {
        echo "Error al eliminar producto del carrito: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibieron todos los datos necesarios, mostrar un mensaje de error
    echo "Error: Todos los campos deben ser llenados";
}
?>
