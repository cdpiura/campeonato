<?php
include("../../abrir_conexion.php");

$serie = $_GET['serie'];
$limit = 4; // Número de registros por página
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Obtener el total de registros
$total_query = "SELECT COUNT(*) FROM tbl_fixture WHERE serie = '$serie'";
$total_result = pg_query($conexion, $total_query);
$total_row = pg_fetch_row($total_result);
$total_records = $total_row[0];
$total_pages = ceil($total_records / $limit);

// Obtener los registros para la página actual
$query = "
    SELECT
        f.nombre_fecha,
        f.serie,
        f.fecha,
        f.año,
        e1.nombres AS equipo1,
        e2.nombres AS equipo2
    FROM
        public.tbl_fixture f
    JOIN
        public.tbl_equipos e1 ON f.idequipo1 = e1.idequipo
    JOIN
        public.tbl_equipos e2 ON f.idequipo2 = e2.idequipo
    WHERE
        f.serie = '$serie'
    ORDER BY
        f.nombre_fecha ASC
    LIMIT $limit OFFSET $offset";

$result = pg_query($conexion, $query);

// Almacenar los equipos y puntajes para la fecha específica
$equipos_2024_08_11 = [];
$otros_equipos = [];

while ($row = pg_fetch_assoc($result)) {
    if ($row['fecha'] == '2024-08-25') {
        $cabecera='Puntos';
        $equipo1 = $row['equipo1'];
        $total_query = "SELECT SUM(puntos) as spuntos FROM tbl_equipos WHERE nombres = '$equipo1'";
        $total_result = pg_query($conexion, $total_query);
        $total_row = pg_fetch_assoc($total_result);
        $suma_puntos = $total_row['spuntos'];

        $equipo2 = $row['equipo2'];
        $total_query = "SELECT SUM(puntos) as spuntos FROM tbl_equipos WHERE nombres = '$equipo2'";
        $total_result = pg_query($conexion, $total_query);
        $total_row = pg_fetch_assoc($total_result);
        $suma_puntos2 = $total_row['spuntos'];

        $resultado = $suma_puntos + $suma_puntos2;

        // Almacenar en el array específico
        $equipos_2024_08_11[] = [
            'puntos' => $resultado,
            'fecha' => $row['fecha'],
            'equipo1' => $equipo1,
            'equipo2' => $equipo2,
        ];
    } else {
        // Almacenar otros partidos en su orden natural
        $cabecera='Hora';
        $otros_equipos[] = $row;
    }
}

// Método de la burbuja para ordenar el array de la fecha específica por 'puntos'
$n = count($equipos_2024_08_11);
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - $i - 1; $j++) {
        if ($equipos_2024_08_11[$j]['puntos'] > $equipos_2024_08_11[$j + 1]['puntos']) {
            // Intercambiar
            $temp = $equipos_2024_08_11[$j];
            $equipos_2024_08_11[$j] = $equipos_2024_08_11[$j + 1];
            $equipos_2024_08_11[$j + 1] = $temp;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Equipos</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="../../css/main.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <div class="container">
                <h2 class="text-center">Fixture Serie <?php echo htmlspecialchars($serie); ?></h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $cabecera?></th>
                            <th>Fecha del Partido</th>
                            <th>Equipo A</th>
                            <th>Equipo B</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Mostrar los equipos para la fecha 2024-08-11
                        foreach ($equipos_2024_08_11 as $equipo) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($equipo['puntos']) . "</td>";
                            echo "<td>" . htmlspecialchars($equipo['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($equipo['equipo1']) . "</td>";
                            echo "<td>" . htmlspecialchars($equipo['equipo2']) . "</td>";
                            echo "</tr>";
                        }
                        
                        // Mostrar otros equipos
                        foreach ($otros_equipos as $row) {
                            echo "<tr>";
                            echo "<td>00:00:00</td>";
                            echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['equipo1']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['equipo2']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="ver_fixture.php?serie=<?php echo htmlspecialchars($serie); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>

                <button class="btn btn-primary" onclick="volver()">Volver a Fixture</button>
            </div>
            <script>
    function volver() {
        window.location.href = 'equipos.php'; // Cambia 'equipos.php' por la URL de tu página principal
    }
</script>
        </main>
   



