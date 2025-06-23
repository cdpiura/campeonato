<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Datos de Equipos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src=" https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header>
<?php
// Incluir archivo de conexión a la base de datos
include("../../abrir_conexion.php");

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $txtpersona = $_POST['txtpersona'];
    $txtNombres = $_POST['txtNombres'];
    $txtserie = $_POST['txtserie'];
    echo $txtserie;
    // Validar que los campos no estén vacíos
    if (empty($txtpersona) || empty($txtNombres)) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor, complete todos los campos.',
                footer: '<a href=\"#\">Why do I have this issue?</a>'
            }).then((result) => {
                // Mantener al usuario en el formulario
                if (result.isConfirmed) {
                    window.location.href = 'equipos.php';
                }
            });
        </script>
        <?php
        exit(); // Detener la ejecución del script si hay campos vacíos
    }
    
    // Verificar si el idcodigo ya existe en la base de datos
    $query_verificar = "SELECT idcodigo FROM tbl_equipos WHERE idcodigo = $1";
    $result_verificar = pg_prepare($conexion, "verificar_query", $query_verificar);
    $result_verificar = pg_execute($conexion, "verificar_query", array($txtpersona));

    if (pg_num_rows($result_verificar) > 0) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El código de equipo ya está registrado.',
                footer: '<a href=\"#\">Why do I have this issue?</a>'
            }).then((result) => {
                // Mantener al usuario en el formulario
                if (result.isConfirmed) {
                    window.location.href = 'equipos.php';
                }
            });
        </script>
        <?php
        exit(); // Detener la inserción si el idcodigo ya existe
    }
    
    // Obtener la fecha actual del sistema en formato YYYY-MM-DD
    $txtFecha = date('Y-m-d');

    // Obtener el año actual
    $txtAnio = date('Y');

    // Estado por defecto es 0
    $txtEstado = 0;

    // Consulta SQL para insertar el equipo en la base de datos
    $query_insert = "INSERT INTO tbl_equipos (idcodigo, nombres, fecha, año, estado,serie) 
                     VALUES ($1, $2, $3, $4, $5,$6)";

    // Preparar la consulta
    $result_insert = pg_prepare($conexion, "insert_query", $query_insert);

    // Ejecutar la consulta
    $result_insert = pg_execute($conexion, "insert_query", array($txtpersona, $txtNombres, $txtFecha, $txtAnio, $txtEstado,$txtserie));

    // Verificar si la inserción fue exitosa
    if ($result_insert) {
        ?>
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Datos Actualizados Correctamente",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Redirigir al usuario a otra página
                window.location.href = 'equipos.php';
            });
        </script>
        <?php    
    } else {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No se Pudo Realizar Registro!',
                footer: '<a href=\"#\">Why do I have this issue?</a>'
            }).then((result) => {
                // Mantener al usuario en el formulario
                if (result.isConfirmed) {
                    window.location.href = 'equipos.php';
                }
            });
        </script>
        <?php
    }

    // Liberar el resultado y cerrar la conexión
    pg_free_result($result_insert);
    pg_close($conexion);
} else {
    // Redirigir si se intenta acceder directamente a este script sin datos POST
    header("Location: index.php");
    exit();
}
?>
</body>
</html>

 
 