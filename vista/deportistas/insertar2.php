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
 include("../../abrir_conexion.php");
               session_start();
           
            //  $regidingeniero=$_SESSION['misession']['idingeniero'];
            $error1 = "";
            $error2 = "";
    ////Insertar Delegados
        $mi_cod = ltrim($_POST['txtcod']);	
        $mi_apell = ltrim($_POST['txtapell']);	
        $mi_nomb = ltrim($_POST['txtnomb']);	
        $mi_fecha = ltrim($_POST['txtfecha']);
        $mi_dni = ltrim($_POST['txtdni']);
        $mi_celular = ltrim($_POST['txtcelular']);
        $mi_email = ltrim($_POST['txtemail']);
        $mi_parentesco =ltrim( $_POST['txtparentesco']);	
    
        if(empty($mi_apell) || empty($mi_nomb) || empty($mi_parentesco) || empty($mi_celular) || empty($mi_dni) || empty($mi_fecha) )
        
       {
      
           ?>
           <script>   
           Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Registra Los Datos Completos!",
              footer: '<a href="#">Why do I have this issue?</a>'
            }).then((result) => {
                                        // Redirigir al usuario a otra página
                                        if (result.isConfirmed) {
                                                window.location.href = 'delegado.php';
                                        }
                                });

            </script>
                 <?php
        
        }
        else                   
        {         
                ///Fin Encontar el Numero de Registros
              //Encontrar El Dni del Nuevo Familiar
              $resulp = pg_query($conexion,"SELECT * FROM  tbl_personas WHERE  promocion='$mi_parentesco'");
                            
              $registrosp = pg_num_rows($resulp);
           
        
              if ($registrosp<=0)
              { 
                     
                         $resultados = pg_query($conexion,"SELECT * FROM  tbl_personas WHERE  dni='$mi_dni'");
                            
                            $registros = pg_num_rows($resultados);
                         
                      
                            if ($registros<=0)
                            { 
                                //poner ruta 
                            // Recogida y limpieza de datos
                                $mi_cod = trim($_POST['txtcod']);    
                                $mi_apell = trim($_POST['txtapell']);    
                                $mi_nomb = trim($_POST['txtnomb']);    
                                $mi_fecha = trim($_POST['txtfecha']);
                                $mi_dni = trim($_POST['txtdni']);
                                $mi_celular = trim($_POST['txtcelular']);
                                $mi_email = trim($_POST['txtemail']);
                                $mi_promocion = trim($_POST['txtparentesco']);    
                                
                                // Asegúrate de establecer una conexión antes de ejecutar la consulta
                                include("../../abrir_conexion.php");
                                
                                // Prepara la consulta SQL con placeholders para evitar inyecciones SQL
                                $sql = "INSERT INTO tbl_personas (
                                    idcodigo, nombres, apellidos, celular, email, dni, promocion, fecha_nacimiento, estado, fecha)
                                    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
                                
                                // Prepara la declaración
                                $result = pg_prepare($conexion, "insert_query", $sql);
                                
                                // Valores adicionales
                                $mi_estado='0';
                                $fecha_actual = date("Y-m-d");
                                
                                // Ejecuta la declaración con los valores proporcionados
                                $result = pg_execute($conexion, "insert_query", array($mi_cod, $mi_nomb, $mi_apell, $mi_celular, $mi_email, $mi_dni, $mi_promocion, $mi_fecha, $mi_estado, $fecha_actual));
                                
                                if ($result) {
                                 ///   echo "Registro insertado correctamente.";
                                 ?>
                                 <script>
                                                 Swal.fire({
                                                         position: "top-end",
                                                         icon: "success",
                                                         title: "Datos Actualizados Correctamente,Felicidades",
                                                         showConfirmButton: false,
                                                         timer: 1500
                                                 }).then(() => {
                                                         // Redirigir al usuario a otra página
                                                         window.location.href = 'delegado.php';
                                                 });
                                         </script>      
                               <?php
                                } else {
                                        $error1 = "No se Puede Registrar los Datos";
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
                                                                   window.location.href = '/../menuadmin/menu.php';
                                                                   $errores[] = "No se Puede Registrar los Datos";
                                                                }
                                                        });
                                          </script>"
                                      <?php
                                }
                                
                                // Cierra la conexión
                                pg_close($conexion);
                       } 
                            else
                            {
                                $error2 = "El DNI ya Existe, Verificar";

                               
                                                        ?>
                                                        <script>
                                                        Swal.fire({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: 'DNI ya se Encuentra Registrado!',
                                                                footer: '<a href=\"#\">Why do I have this issue?</a>'
                                                        }).then((result) => {
                                                                // Mantener al usuario en el formulario
                                                                if (result.isConfirmed) {
                                                                      
                                                            //  window.location.href = '../menuadmin/menu.php';
                                                              window.location.href = 'delegado.php';
                                                                }
                                                        });
                                                        </script>
                                                                <?php
                            
                            }
                        }
                        else{
                                ?>
                                                        <script>
                                                        Swal.fire({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: 'Promoción ya se Encuentra Registrada!',
                                                                footer: '<a href=\"#\">Why do I have this issue?</a>'
                                                        }).then((result) => {
                                                                // Mantener al usuario en el formulario
                                                                if (result.isConfirmed) {
                                                                      
                                                            //  window.location.href = '../menuadmin/menu.php';
                                                              window.location.href = 'delegado.php';
                                                                }
                                                        });
                                                        </script>
                                                                <?php

                        }

        }
        
   

    ?>
 
  
</body>
</html>