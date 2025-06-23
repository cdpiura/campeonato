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
    <?php
        session_start();
        include("../../abrir_conexion.php");
        $idcodigo = $_SESSION['misession']['idcodigo'];
        $nivel = $_SESSION['misession']['nivel'];
      
        if ($nivel != 'ADMINISTRADOR') {
            $query = "SELECT idcodigo, serie, promocion FROM tbl_personas WHERE idcodigo = '$idcodigo'";
            $resultados = pg_query($conexion, $query);   
            if ($resultados) {
                $row = pg_fetch_assoc($resultados);
                $serie = $row['serie'];
                pg_free_result($resultados);
            } else {
                echo "Error en la consulta: " . pg_last_error($conexion);
            }
        } else {
            $query = "SELECT idcodigo, serie, promocion FROM tbl_personas";
            $serie = "Todos";
        }

        pg_close($conexion);
    ?>

    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png" alt="Logo">
        </header>
        <main class="contenido">
            <h2 id="heading">Registro de Equipos Serie: <?php echo $serie; ?></h2>
            <form method="POST" action="insertar_equipo.php" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtpersona">Seleccionar Delegado</label>
                            <select required name="txtpersona" id="txtpersona" class="form-control" onchange="actualizarNombres()">
                                <option value="" selected disabled>Seleccione un delegado</option>
                                <?php
                                    include("../../abrir_conexion.php");
                                    if ($nivel != 'ADMINISTRADOR') {
                                        $query_personas = "SELECT idcodigo, CONCAT(apellidos, ' ', nombres, '-', promocion) AS nombre_completo, promocion, serie FROM tbl_personas WHERE serie='$serie' ORDER BY promocion";
                                    } else {
                                        $query_personas = "SELECT idcodigo, CONCAT(apellidos, ' ', nombres, '-', promocion) AS nombre_completo, promocion, serie FROM tbl_personas ORDER BY promocion";
                                    }

                                    $resultados_personas = pg_query($conexion, $query_personas);

                                    while ($row = pg_fetch_assoc($resultados_personas)) {
                                        echo "<option value='{$row['idcodigo']}' data-promocion='{$row['promocion']}' data-serie='{$row['serie']}'>{$row['nombre_completo']}</option>";
                                    }

                                    pg_free_result($resultados_personas);
                                    pg_close($conexion);
                                ?>
                            </select>
                        </div>
                        <input type="hidden" id="selectedIdCodigo" name="selectedIdCodigo">
                    </div>
                </div>
            </form>

            <div id="mostrar_mensaje"></div>

            <div class="card mt-4" style="max-width: 600px; margin: 0 auto;">
                <div class="card-body" style="padding: 10px;">
                    <h2 id="heading" style="color: #A70B0B; text-align: center;">Lista de Jugadores</h2>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th style="color: #A70B0B;">Nro</th>
                                <th style="color: #A70B0B;">Deportista</th>
                                <th style="color: #A70B0B;">TR</th>
                                <th style="color: #A70B0B;">TA</th>
                                <th style="color: #A70B0B;">GO</th>
                                <th style="color: #A70B0B;">Estado</th>
                            </tr>
                        </thead>
                        <tbody id="lista_equipos">
                            <!-- Aquí se actualizará la lista de equipos -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                    </div>
                </div>
            </div>
            <h5 style="color: red;">Si el Jugador está (I) Inactivo, no puede participar en el presente campeonato</h5>
        </main>

        <footer class="footer">
            <h5>@ Todos los derechos reservados.</h5>
        </footer>
    </div>

    <script>
        function cerrar() {
            <?php if ($nivel != 'ADMINISTRADOR'): ?>
                window.location.href = '../menudele/menu.php';
            <?php else: ?>
                window.location.href = '../menuadmin/menu.php';
            <?php endif; ?>
        }

        function actualizarNombres() {
            const select = document.getElementById('txtpersona');
            const selectedOption = select.options[select.selectedIndex];
            const idcodigo = selectedOption.value;
            document.getElementById('selectedIdCodigo').value = idcodigo;

            // Enviar solicitud AJAX para obtener la lista de equipos
            $.ajax({
                url: 'obtener_equipos.php',
                type: 'POST',
                data: { idcodigo: idcodigo },
                success: function(response) {
                    $('#lista_equipos').html(response);
                },
                error: function() {
                    console.error('Error al obtener la lista de equipos.');
                }
            });
        }
    </script>
</body>
</html>

