<?php
include("../../abrir_conexion.php");
$fecha='2024-08-18';
if (isset($_POST['serie']) && isset($_POST['opcion'])) {
    $serie = $_POST['serie'];
    $opcion = $_POST['opcion'];
    
    // Inicializar la variable de SQL
    $sql = "";

    if ($opcion == "tabla") {
        // Lógica para obtener y mostrar la tabla
        $sql = "SELECT nombres, partidos, victorias, empates, derrrotas, favor, contra, dfg, puntos
                FROM tbl_equipos 
                WHERE serie = '$serie'
                ORDER BY puntos DESC, dfg DESC, favor DESC, contra ASC;";
        
        $result = pg_query($conexion, $sql);

        if ($result) {
            echo "<table class='table table-bordered table-hover table-sm'>";
            echo "<thead class='table-success'>
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

    } elseif ($opcion == "goles_semana") {
         
                                                     
        $sql = "SELECT td.apellidos, td.nombres, eq.nombres AS promo, SUM(mo.goles) AS total_goles
                FROM tbl_movimientos mo
                JOIN tbl_deportista td ON td.iddeportista = mo.iddeportista
                JOIN tbl_equipos eq ON eq.idcodigo = td.idcodigo
                WHERE eq.serie = $1
                AND mo.fecha = $2 AND mo.goles > 0
                GROUP BY td.apellidos, td.nombres, eq.nombres
                ORDER BY total_goles DESC";
        $params = array($serie, $fecha);
        $result = pg_query_params($conexion, $sql, $params);

    
        if ($result) {
            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table-primary'>
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Promoción</th>
                        <th>Goles</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='text-left'>" . htmlspecialchars($row['apellidos']) . "</td>";
                echo "<td class='text-left'>" . htmlspecialchars($row['nombres']) . "</td>";
                echo "<td>" . htmlspecialchars($row['promo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['total_goles']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            pg_free_result($result);
        } else {
            echo "<p class='text-danger'>No se encontraron resultados.</p>";
        }
     
        
      
    } elseif ($opcion == "goleadores") {
         
        include("../../abrir_conexion.php");
        
        $sql = "SELECT td.apellidos, td.nombres, eq.nombres AS promo, SUM(mo.goles) AS total_goles
                FROM tbl_movimientos mo
                JOIN tbl_deportista td ON td.iddeportista = mo.iddeportista
                JOIN tbl_equipos eq ON eq.idcodigo = td.idcodigo
                WHERE eq.serie = $1
                 AND mo.goles > 0
                GROUP BY td.apellidos, td.nombres, eq.nombres
                ORDER BY total_goles DESC";
        
        $params = array($serie);
        $result = pg_query_params($conexion, $sql, $params);
        
        if ($result) {
            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table-info'>
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Promoción</th>
                        <th>Goles</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
        
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='text-left'>" . htmlspecialchars($row['apellidos']) . "</td>";
                echo "<td class='text-left'>" . htmlspecialchars($row['nombres']) . "</td>";
                echo "<td>" . htmlspecialchars($row['promo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['total_goles']) . "</td>";
                echo "</tr>";
            }
        
            echo "</tbody></table>";
        
            pg_free_result($result);
        } else {
            echo "<p class='text-danger'>No se encontraron resultados.</p>";
        }
        
        

    } elseif ($opcion == "tarjetas_amarillas") {
      

        $sql = "SELECT td.apellidos, td.nombres, eq.nombres AS promo, mo.tarjetas_amarillas
                FROM tbl_movimientos mo
                JOIN tbl_deportista td ON td.iddeportista = mo.iddeportista
                JOIN tbl_equipos eq ON eq.idcodigo = td.idcodigo
                WHERE mo.fecha = $1
                AND eq.serie = $2
                AND mo.tarjetas_amarillas > 0
                AND (mo.estadoa IS NULL OR mo.estadoa = '')
                ORDER BY mo.tarjetas_amarillas DESC";
        
        $params = array($fecha, $serie);
        $result = pg_query_params($conexion, $sql, $params);
        
        if ($result) {
            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table-warning'>
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Promoción</th>
                        <th>Amarillas</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
        
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='text-left'>" . htmlspecialchars($row['apellidos']) . "</td>";
                echo "<td class='text-left'>" . htmlspecialchars($row['nombres']) . "</td>";
                echo "<td>" . htmlspecialchars($row['promo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tarjetas_amarillas']) . "</td>";
                echo "</tr>";
            }
        
            echo "</tbody></table>";
        
            pg_free_result($result);
        } else {
            echo "<p class='text-danger'>No se encontraron resultados.</p>";
        }
    
    } elseif ($opcion == "tarjetas_rojas") {
         
        $sql = "SELECT td.apellidos, td.nombres, eq.nombres AS promo, mo.tarjetas_rojas
                FROM tbl_movimientos mo
                JOIN tbl_deportista td ON td.iddeportista = mo.iddeportista
                JOIN tbl_equipos eq ON eq.idcodigo = td.idcodigo
                WHERE mo.fecha = $1
                AND eq.serie = $2
                AND mo.tarjetas_rojas > 0
                AND (mo.estador IS NULL OR mo.estador = '')
                ORDER BY mo.tarjetas_rojas DESC";
        
        $params = array($fecha, $serie);
        $result = pg_query_params($conexion, $sql, $params);
        
        if ($result) {
            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table-danger'>
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Promoción</th>
                        <th>Rojas</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
        
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='text-left'>" . htmlspecialchars($row['apellidos']) . "</td>";
                echo "<td class='text-left'>" . htmlspecialchars($row['nombres']) . "</td>";
                echo "<td>" . htmlspecialchars($row['promo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tarjetas_rojas']) . "</td>";
                echo "</tr>";
            }
        
            echo "</tbody></table>";
        
            pg_free_result($result);
        } else {
            echo "<p class='text-danger'>No se encontraron resultados.</p>";
        }
         
        
    }

    pg_close($conexion);
}
?>





