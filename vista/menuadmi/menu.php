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
            background-color: #f8f9fa; /* Color de fondo del encabezado */
        }

        .navbar-brand {
            color: #343a40; /* Color del texto del enlace Menú */
        }

        .navbar-nav .nav-item .nav-link {
            color: #343a40; /* Color del texto de los enlaces del menú */
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #007bff; /* Color del texto del enlace del menú al pasar el mouse */
        }

        .footer {
            background-color: #343a40; /* Color de fondo del pie de página */
            color: white; /* Color del texto del pie de página */
            text-align: center; /* Alinear el texto al centro */
            padding: 10px; /* Espaciado interno del pie de página */
            position: absolute; /* Posición absoluta */
            bottom: 0; /* Alinear al fondo */
            width: 100%; /* Ancho completo */
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Menú</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto"> <!-- Alineación a la derecha -->
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/delegado/delegado.php">Delegados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/usuarios/usuarios.php">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/equipos/equipos.php">Equipos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/ldeportista/equipos.php">Jugadores * Equipo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/Jugadores/jugadores.php">Tarj/Goles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/Tabla/tabla.php">Reg. Tabla Pos.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/series/equipos.php">Fixture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../vista/Tabla2/tabla.php">Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php">Cerrar</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <?php
        session_start();
        $usuario = $_SESSION['misession']['usuario'];
        $idcodigo = $_SESSION['misession']['usuario'];
       
        ?>

        <main class="contenido">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h2 id="heading">Bienvenidoooo: <?php echo htmlspecialchars($usuario); ?></h2>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
 
       
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

