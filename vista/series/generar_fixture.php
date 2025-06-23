<?php
include("../../abrir_conexion.php");

$serie = $_POST['serie'];

// Obtener todos los equipos de la serie seleccionada
$query_equipos = "SELECT idequipo, nombres FROM tbl_equipos WHERE serie = '$serie'";
$resultados_equipos = pg_query($conexion, $query_equipos);

$equipos = array();
while ($row = pg_fetch_assoc($resultados_equipos)) {
    $equipos[] = $row;
}

// Crear los encuentros distribuidos por fechas
$fixture = array();
$num_equipos = count($equipos);
$nombre_fecha = 1;
$start_date = '2024-07-28'; // Fecha de inicio
$current_date = strtotime($start_date);

for ($i = 0; $i < $num_equipos - 1; $i++) {
    for ($j = 0; $j < $num_equipos / 2; $j++) {
        $equipo1_index = ($i + $j) % ($num_equipos - 1);
        $equipo2_index = ($num_equipos - 1 - $j + $i) % ($num_equipos - 1);

        if ($j == 0) {
            $equipo2_index = $num_equipos - 1;
        }

        $fixture[] = array(
            'equipo1' => $equipos[$equipo1_index]['idequipo'],
            'equipo2' => $equipos[$equipo2_index]['idequipo'],
            'fecha' => date('Y-m-d', $current_date),
            'nombre_fecha' => $nombre_fecha
        );
    }
    $nombre_fecha++;
    $current_date = strtotime('+7 days', $current_date); // Sumar 7 días a la fecha actual
}

// Insertar los encuentros en la base de datos
foreach ($fixture as $encuentro) {
    $idequipo1 = $encuentro['equipo1'];
    $idequipo2 = $encuentro['equipo2'];
    $nombre_fecha = $encuentro['nombre_fecha'];
    $fecha = $encuentro['fecha'];
    $lugar = 'Estadio Principal'; // Puedes personalizar el lugar según necesites
    $hora = '15:00'; // Puedes personalizar la hora según necesites
    $año = date('Y', strtotime($fecha)); // Obtener el año de la fecha
    $estado = 1; // Puedes personalizar el estado según necesites

    $query_insertar = "INSERT INTO tbl_fixture (idequipo1, idequipo2, nombre_fecha, serie, lugar, hora, fecha, año, estado)
                       VALUES ('$idequipo1', '$idequipo2', '$nombre_fecha', '$serie', '$lugar', '$hora', '$fecha', '$año', '$estado')";
    pg_query($conexion, $query_insertar);
}

pg_free_result($resultados_equipos);
pg_close($conexion);

echo "Fixture generado correctamente para la serie $serie.";
echo "<script>
    setTimeout(function() {
        window.location.href = 'ver_fixture.php?serie=$serie';
    }, 3000);
</script>";
?>
