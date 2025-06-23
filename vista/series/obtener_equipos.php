<?php
// Incluir el archivo de conexión
include("../../abrir_conexion.php");

// Obtener la serie seleccionada
$serie = $_POST['serie'];

// Consulta para obtener los equipos según la serie seleccionada
$query_equipos = "SELECT nombres, serie FROM tbl_equipos WHERE serie = $1 ORDER BY nombres";
$resultados_equipos = pg_query_params($conexion, $query_equipos, array($serie));

// Comprobar si se encontraron equipos
if (pg_num_rows($resultados_equipos) > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>Item</th><th>Nombres</th><th>Serie</th></tr></thead>';
    echo '<tbody>';
    $fila=0;
    while ($row = pg_fetch_assoc($resultados_equipos)) {
        $fila++;
        echo "<tr>";
        echo "<td>{$fila}</td>";
        echo "<td>{$row['nombres']}</td>";
        echo "<td>{$row['serie']}</td>";
        echo "</tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<div class="alert alert-warning" role="alert">No hay equipos en esta serie.</div>';
}

// Liberar el resultado
pg_free_result($resultados_equipos);

// Cerrar la conexión
pg_close($conexion);
?>
