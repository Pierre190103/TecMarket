<?php
session_start();
$username_post = $_SESSION["usuario"];
?>
<?php

include 'config.php';
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "DELETE FROM carrito WHERE trabajador = '$username_post';";

if ($conn->query($sql) === TRUE) {
    // Verificar si se afectó alguna fila
    if ($conn->affected_rows > 0) {
        // Si se eliminaron registros, redirigir a inicio.php
        header("Location: inicio.php");
    } else {
        // Si no se eliminaron registros, mostrar un mensaje de error
        echo "No se encontraron productos en el carrito para eliminar.";
    }
} else {
    echo "Error al eliminar producto del carrito: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
