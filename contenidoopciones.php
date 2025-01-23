<?php
                        include 'config.php';
                        $conn = new mysqli($servername, $username, $password, $database, $port);

                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }

                        $nombreusuario = $conn->real_escape_string($nombreusuario);
                        $sql_check_admin = "SELECT cargo FROM users WHERE username = '$nombreusuario'";
                        $result_check_admin = $conn->query($sql_check_admin);

                        if ($result_check_admin->num_rows > 0) {
                            $row_admin = $result_check_admin->fetch_assoc();
                            if ($row_admin['cargo'] == 'Administrador') {
                                echo '<a href="dashboard.php" class="nav-item nav-link"><i class="fas fa-tachometer-alt me-2"></i>Panel de Control</a>';
                                echo '<a href="inicio.php" class="nav-item nav-link"><i class="fas fa-cash-register me-2"></i>POS</a>';

                                echo '<div class="nav-item dropdown">';
                                echo '      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-box-open me-2"></i>Productos</a>';
                                echo '      <div class="dropdown-menu bg-transparent border-0">';
                                echo '          <a href="agregar_producto.php" class="dropdown-item">Nuevo Producto</a>';
                                echo '          <a href="#" class="dropdown-item">Consulta</a>';
                                echo '          <a href="#" class="dropdown-item">Validado por fecha</a>';
                                echo '      </div>';
                                echo '</div>';

//                                echo '<div class="nav-item dropdown">';
//                                echo '      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-gift me-2"></i>Combos</a>';
//                                echo '      <div class="dropdown-menu bg-transparent border-0">';
//                                echo '          <a href="#" class="dropdown-item">Nuevo Combo</a>';
//                                echo '          <a href="#" class="dropdown-item">Consulta</a>';
//                                echo '          <a href="#" class="dropdown-item">Validado por fecha</a>';
//                                echo '      </div>';
//                                echo '</div>';

//                                echo '<div class="nav-item dropdown">';
//                                echo '      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-cash-register me-2"></i>Cajas</a>';
//                                echo '      <div class="dropdown-menu bg-transparent border-0">';
//                                echo '          <a href="#" class="dropdown-item">Control de Cajas</a>';
//                                echo '          <a href="#" class="dropdown-item">Movimiento de Caja</a>';
//                                echo '          <a href="#" class="dropdown-item">Reportes</a>';
//                                echo '      </div>';
//                                echo '</div>';

//                                echo '<div class="nav-item dropdown">';
//                                echo '      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-user me-2"></i>Usuarios</a>';
//                                echo '      <div class="dropdown-menu bg-transparent border-0">';
//                                echo '          <a href="#" class="dropdown-item">Usuarios</a>';
//                                echo '          <a href="#" class="dropdown-item">Historial de usuarios</a>';
//                                echo '      </div>';
//                                echo '</div>';

//                                echo '<div class="nav-item dropdown">';
//                                echo '      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-cogs me-2"></i>Adicionales</a>';
//                                echo '      <div class="dropdown-menu bg-transparent border-0">';
//                                echo '          <a href="#" class="dropdown-item">Marcas</a>';
//                                echo '          <a href="#" class="dropdown-item">Unidades</a>';
//                                echo '          <a href="#" class="dropdown-item">Presentacion</a>';
//                                echo '      </div>';
//                                echo '</div>';

//                                echo '<div class="nav-item dropdown">';
//                                echo '      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-database me-2"></i>Base de Datos</a>';
//                                echo '      <div class="dropdown-menu bg-transparent border-0">';
//                                echo '          <a href="#" class="dropdown-item">Backup</a>';
//                                echo '          <a href="#" class="dropdown-item">Restore</a>';
//                                echo '      </div>';
//                                echo '</div>';
                            } elseif ($row_admin['cargo'] == 'Empleado') {
                                echo '<a href="inicio.php" class="nav-item nav-link"><i class="fas fa-tags me-2"></i>POS</a>';
                            } else {
                                // User has a different role, no specific dropdown to show
                            }
                        } else {
                            echo "Usuario no encontrado";
                        }

                        $conn->close();
                        ?>