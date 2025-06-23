<?php
include("../../abrir_conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idcodigo = $_POST['idcodigo'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $serie = $_POST['serie'];
    $nivel = $_POST['nivel'];

    $query = "UPDATE tbl_cusuarios SET usuario='$usuario', clave='$clave', serie='$serie', nivel='$nivel' WHERE idcodigo='$idcodigo'";
    pg_query($conexion, $query);

    header("Location: usuarios.php");
}

$idcodigo = $_GET['id'];
$query = "SELECT * FROM tbl_cusuarios WHERE idcodigo='$idcodigo'";
$result = pg_query($conexion, $query);
$usuario = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="../../css/main.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@10"></script>
    <title>Editar Usuario</title>
</head>
<body>
    <div class="contenedor">
        <header class="header">
            <img src="../../img/logomari2.png">
        </header>
        <main class="contenido">
            <h2 id="heading">Editar Usuario</h2>
            <form method="POST" action="editar.php" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="idcodigo" value="<?php echo $usuario['idcodigo']; ?>">
                        <div class="form-group">
                            <label class="etiqueta-color" for="usuario">Usuario</label>
                            <input type="text" name="usuario" class="form-control" value="<?php echo $usuario['usuario']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="clave">Clave</label>
                            <input type="text" name="clave" class="form-control" value="<?php echo $usuario['clave']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="serie">Serie</label>
                            <input type="text" name="serie" class="form-control" value="<?php echo $usuario['serie']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="etiqueta-color" for="nivel">Nivel</label>
                            <input type="text" name="nivel" class="form-control" value="<?php echo $usuario['nivel']; ?>" required>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger">Actualizar</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <footer class="footer">
            <h5>@ Todos los derechos Reservados.</h5>
        </footer>
    </div>
</body>
</html>

