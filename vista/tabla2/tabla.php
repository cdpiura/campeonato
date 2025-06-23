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
            <h2 id="heading">Información de Series</h2>

            <form method="POST" action="actualizar.php" enctype="multipart/form-data">
                <!-- Combo para seleccionar la serie -->
                <div class="form-group">
                    <label for="serie">Seleccionar Serie:</label>
                    <select required class="form-control" name="serie" id="serie" onchange="actualizarContenido()">
                        <option value="">Seleccione una serie</option>
                        <?php
                            include("../../abrir_conexion.php");
                            $query = "SELECT DISTINCT serie FROM tbl_equipos ORDER BY serie ASC;";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['serie']) . "'>" . htmlspecialchars($row['serie']) . "</option>";
                            }
                            pg_close($conexion);
                        ?>
                    </select>
                </div>
                 
                <!-- Combo para seleccionar la opción -->
                <div class="form-group">
                    <label for="opcion">Seleccionar Opción:</label>
                    <select required class="form-control" name="opcion" id="opcion" onchange="actualizarContenido()">
                        <option value="">Seleccione una opción</option>
                        <option value="tabla">Tabla</option>
                        <option value="goles_semana">Goles de la Semana</option>
                        <option value="goleadores">Tabla de Goleadores</option>
                        <option value="tarjetas_amarillas">Tarjetas Amarillas</option>
                        <option value="tarjetas_rojas">Tarjetas Rojas</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit" name="Grabar" id="Grabar">Actualizar</button>
                                <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contenedor que se actualizará dinámicamente -->
                <div id="contenido" class="table-container mt-3 mb-5"></div>
            </form>
        </main>

        <footer class="footer">
            <h5>@ Todos los derechos Reservados.</h5>
        </footer>
    </div>

    <script>
        function actualizarContenido() {
            var serie = document.getElementById("serie").value;
            var opcion = document.getElementById("opcion").value;

            if (serie !== "" && opcion !== "") {
                $.ajax({
                    url: "obtener_contenido.php",
                    type: "POST",
                    data: { serie: serie, opcion: opcion },
                    success: function(response) {
                        $('#contenido').html(response);
                    }
                });
            } else {
                $('#contenido').html(""); // Limpiar el contenido si no se selecciona ninguna serie u opción
            }
        }

        function cerrar() {
            window.location.href = '../menuadmin/menu.php';
        }
    </script>
</body>
</html>



