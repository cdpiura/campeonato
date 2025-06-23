<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eliminar Usuario</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>
</head>
<body>
<?php
// Incluir el archivo de conexión
include("../../abrir_conexion.php");

if (isset($_GET['id'])) {
    $idcodigo = $_GET['id'];
    
    // Consulta para eliminar el usuario
    $query = "DELETE FROM tbl_cusuarios WHERE idcodigo='$idcodigo'";
    $resultado = pg_query($conexion, $query);

    if ($resultado) {
        echo "<script>
                swal({
                    title: '¡Éxito!',
                    text: 'El registro se ha eliminado correctamente.',
                    icon: 'success',
                    button: 'Aceptar'
                }).then(function() {
                    window.location.href = 'usuarios.php';
                });
              </script>";
    } else {
        echo "<script>
                swal({
                    title: '¡Error!',
                    text: 'Hubo un problema al eliminar el registro.',
                    icon: 'error',
                    button: 'Aceptar'
                }).then(function() {
                    window.location.href = 'usuarios.php';
                });
              </script>";
    }
} else {
    echo "<script>
            swal({
                title: '¡Error!',
                text: 'No se ha proporcionado un ID válido.',
                icon: 'error',
                button: 'Aceptar'
            }).then(function() {
                window.location.href = 'usuarios.php';
            });
          </script>";
}
?>
</body>
</html>






