<?php
include("../../abrir_conexion.php");

$query = isset($_POST['query']) ? $_POST['query'] : '';

$query_equipos = "SELECT 
    td.iddeportista, 
    td.nombres AS nombres_deportista, 
    td.apellidos AS apellidos_deportista, 
    p.serie
FROM 
    public.tbl_deportista td 
INNER JOIN 
    public.tbl_personas p 
ON 
    td.idcodigo = p.idcodigo";

if ($query !== '') {
    $query_equipos .= " WHERE td.nombres ILIKE $1 OR td.apellidos ILIKE $1";
    $params = array('%'.$query.'%');
} else {
    $params = array(); // No hay parámetros cuando no hay búsqueda
}

$query_equipos .= " ORDER BY p.promocion, p.serie ASC";

// Preparar y ejecutar la consulta
$resultados_equipos = pg_prepare($conexion, "buscar_jugadores", $query_equipos);
$resultados_equipos = pg_execute($conexion, "buscar_jugadores", $params);

if (!$resultados_equipos) {
    echo "<tr><td colspan='3'>Error en la consulta: " . pg_last_error($conexion) . "</td></tr>";
} elseif (pg_num_rows($resultados_equipos) > 0) {
    while ($row = pg_fetch_assoc($resultados_equipos)) {
        $nombreCompleto = htmlspecialchars($row['nombres_deportista']) . ' ' . htmlspecialchars($row['apellidos_deportista']);
        echo "<tr>";
        echo "<td><input type='checkbox' name='seleccion[]' value='" . htmlspecialchars($row['iddeportista']) . "' data-nombre='" . $nombreCompleto . "'> " . htmlspecialchars($row['apellidos_deportista']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nombres_deportista']) . "</td>";
        echo "<td>" . htmlspecialchars($row['serie']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No se encontraron resultados</td></tr>";
}

pg_free_result($resultados_equipos);
pg_close($conexion);
?>
