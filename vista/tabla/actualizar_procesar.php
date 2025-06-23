<!DOCTYPE html>
<html lang="es">
<head></head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body></body>
<?php
include("../../abrir_conexion.php");

if (isset($_GET['equipo'])) {
    $equipo = $_GET['equipo'];
    $estado = $_GET['estado'];
    $golesFavor = intval($_GET['favor']);
    $golesContra = intval($_GET['contra']);

    // Consulta para obtener los valores actuales del equipo seleccionado
    $query = "SELECT * FROM tbl_equipos WHERE nombres = '$equipo'";
    $result = pg_query($conexion, $query);
    $equipoData = pg_fetch_assoc($result);

    if ($equipoData) {
        // Variables para almacenar los nuevos valores
        $partidos = $equipoData['partidos'] + 1;
        $victorias = $equipoData['victorias'];
        $empates = $equipoData['empates'];
        $derrotas = $equipoData['derrrotas'];
        $favor = $equipoData['favor'] + $golesFavor;
        $contra = $equipoData['contra'] + $golesContra;
        $diferencia = $favor - $contra;
        $puntos = $equipoData['puntos'];

        // Actualización de estadísticas según el resultado
        if ($estado == "Gano") {
            $victorias += 1;
            $puntos += 3;
        } elseif ($estado == "Empato") {
            $empates += 1;
            $puntos += 1;
        } elseif ($estado == "Perdio") {
            $derrotas += 1;
        }

        // Actualizar la tabla con los nuevos valores
        $updateQuery = "UPDATE tbl_equipos 
                        SET partidos = $partidos, 
                            victorias = $victorias, 
                            empates = $empates, 
                            derrrotas = $derrotas, 
                            favor = $favor, 
                            contra = $contra, 
                            dfg = $diferencia, 
                            puntos = $puntos 
                        WHERE nombres = '$equipo'";

        $updateResult = pg_query($conexion, $updateQuery);

        if ($updateResult) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Datos actualizados correctamente',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'tabla.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar los datos.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'tabla.php';
                    }
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Equipo no encontrado.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'tabla.php';
                }
            });
        </script>";
    }

    pg_close($conexion);
}
?>
</body>
</html>