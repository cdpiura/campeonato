<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include("../../abrir_conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipo = $_POST['equipo'];
    $estado = $_POST['txtestado'];
    $golesFavor = intval($_POST['favor']);
    $golesContra = intval($_POST['contra']);

    // Validar que los campos no estén vacíos
    if (empty($equipo) || empty($estado) )
     {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, complete todos los campos.'
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit(); // Detener la ejecución si hay campos vacíos
    }

    // Si todos los campos están completos, mostrar la alerta de confirmación
    echo "<script>
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas actualizar los datos para el equipo $equipo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'actualizar_procesar.php?equipo=$equipo&estado=$estado&favor=$golesFavor&contra=$golesContra';
            } else {
                window.location.href = 'tabla.php';
            }
        });
    </script>";
}
?>
</body>
</html>

