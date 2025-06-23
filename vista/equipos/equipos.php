<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Equipos</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="../../css/main.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>
</head>
<body>

    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <h2 id="heading">Registro de Equipos</h2>
            <form method="POST" action="insertar_equipo.php" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtpersona">Seleccionar Delegado</label>
                            <select required name="txtpersona" id="txtpersona" class="form-control" onchange="actualizarNombres()">
                                <option value="" selected disabled>Seleccione un delegado</option>
                                <?php
                                // Incluir el archivo de conexión
                                include("../../abrir_conexion.php");

                                // Consulta para obtener las personas y sus promociones
                                $query_personas = "SELECT idcodigo, CONCAT(apellidos, ' ', nombres,'-', promocion) AS nombre_completo, promocion, serie FROM tbl_personas ORDER BY promocion";

                                // Ejecutar la consulta
                                $resultados_personas = pg_query($conexion, $query_personas);

                                // Mostrar las opciones en el campo de selección
                                while ($row = pg_fetch_assoc($resultados_personas)) {
                                    echo "<option value='{$row['idcodigo']}' data-promocion='{$row['promocion']}' data-serie='{$row['serie']}'>{$row['nombre_completo']}</option>";
                                }

                                // Liberar el resultado
                                pg_free_result($resultados_personas);

                                // Cerrar la conexión
                                pg_close($conexion);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtNombres">Nombres</label>
                            <input type="text" class="form-control" id="txtNombres" name="txtNombres" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtserie">SERIE</label>
                            <input type="text" class="form-control" id="txtserie" name="txtserie" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                    </div>
                </div>

                <h1></h1>
                <h1></h1>
                <h1></h1>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit" name="Grabar" id="Grabar">Grabar Registro</button>
                            <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                        </div>
                    </div>
                </div>
            </form>

            <h1></h1>
            <div id="mostrar_mensaje"></div>

            <div class="card mt-4">
                <div class="card-body">
                    <h2 id="heading">Lista de Equipos</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Serie</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Incluir el archivo de conexión
                            include("../../abrir_conexion.php");

                            // Consulta para obtener los equipos
                            $query_equipos = "SELECT * FROM tbl_equipos order by nombres";

                            // Ejecutar la consulta
                            $resultados_equipos = pg_query($conexion, $query_equipos);

                            // Mostrar los datos en la tabla
                            while ($row = pg_fetch_assoc($resultados_equipos)) {
                                echo "<tr>";
                                echo "<td>{$row['nombres']}</td>";
                                echo "<td>{$row['serie']}</td>";
                                echo "<td>
                                    <a href='editar_equipo.php?id={$row['idequipo']}' class='btn btn-warning'>
                                        <img src='../../img/modi.png' alt='Editar' style='width: 20px; height: 20px;'>
                                    </a>
                                    
                                </td>";
                                echo "</tr>";
                            }

                            // Liberar el resultado
                            pg_free_result($resultados_equipos);

                            // Cerrar la conexión
                            pg_close($conexion);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer class="footer">
            <h5>@ Todos los derechos Reservados. </h5>
        </footer>
    </div>

    <script>
        function cerrar() {
            window.location.href = '../menuadmin/menu.php';
        }

        function confirmarEliminacion(idEquipo) {
            swal({
                title: "¿Estás seguro?",
                text: "Una vez eliminado, no podrás recuperar este registro.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'eliminar_equipo.php?id=' + idEquipo;
                }
            });
        }

        function actualizarNombres() {
            const select = document.getElementById('txtpersona');
            const selectedOption = select.options[select.selectedIndex];
            const promocion = selectedOption.getAttribute('data-promocion');
            const serie = selectedOption.getAttribute('data-serie');
            document.getElementById('txtNombres').value = promocion ? promocion : '';
            document.getElementById('txtserie').value = serie ? serie : '';
        }
    </script>
</body>
</html>

