<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultar Información CIP</title>
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
      
?>

    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <h2 id="heading">Registro de Usuarios</h2>
            <form method="POST" action="insertar3.php" enctype="multipart/form-data">
                <div class="card">
                    <?php
                    $new_cod = "";
                    // Incluir el archivo de conexión
                    include("../../abrir_conexion.php");

                    // Consulta para obtener el último valor de idcodigo
                    $query_last = "SELECT MAX(idcodigo) AS max_cod FROM tbl_cusuarios";

                    // Ejecutar la consulta
                    $resultados = pg_query($conexion, $query_last);

                    // Verificar si la consulta fue exitosa
                    if ($resultados) {
                        // Obtener el valor del código máximo
                        $row = pg_fetch_assoc($resultados);
                        $max_cod = $row['max_cod'];

                        // Procesar el valor del código para generar el nuevo código
                        if ($max_cod) {
                            // Extraer el número del código y convertirlo en entero
                            $num = (int) substr($max_cod, 3);
                            // Incrementar el número y volver a formatearlo
                            $new_cod = '000' . ($num + 1);
                        } else {
                            // Si no hay registros, establecer el primer código
                            $new_cod = '0001';
                        }
                    } else {
                        // Si la consulta falla, manejar el error
                        echo "Error en la consulta: " . pg_last_error($conexion);
                        $new_cod = '0001';
                    }

                    // Imprimir el nuevo código
                    ?>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="etiqueta-color" for="persona">Seleccionar Delegado</label>
                            <select required name="txtpersona" id="persona" class="form-control">
                                <?php
                                // Consulta para obtener las personas
                                $query_personas = "SELECT idcodigo, CONCAT(apellidos, ' ', nombres,'-', promocion) AS nombre_completo, promocion FROM tbl_personas order by apellidos";

                                // Ejecutar la consulta
                                $resultados_personas = pg_query($conexion, $query_personas);

                                // Mostrar las opciones en el campo de selección
                                while ($row = pg_fetch_assoc($resultados_personas)) {
                                    echo "<option value='{$row['idcodigo']}'>{$row['nombre_completo']}</option>";
                                }

                                // Liberar el resultado
                                pg_free_result($resultados_personas);
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="etiqueta-color" for="txtusuario">Usuario</label>
                            <input type="text" required name="txtusuario" class="form-control" onkeypress="return soloLetras(event)">
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtclave">Clave</label>
                            <input type="text" maxlength="20" required name="txtclave" id="txtclave" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="etiqueta-color" for="txtserie">Serie</label>
                            <select type="text" size="1" required name="txtserie" id="txtserie" class="form-control">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtnivel">Nivel</label>
                            <select type="text" size="1" required name="txtnivel" id="txtnivel" class="form-control">
                                <option value="USUARIO">USUARIO</option>
                                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <h1></h1>
                <h1></h1>
                <h1></h1>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit" name="Grabar" id="Grabar">Grabar Registro</button>
                                <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <h1></h1>
            <div id="mostrar_mensaje"></div>

            <div class="card mt-4">
                <div class="card-body">
                    <h2 id="heading">Lista de Usuarios</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                               <th>Item</th> 
                               <th>Usuario</th>
                                <th>Serie</th>
                                <th>Promoción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta para obtener los usuarios
                            $query_usuarios = "SELECT cu.idcodigo, CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo, cu.usuario, cu.serie, cu.nivel 
                                               FROM tbl_cusuarios cu 
                                               JOIN tbl_personas p ON cu.idcodigo = p.idcodigo order by p.promocion";

                            // Ejecutar la consulta
                            $resultados_usuarios = pg_query($conexion, $query_usuarios);
                                $c=0;
                            // Mostrar los datos en la tabla
                            while ($row = pg_fetch_assoc($resultados_usuarios)) {
                                $c++;

                                if ($row['nivel']=="ADMINISTRADOR")
                                {
                                   $Destado="1";
                                }
                                else {
                                    $Destado="0";
                                }

                                echo "<tr>";
                                echo "<td>{$c}</td>";
                                echo "<td>{$row['usuario']}</td>";
                                echo "<td>{$row['serie']}</td>";
                                $idcodigox=$row['idcodigo'];
                                //buscar promocion
                                $query = "SELECT idcodigo, serie,promocion FROM tbl_personas WHERE idcodigo = '$idcodigox'";
                                $resultados = pg_query($conexion, $query);

                                if ($resultados) {
                                    $row = pg_fetch_assoc($resultados);
                                    $promocion = $row['promocion'];
                                    
                                }  

                                //fin de buscar
                                echo "<td>{$promocion}</td>";
                                echo "<td>
                                    <a href='editar.php?id={$row['idcodigo']}' class='btn btn-warning'>
                                        <img src='../../img/modi.png' alt='Editar' width='20' height='20'>
                                    </a>
                                    <button onclick=\"confirmarEliminacion('{$row['idcodigo']}')\" class='btn btn-danger custom-width-edad'>
                                        <img src='../../img/delete.png' alt='Eliminar' width='20' height='20'>
                                    </button>
                                </td>";
                                echo "</tr>";
                            }

                            // Liberar el resultado
                            pg_free_result($resultados_usuarios);

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
        function soloLetras(e) {
            var key = e.keyCode || e.which;
            var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
            var especiales = [8, 37, 39, 46];

            var tecla_especial = false;
            for (var i in especiales) {
                if (key === especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) === -1 && !tecla_especial) {
                return false;
            }
        }

        function cerrar() {
            window.location.href = '../menuadmin/menu.php';
        }

        function confirmarEliminacion(idUsuario) {
            swal({
                title: "¿Estás seguro?",
                text: "Una vez eliminado, no podrás recuperar este registro.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'eliminar.php?id=' + idUsuario;
                }
            });
        }
    </script>
</body>
</html>

