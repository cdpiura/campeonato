<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Datos de Equipos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header>
<?php
include("../../abrir_conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iddeportista = $_POST['txtid'];
    $fecha = $_POST['txtfecha'];
    $rojas = $_POST['txtrojas'];
    $amarillas = $_POST['txtamarillas'];
    $goles = $_POST['txtgoles'];

    if (empty($iddeportista) || empty($fecha)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, complete todos los campos.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'jugadores.php';
                }
            });
        </script>";
        exit();
    }

    $query_verificar = "SELECT idcodigo FROM tbl_equipos WHERE idcodigo = $1";
    $result_verificar = pg_prepare($conexion, "verificar_query", $query_verificar);
    $result_verificar = pg_execute($conexion, "verificar_query", array($iddeportista));

    if (pg_num_rows($result_verificar) > 0) {
        echo "<script>
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'El código de equipo ya está registrado. ¿Deseas actualizar los datos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige a una página de procesamiento de actualización
                    window.location.href = 'actualizar_procesar.php?iddeportista=$iddeportista&fecha=$fecha&rojas=$rojas&amarillas=$amarillas&goles=$goles';
                } else {
                    // Redirige a la página de registro de equipos
                    window.location.href = 'equipos.php';
                }
            });
        </script>";
        exit();
    }

    $query_insert = "INSERT INTO tbl_movimientos (iddeportista, fecha, tarjetas_rojas, tarjetas_amarillas, goles) 
                     VALUES ($1, $2, $3, $4, $5)";
    $result_insert = pg_prepare($conexion, "insert_query", $query_insert);
    $result_insert = pg_execute($conexion, "insert_query", array($iddeportista, $fecha, $rojas, $amarillas, $goles));

    if ($result_insert) {
        echo "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Datos registrados correctamente',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'jugadores.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo registrar los datos.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'jugadores.php';
                }
            });
        </script>";
    }

    pg_free_result($result_insert);
    pg_close($conexion);
} else {
    header("Location: index.php");
    exit();
}
?>
</header>
</body>
</html>
