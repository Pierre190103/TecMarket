<div class="bg-light text-center rounded p-4" style="width: calc(100%);">
    <div class="container ">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Resumen De Venta</h6>
            <form method="post" action="eliminar_contenido_tabla.php">
                <button class="btn btn-sm btn-primary" >Cancelar Compra</button>
            </form>         </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php';
                    $conn = new mysqli($servername, $username, $password, $database);
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    $sql = "SELECT p.id as codigo_producto, p.nombre AS nombre_producto, p.categoria,SUM(c.cantidad) AS cantidad_total, SUM(c.precio) AS precio_total, p.PrecioVenta FROM carrito c JOIN productos p ON c.id_producto = p.id GROUP BY p.id, p.nombre, p.categoria HAVING cantidad_total > 0; ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["nombre_producto"] . '</td>';
                            echo '<td>' . $row["cantidad_total"] . '</td>';
                            echo '<td>S/ ' . $row["precio_total"] . '</td>';

                            echo '         <td><form method="post" action="eliminar_producto_tabla.php">';
                            echo '             <input type="hidden" name="codigo_producto" value="' . $row["codigo_producto"] . '">';
                            echo '             <input type="hidden" name="categoria" value="' . $row["categoria"] . '">';
                            echo '             <input type="hidden" name="PrecioVenta" value="' . $row["PrecioVenta"] . '">';
                            echo '             <button class="btn btn-sm btn-primary" >X</button>';

                            echo '         </form></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr>';
                        echo '<td>-</td>';
                        echo '<td>-</td>';
                        echo '<td>-</td>';
                        echo '<td>-</td>';
                        echo '</tr>';
                    }
                    $conn->close();
                    ?>

                    <?php
                    include 'config.php';
                    $conn = new mysqli($servername, $username, $password, $database);
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    $sql = "SELECT SUM(precio) AS suma_precios FROM carrito;";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td>S/ ' . $row["suma_precios"] . '</td>';
                            echo '<td></td>';
                        }
                    } else {
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>S/ ' . $row["suma_precios"] . '</td>';
                        echo '<td></td>';
                    }
                    $conn->close();
                    ?>




                </tbody>
            </table>
        </div>
    </div>
</div>