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
            <h2 id="heading">Actualizar tabla</h2>

            <form method="POST" action="actualizar.php" enctype="multipart/form-data">
                <!-- Combo para seleccionar la serie -->
                <div class="form-group">
                    <label for="serie">Seleccionar Serie:</label>
                    <select requerided class="form-control" name="serie" id="serie" onchange="actualizarTabla()">
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
                <!-- Combo para seleccionar el equipo (puedes modificar esto si deseas una lista de equipos también) -->
                <div class="form-group">
                    <label for="equipo">Seleccionar Equipo:</label>
                    <select requerided class="form-control" name="equipo" id="equipo">
                        <option value="">Seleccione un equipo</option>
                        <?php
                            include("../../abrir_conexion.php");
                            $query = "SELECT DISTINCT nombres FROM tbl_equipos ORDER BY nombres ASC;";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['nombres']) . "'>" . htmlspecialchars($row['nombres']) . "</option>";
                            }
                            pg_close($conexion);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                            <label class="etiqueta-color" for="txtnivel">Resultado</label>
                            <select type="text" size="1" required name="txtestado" id="txtestado" class="form-control">
                                <option value="Gano">Gano</option>
                                <option value="Perdio">Perdio</option>
                                <option value="Empato">Empato</option>
                            </select>
                        </div>
                        <label for="favor">Goles a Favor:</label>
                        <input type="number" value=0 name="favor" id="favor" class="form-control">

                        <label for="contra">Goles en Contra:</label>
                        <input type="number" value=0 name="contra" id="contra" class="form-control">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit" name="Grabar" id="Grabar">Actualizar</button>
                            <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                        </div>
                    </div>
                </div>
                <!-- Tabla que se actualizará dinámicamente -->
                <div id="tablaSerie" class="table-container mt-3 mb-5"></div>
            </form>
        </main>

        <footer class="footer">
            <h5>@ Todos los derechos Reservados. </h5>
        </footer>
    </div>

    <script>
        function actualizarTabla() {
            var serie = document.getElementById("serie").value;
            if (serie !== "") {
                $.ajax({
                    url: "obtener_tabla.php",
                    type: "POST",
                    data: { serie: serie },
                    success: function(response) {
                        $('#tablaSerie').html(response);
                    }
                });
            } else {
                $('#tablaSerie').html(""); // Limpiar la tabla si no se selecciona ninguna serie
            }
        }

        function cerrar() {
            window.location.href = '../menuadmin/menu.php';
        }
    </script>
</body>
</html>


