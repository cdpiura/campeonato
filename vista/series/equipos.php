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
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .table-container {
            margin: 20px auto;
            width: 90%;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #d6eaff;
        }
        .btn-return {
            margin: 20px 0;
            display: block;
        }
    </style>
    <script>
        function cargarEquiposPorSerie(serie) {
            $.ajax({
                url: 'obtener_equipos.php',
                type: 'POST',
                data: { serie: serie },
                success: function(data) {
                    $('#mostrar_mensaje').html(data);
                }
            });
        }

        function confirmarGenerarFixture() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas generar el fixture?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, generar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    generarFixture();
                }
            });
        }

        function generarFixture() {
            const serie = document.getElementById('txtserie').value;
            $.ajax({
                url: 'generar_fixture.php',
                type: 'POST',
                data: { serie: serie },
                success: function(response) {
                    $('#mostrar_mensaje').html(response);
                    Swal.fire(
                        '¡Generado!',
                        'El fixture ha sido generado exitosamente.',
                        'success'
                    );
                },
                error: function() {
                    Swal.fire(
                        'Error',
                        'Hubo un problema al generar el fixture.',
                        'error'
                    );
                }
            });
        }

        function verfixture() {
            const serie = document.getElementById('txtserie').value;
            window.location.href = 'ver_fixture.php?serie=' + serie;
        }

        function cerrar() {
            window.location.href = '../menuadmin/menu.php';
        }
    </script>
</head>
<body>
    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <h2 id="heading">Registro de Equipos</h2>
            <form method="POST" action=" " enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="etiqueta-color" for="txtserie">Serie</label>
                            <select size="1" required name="txtserie" id="txtserie" class="form-control" onchange="cargarEquiposPorSerie(this.value)">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <!--   <button class="btn btn-primary" type="button" name="generarFixture" id="generarFixture" onclick="confirmarGenerarFixture()">Generar Fixture</button>-->
                           <button class="btn btn-secondary" type="button" name="verFixture" id="verFixture" onclick="verfixture()">Ver Fixture</button>
                           <button class="btn btn-danger" type="button" name="Cerrar" id="Cerrar" onclick="cerrar();">Cerrar</button>
                        </div>
                    </div>
                </div>
            </form>

            <h1></h1>
            <div id="mostrar_mensaje"></div>
        </main>

        <footer class="footer">
            <h5>@ Todos los derechos Reservados. </h5>
        </footer>
    </div>
</body>
</html>





