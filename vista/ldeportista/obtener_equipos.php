<?php
// obtener_equipos.php
include("../../abrir_conexion.php");

if (isset($_POST['idcodigo'])) {
    $idcodigo = $_POST['idcodigo'];

    // Consulta para obtener los equipos
    $query_equipos = "SELECT * FROM tbl_deportista WHERE idcodigo='$idcodigo' ORDER BY apellidos";
    $resultados_equipos = pg_query($conexion, $query_equipos);

    // Generar HTML para la tabla
    $output = '';
    $c = 0;
    while ($row = pg_fetch_assoc($resultados_equipos)) {
        $c++;
        
        // Obtener el número de tarjetas rojas
        $query_rojas = "SELECT COALESCE(SUM(tarjetas_rojas), 0) AS rojas FROM tbl_movimientos WHERE tarjetas_rojas > 0 AND iddeportista='{$row['iddeportista']}'";
        $resultados_rojas = pg_query($conexion, $query_rojas);
        $row_rojas = pg_fetch_assoc($resultados_rojas);
        $tarjetas_rojas = $row_rojas['rojas'];

        // Obtener el número de tarjetas amarillas
        $query_amarillas = "SELECT COALESCE(SUM(tarjetas_amarillas), 0) AS amarillas FROM tbl_movimientos WHERE tarjetas_amarillas > 0 AND iddeportista='{$row['iddeportista']}'";
        $resultados_amarillas = pg_query($conexion, $query_amarillas);
        $row_amarillas = pg_fetch_assoc($resultados_amarillas);
        $tarjetas_amarillas = $row_amarillas['amarillas'];

        // Obtener el número de goles
        $query_goles = "SELECT COALESCE(SUM(goles), 0) AS goles FROM tbl_movimientos WHERE goles > 0 AND iddeportista='{$row['iddeportista']}'";
        $resultados_goles = pg_query($conexion, $query_goles);
        $row_goles = pg_fetch_assoc($resultados_goles);
        $goles = $row_goles['goles'];

        // Determinar el estado
        $estado = ($row['estado'] == '1') ? 'A' : 'I';

        // Establecer color basado en el estado
        $color = ($estado === 'A') ? 'blue' : 'red';

        // Construir la fila de la tabla
        $output .= "<tr>";
        $output .= "<td>{$c}</td>";
        $output .= "<td>{$row['apellidos']} {$row['nombres']}</td>";
        $output .= "<td>{$tarjetas_rojas}</td>"; // Mostrar tarjetas rojas
        $output .= "<td>{$tarjetas_amarillas}</td>"; // Mostrar tarjetas amarillas
        $output .= "<td>{$goles}</td>"; // Mostrar goles
        $output .= "<td style='color: {$color};'>{$estado}</td>";
        $output .= "</tr>";

        // Liberar los resultados de las consultas adicionales
        pg_free_result($resultados_rojas);
        pg_free_result($resultados_amarillas);
        pg_free_result($resultados_goles);
    }

    // Liberar el resultado principal
    pg_free_result($resultados_equipos);
    pg_close($conexion);

    echo $output;
}
?>
