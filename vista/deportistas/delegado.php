<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="jquery-3.4.1.min.js"></script>
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../css/estilos.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Consultar Información CIP</title>
    <link rel="shortcut icon" href="img/favicon.ico" />
</head>

<script>
    function validardni(input) {
        // Obtener el valor actual del campo
        var dni = input.value;

        // Eliminar cualquier caracter que no sea un número
        dni = dni.replace(/\D/g, '');

        // Limitar la longitud a 8 dígitos
        dni = dni.slice(0, 8);

        // Actualizar el valor del campo
        input.value = dni;
    }

    function validarfono(input) {
        // Obtener el valor actual del campo
        var fono = input.value;

        // Eliminar cualquier caracter que no sea un número
        fono = fono.replace(/\D/g, '');

        // Limitar la longitud a 8 dígitos
        fono = fono.slice(0, 9);
        // Actualizar el valor del campo
        input.value = fono;
    }

    function cerrar() {
        // Redirigir a la página deseada
        window.location.href = '../menuadmin/menu.php';
    }
</script>

<body>

    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <style>
                #heading {
                    color: #CD5C5C;
                }

                .label-color {
                    color: #FFFEFD;
                }

                .etiqueta-color {
                    color: #CD5C5C;
                    font-weight: bold;
                }

                .button-color {
                    background-color: #FFFEFC;
                    color: #CD5C5C;
                }
            </style>
            <h2 id="heading">Registro de Delegados</h2>
            <form method="POST" action="insertar2.php" enctype="multipart/form-data">
                <div class="card">
                    <?php
                    // Incluir el archivo de conexión
                    include("../../abrir_conexion.php");

                    // Consulta para obtener el último valor de idcodigo
                    $query_last = "SELECT MAX(idcodigo) AS max_cod FROM tbl_personas";

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
                            $num = (int)substr($max_cod, 2);
                           
                            // Incrementar el número y volver a formatearlo
                            $new_cod = '00' . ($num + 1);
                        } else {
                            // Si no hay registros, establecer el primer código
                            $new_cod = '001';
                        }
                    } else {
                        // Si la consulta falla, manejar el error
                        echo "Error en la consulta: " . pg_last_error($conexion);
                        $new_cod = '0001';
                    }

                    // Cerrar la conexión
                    pg_close($conexion);

                    // Imprimir el nuevo código

                    ?>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="etiqueta-color" for="exampleInputPassword1">Codigo</label>
                            <input type="text" required name="txtcod" class="form-control" value="<?php echo $new_cod ?>" readonly>

                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="exampleInputPassword1">Apellidos</label>
                            <input type="text" required name="txtapell" class="form-control" onkeypress="return soloLetras(event)">
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="exampleInputPassword1">Nombres</label>
                            <input type="text" required name="txtnomb" class="form-control" onkeypress="return soloLetras(event)">
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color">Fecha de Nacimiento</label>
                            <input type="date" required name="txtfecha" id="txtfecha" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color">DNI</label>
                            <input type="text" name="txtdni" required id="txtdni" class="form-control" pattern="[0-9]{8}" title="Debe tener 8 dígitos" oninput="validardni(this)">
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color">Celular</label>

                            <input type="text" name="txtcelular" required id="txtcelular" class="form-control" pattern="[0-9]{9}" title="Debe tener 9 dígitos" oninput="validarfono(this)" maxlength="9">

                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color">Email</label>
                            <input type="text" name="txtemail" class="form-control" required id="email">
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="pare">Promoción</label>
                            <select type="text" size="1" required name="txtparentesco" id="pare" class="form-control">

                                <option value="1986">1986</option>
                                <option value="1987">1987</option>
                                <option value="1989">1989</option>
                                <option value="1990">1990</option>
                                <option value="1991">1991</option>
                                <option value="1992">1992</option>
                                <option value="1993">1993</option>
                                <option value="1994">1994</option>
                                <option value="1995">1995</option>
                                <option value="1996">1996</option>
                                <option value="1997">1997</option>
                                <option value="1998">1998</option>
                                <option value="1999">1999</option>
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                                <option value="2002">2002</option>
                                <option value="2003">2003</option>
                                <option value="2004">2004</option>
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                            </select>
                        </div>


                    </div>
                </div>


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
            <div id="mostrar_mensaje"></div>
        </main>

        <footer class="footer">
            <h5>@ Todos los derechos Reservados. </h5>
        </footer>
    </div>

    <script>
        function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
            especiales = [8, 37, 39, 46];

            tecla_especial = false
            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial)
                return false;
        }

        function limpia() {
            var val = document.getElementById("miInput").value;
            var tam = val.length;
            for (i = 0; i < tam; i++) {
                if (!isNaN(val[i]))
                    document.getElementById("miInput").value = '';
            }
        }
    </script>

</body>

</html>
