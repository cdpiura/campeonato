<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menú Interactivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="../../css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <style>
        .header {
            padding: 10px;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            color: #343a40;
        }

        .navbar-nav .nav-item .nav-link {
            color: #343a40;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #007bff;
        }

        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .table-container {
            margin-bottom: 20px;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 14px; /* Tamaño de letra más pequeño */
        }

        .table tbody tr {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .table tbody td {
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px; /* Tamaño de letra más pequeño */
        }

        .table-responsive {
            overflow-x: auto;
        }

        .usuario-info {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $usuario = $_SESSION['misession']['usuario'];
    $idcodigo = $_SESSION['misession']['idcodigo'];
    $serie = $_SESSION['misession']['serie'];
       $fecha='2024-08-18';
    ?>
    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png" alt="Logo">
            <h4>Bienvenido : <?php echo $usuario ?></h4>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Menú</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/deportistas/principal.php">Registros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/ldeportista/equipos.php">Lista Serie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/seriesu/equipos.php">Fixture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Estadísticas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php">Cerrar</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <main class="contenido">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    
                                  <li class="nav-item">
                                        <a class="nav-link active" id="consulta1-tab" data-toggle="tab" href="#consulta1" role="tab" aria-controls="consulta1" aria-selected="true">Tabla Goles</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="consulta2-tab" data-toggle="tab" href="#consulta2" role="tab" aria-controls="consulta2" aria-selected="false">Rojas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="consulta3-tab" data-toggle="tab" href="#consulta3" role="tab" aria-controls="consulta3" aria-selected="false">Amarillas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="consulta4-tab" data-toggle="tab" href="#consulta4" role="tab" aria-controls="consulta4" aria-selected="false">Goles de Fecha</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="consulta5-tab" data-toggle="tab" href="#consulta5" role="tab" aria-controls="consulta5" aria-selected="false">Tabla</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="consulta1" role="tabpanel" aria-labelledby="consulta1-tab">
                                        <div class="table-container mt-3">
                                            <div class="table-responsive">
                                                <?php
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
                                                    echo "<table class='table'>";
                                                    echo "<thead><tr><th>Apellidos</th><th>Nombres</th><th>Promoción</th><th>Goles</th></tr></thead>";
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
                                                    echo "<p>No se encontraron resultados.</p>";
                                                }

                                                pg_close($conexion);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="consulta2" role="tabpanel" aria-labelledby="consulta2-tab">
                                        <div class="table-container mt-3 mb-5">
                                            <div class="table-responsive">
                                                <?php
                                                include("../../abrir_conexion.php");

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
                                                    echo "<table class='table'>";
                                                    echo "<thead><tr><th>Apellidos</th><th>Nombres</th><th>Promoción</th><th>Rojas</th></tr></thead>";
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
                                                    echo "<p>No se encontraron resultados.</p>";
                                                }

                                                pg_close($conexion);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="consulta3" role="tabpanel" aria-labelledby="consulta3-tab">
                                        <div class="table-container mt-3 mb-5">
                                            <div class="table-responsive">
                                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
                                                    <style>
                                                        .table {
                                                            font-size: 0.50rem; /* Tamaño de fuente más pequeño */
                                                        }

                                                        .table th, .table td {
                                                            padding: 0.25rem; /* Reducir el padding */
                                                            vertical-align: middle; /* Alineación vertical */
                                                        }

                                                        .table thead th {
                                                            font-size: 0.75rem; /* Tamaño de fuente más pequeño para el encabezado */
                                                        }

                                                        .table tbody td {
                                                            font-size: 0.75rem; /* Tamaño de fuente más pequeño para las celdas */
                                                        }

                                                        .table th, .table td {
                                                            text-align: center; /* Alinear texto al centro */
                                                        }

                                                        /* Anchos específicos para cada columna */
                                                        .table .col-nombres {
                                                            width: 120px; /* Ancho para la columna de nombres */
                                                        }

                                                        .table .col-numerica {
                                                            width: 80px; /* Ancho para columnas numéricas */
                                                        }
                                                    </style>
                                                <?php
                                                include("../../abrir_conexion.php");

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
                                                    echo "<table class='table'>";
                                                    echo "<thead><tr><th>Apellidos</th><th>Nombres</th><th>Promoción</th><th>Amarillas</th></tr></thead>";
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
                                                    echo "<p>No se encontraron resultados.</p>";
                                                }

                                                pg_close($conexion);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="consulta4" role="tabpanel" aria-labelledby="consulta4-tab">
                                            <div class="table-container mt-3">
                                                    <div class="table-responsive">
                                                        <?php
                                                        include("../../abrir_conexion.php");
                                                     
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
                                                            echo "<table class='table'>";
                                                            echo "<thead><tr><th>Apellidos</th><th>Nombres</th><th>Promoción</th><th>Goles</th></tr></thead>";
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
                                                            echo "<p>No se encontraron resultados.</p>";
                                                        }
                                                        pg_close($conexion);
                                                        ?>
                                                    </div>    
                                           </div>
                                    </div>

                                    <div class="tab-pane fade" id="consulta5" role="tabpanel" aria-labelledby="consulta5-tab">
                                        <div class="table-container mt-3 mb-5">
                                            <div class="table-responsive">
                                                <?php
                                                include("../../abrir_conexion.php");
                                                $sql = " SELECT nombres, partidos, victorias, empates,derrrotas, favor, contra, dfg, puntos, serie
                                                    FROM tbl_equipos where serie = '".$serie."'
                                                        ORDER BY puntos DESC, dfg DESC, favor DESC, contra ASC;";
                                
                                                    $result = pg_query($conexion, $sql);
                                            
                                                    if ($result) {
                                                        echo "<table class='table table-bordered table-sm'>";
                                                        echo "<thead><tr>
                                                                <th>Nombres</th>
                                                                <th>Pts</th>
                                                                <th>PJ</th>
                                                                <th>PG</th>
                                                                <th>PE</th>
                                                                <th>PP</th>
                                                                <th>GF</th>
                                                                <th>GC</th>
                                                                <th>Dif</th>
                                                            
                                                            </tr></thead>";
                                                        echo "<tbody>";
                                                        $contador=0;
                                                        while ($row = pg_fetch_assoc($result)) {
                                                            $contador++;
                                                            if ($contador <= 4) {
                                                                $color = "red";
                                                            } else {
                                                                $color = "black";
                                                            }
                                                            
                                                            echo "<tr>";
                                                            echo "<td class='text-left' style='color: $color;'>" . htmlspecialchars($row['nombres']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['puntos']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['partidos']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['victorias']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['empates']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['derrrotas']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['favor']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['contra']) . "</td>";
                                                            echo "<td style='color: $color;'>" . htmlspecialchars($row['dfg']) . "</td>";
                                                            echo "</tr>";
                                                            
                                                        
                                                        
                                                        
                                                             
                                                        }
                                            
                                                        echo "</tbody></table>";
                                                    }
                                
                                                  // Cerrar la conexión
                                                pg_close($conexion);
                                                ?>
                                            </div>
                                        </div>
                                    </div>



                                    
                                </div>
                            </div>
                            <div class="usuario-info">
                                <p>Usuario: <?php echo htmlspecialchars($usuario); ?></p>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
      
        
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>



