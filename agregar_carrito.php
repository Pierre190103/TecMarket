<?php
session_start();
$username_post = $_SESSION["usuario"];

include 'config.php';

// Verificar si se recibieron los datos necesarios
if (isset($_POST['id']) && isset($_POST['precioVenta']) && isset($_POST['codigo_categoria'])) {
    // Obtener los datos del formulario
    $codigo_categoria = $_POST['codigo_categoria'];
    $producto_id = $_POST['id'];
    $cantidad = 1; // Establecer la cantidad en 1
    $precio = $_POST['precioVenta'];
    
    // Crear una conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database, $port);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para verificar si el producto ya está en el carrito
    $sql_select = "SELECT cantidad, precio FROM carrito WHERE id_producto = $producto_id AND trabajador = '$username_post'";
    $resultado_select = $conn->query($sql_select);

    if ($resultado_select->num_rows > 0) {
        // Si el producto ya está en el carrito, actualizar la cantidad y el precio
        $fila = $resultado_select->fetch_assoc();
        $nueva_cantidad = $fila['cantidad'] + $cantidad;
        $nuevo_precio = $fila['precio'] + $precio;
        
        $sql_update = "UPDATE carrito SET cantidad = $nueva_cantidad, precio = $nuevo_precio WHERE id_producto = $producto_id AND trabajador = '$username_post'";
        if ($conn->query($sql_update) === TRUE) {
            header("Location: Catalogo.php?codigo=$codigo_categoria");
            exit();
        } else {
            echo "Error al actualizar la cantidad y el precio del producto en el carrito: " . $conn->error;
        }
    } else {
        // Si el producto no está en el carrito, insertar un nuevo registro
        $sql_insert = "INSERT INTO carrito (id_producto, cantidad, precio, trabajador) VALUES ('$producto_id', '$cantidad', '$precio', '$username_post')";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: Catalogo.php?codigo=$codigo_categoria");
            exit();
        } else {
            echo "Error al agregar producto al carrito: " . $conn->error;
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibieron todos los datos necesarios, mostrar un mensaje de error
    echo "Error: Todos los campos deben ser llenados";
}
?>
