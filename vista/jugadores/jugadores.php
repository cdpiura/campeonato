<!DOCTYPE html>
<html lang="es">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <h2 id="heading">Registro Tarjetas/Goles</h2>
            <form id="formRegistro" method="POST" action="actualizar_procesar.php" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtNombres">Nombre de Jugador</label>
                            <input type="text" class="form-control" id="txtnombre" name="txtnombre" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtNombres">Fecha</label>
                            <input type="date" class="form-control" id="txtfecha" name="txtfecha" required>
                        </div>
                            
                        <input type="hidden" class="form-control" id="txtapellidos" name="txtapellidos" required>
                       
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtAmarillas">Amarillas</label>
                            <input type="text" class="form-control" id="txtamarillas" value="0" name="txtamarillas" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtRojas">Rojas</label>
                            <input type="text" class="form-control" id="txtrojas" value="0" name="txtrojas" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtGoles">Goles</label>
                            <input type="text" class="form-control" id="txtgoles" value="0" name="txtgoles" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="txtid" name="txtid">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <button class="btn btn-danger" type="button" id="btnGrabar">Grabar Registro</button>
                            <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Campo de búsqueda -->
            <div class="form-group">
                <input type="text" id="buscarJugador" class="form-control" placeholder="Buscar jugador...">
            </div>

            <div id="mostrar_mensaje"></div>

            <div class="card mt-4">
                <div class="card-body">
                    <h2 id="heading">Lista de Equipos</h2>
                    <div id="tablaEquipos">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>Serie</th> 
                                </tr>
                            </thead>
                            <tbody id="tablaCuerpo">
                                <!-- Contenido generado dinámicamente -->
                                <?php
                                // Incluir el archivo de conexión
                                include("../../abrir_conexion.php");

                                // Consulta para obtener los equipos
                                $query_equipos = "SELECT 
                                        td.iddeportista, 
                                        td.nombres AS nombres_deportista, 
                                        td.apellidos AS apellidos_deportista, 
                                        td.estado AS estado_deportista,
                                        p.promocion, 
                                        p.serie
                                    FROM 
                                        public.tbl_deportista td 
                                    INNER JOIN 
                                        public.tbl_personas p 
                                    ON 
                                        td.idcodigo = p.idcodigo 
                                    ORDER BY 
                                        p.promocion,
                                        p.serie ASC";

                                // Ejecutar la consulta
                                $resultados_equipos = pg_query($conexion, $query_equipos);

                                // Mostrar los datos en la tabla
                                while ($row = pg_fetch_assoc($resultados_equipos)) {
                                    $nombreCompleto = $row['nombres_deportista'] . ' ' . $row['apellidos_deportista'];
                                    echo "<tr>";
                                    echo "<td><input type='checkbox' name='seleccion[]' value='{$row['iddeportista']}' data-nombre='{$nombreCompleto}'></td>";
                                    echo "<td>{$row['nombres_deportista']}</td>";
                                    echo "<td>{$row['serie']}</td>";
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
            </div>
        </main>

        <footer class="footer">
            <h5>@ Todos los derechos Reservados. </h5>
        </footer>
    </div>

    <script>
    $(document).ready(function() {
        // Función para buscar jugadores
        function buscarJugador(query) {
            $.ajax({
                url: "buscar_jugador.php", // Archivo PHP que maneja la búsqueda
                method: "POST",
                data: { query: query },
                success: function(data) {
                    $("#tablaCuerpo").html(data); // Actualiza la tabla con los datos recibidos
                }
            });
        }

        // Cargar todos los jugadores al inicio
        buscarJugador(''); // Llamada para cargar todos los jugadores

        // Detecta cambios en el campo de búsqueda
        $("#buscarJugador").on("keyup", function() {
            var query = $(this).val();
            buscarJugador(query); // Llama a la función de búsqueda
        });

        // Detecta cambios en las casillas de verificación
        $(document).on("change", "input[name='seleccion[]']", function() {
            var selectedCheckbox = $(this);
            var nombreCompleto = selectedCheckbox.data('nombre');
            var idDeportista = selectedCheckbox.val();
            var partesNombre = nombreCompleto.split(' ');
            $("#txtnombre").val(partesNombre.slice(0, -1).join(' ')); // Nombre
            $("#txtapellidos").val(partesNombre.slice(-1).join(' ')); // Apellido
            $("#txtid").val(idDeportista); // Captura el ID en un campo oculto
        });

        // Al hacer clic en "Grabar Registro"
        $("#btnGrabar").on("click", function(e) {
            e.preventDefault(); // Prevenir el envío del formulario inmediatamente
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas grabar el registro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, grabar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#formRegistro").submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });
    
    function cerrar()
     {
            window.location.href = '../menuadmin/menu.php';
       }
    </script>
      
</body>
</html>
