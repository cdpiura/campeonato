<html lang="es">
<head>
        <title>Registrar  Datos de Delegados </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0.js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src=" https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link rel="stylesheet" href="css/estilos.css">
	</head>
<body>
<header>


<?php
// Insertar Usuarios
include("../../abrir_conexion.php");
 

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Capturar los datos del formulario
    $persona = $_POST['txtpersona'];
    $usuario = $_POST['txtusuario'];
    $clave = $_POST['txtclave'];
    $serie = $_POST['txtserie'];
    $nivel = $_POST['txtnivel'];
    $estado='0';

    $resultados = pg_query($conexion,"SELECT * FROM  tbl_cusuarios  WHERE  idcodigo='$persona'");
                            
    $registros = pg_num_rows($resultados);
    if ($registros<=0)
    { 
 
                // Validar que los datos no estén vacíos
                if (!empty($persona) && !empty($usuario) && !empty($clave) && !empty($serie) && !empty($nivel))
                {
                                        // Consulta para insertar los datos en la tabla correspondiente
                                        $query_insert = "INSERT INTO tbl_cusuarios (idcodigo, usuario, clave, serie, nivel,estado) 
                                                        VALUES ($1, $2, $3, $4, $5, $6)";
                                        // Preparar la consulta
                                        $result_insert = pg_prepare($conexion, "insert_query", $query_insert);
                                        // Ejecutar la consulta
                                        $result_insert = pg_execute($conexion, "insert_query", array($persona, $usuario, $clave, $serie, $nivel,$estado));
                                        // Verificar si la inserción fue exitosa
                                if ($result_insert)
                                {
                                                        ?>
                                                        <script>
                                                                Swal.fire({
                                                                        position: "top-end",
                                                                        icon: "success",
                                                                        title: "Datos Actualizados Correctamente",
                                                                        showConfirmButton: false,
                                                                        timer: 1500
                                                                }).then(() => {
                                                                        // Redirigir al usuario a otra página
                                                                        window.location.href = 'usuarios.php';
                                                                });
                                                        </script>  
                                                        <?php    
                                } 
                                else
                                {
                                
                                        ?>
                                        <script>
                                                        Swal.fire({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: 'No se Pudo  Realizar Registro!',
                                                                footer: '<a href=\"#\">Why do I have this issue?</a>'
                                                        }).then((result) => {
                                                                // Mantener al usuario en el formulario
                                                                if (result.isConfirmed) {
                                                                window.location.href = 'usuarios.php';
                                                                
                                                                }
                                                        });
                                        </script>
                                        <?php
                                }
                } 
                else
                {
                                ?>
                                <script>
                                                Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: 'No se Pudo  Realizar Registro!',
                                                        footer: '<a href=\"#\">Why do I have this issue?</a>'
                                                }).then((result) => {
                                                        // Mantener al usuario en el formulario
                                                        if (result.isConfirmed) {
                                                        window.location.href = 'usuarios.php';
                                                        
                                                        }
                                                });
                                </script>
                                <?php
                }

}
else
{
                ?>
                <script>
                                Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No se Pudo  Realizar Registro!,Usuario Ya Existe',
                                        footer: '<a href=\"#\">Why do I have this issue?</a>'
                                }).then((result) => {
                                        // Mantener al usuario en el formulario
                                        if (result.isConfirmed) {
                                        window.location.href = 'usuarios.php';
                                        
                                        }
                                });
                </script>
                <?php
        
}
} 
 
 
// Cerrar la conexión
pg_close($conexion);
?>
</body>
</html>