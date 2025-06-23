<?php
include("../../abrir_conexion.php");

if (isset($_POST['serie'])) {
    $serie = $_POST['serie'];

    $sql = "SELECT nombres, partidos, victorias, empates, derrrotas, favor, contra, dfg, puntos
            FROM tbl_equipos 
            WHERE serie = '$serie'
            ORDER BY puntos DESC, dfg DESC, favor DESC, contra ASC;";

    $result = pg_query($conexion, $sql);

    if ($result) {
        echo "<table class='table table-bordered table-hover table-sm'>";
        echo "<thead class='thead-dark'>
                <tr>
                    <th>Nombres</th>
                    <th>Pts</th>
                    <th>PJ</th>
                    <th>PG</th>
                    <th>PE</th>
                    <th>PP</th>
                    <th>GF</th>
                    <th>GC</th>
                    <th>Dif</th>
                </tr>
              </thead>";
        echo "<tbody>";

        $contador = 1; // Inicializamos el contador

        while ($row = pg_fetch_assoc($result)) {
            // Aplica color rojo a las primeras 4 posiciones
            $rowColor = $contador <= 4 ? 'table-danger' : '';
            
            echo "<tr class='$rowColor'>";
            echo "<td class='text-left'>" . htmlspecialchars($row['nombres']) . "</td>";
            echo "<td>" . htmlspecialchars($row['puntos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['partidos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['victorias']) . "</td>";
            echo "<td>" . htmlspecialchars($row['empates']) . "</td>";
            echo "<td>" . htmlspecialchars($row['derrrotas']) . "</td>";
            echo "<td>" . htmlspecialchars($row['favor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['contra']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dfg']) . "</td>";
            echo "</tr>";

            $contador++; // Incrementamos el contador
        }

        echo "</tbody></table>";
    }

    pg_close($conexion);
}
?>

