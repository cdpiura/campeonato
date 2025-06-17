<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title>Consultar Información JCM</title>
    <link rel="shortcut icon" href="img/favicon.ico" />
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<header>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que se haya proporcionado el recaptcha-response
    if (isset($_POST['g-recaptcha-response'])) {
        // Verificar la validez del token
        $url = 'https://www.google.com/recaptcha/api/siteverify';


        $secret_key = '6LdDmh4oAAAAAMv0FFKIsaKdgF9nTkmKhLyWy4H4';        
 //	$secret_key = '6LfVMB4oAAAAACs3ShDqe2XNH5foEkMVQS8qMbVs';
        
        $response_key = $_POST['g-recaptcha-response'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $url = $url.'?secret='.$secret_key.'&response='.$response_key.'&remoteip='.$user_ip;

        $response = file_get_contents($url);
        $response = json_decode($response);

        // Si el token es válido, procesar el formulario
        if ($response->success) {
            include("abrir_conexion.php");
            $nombre_correo = $_POST['txtcorreo'];
            $dni = $_POST['txtdni'];

            if ($nombre_correo !== '' && $dni !== '') {
                $resultados = pg_prepare($conexion, "consulta_usuario", "SELECT * FROM tbl_cusuarios WHERE usuario = $1 AND clave = $2");
                $resultados = pg_execute($conexion, "consulta_usuario", array($nombre_correo, $dni));
                
                if (!$resultados) {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Uups...',
                                text: 'Error en la consulta de usuario.',
                                footer: '<a href=\"https://intranet.cippiura.org/estados/vista/estado_cuenta/\">Puedes Verificar tu Información?</a>'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'index.php';
                                }
                            });
                          </script>";
                } else {
                    $registros = pg_num_rows($resultados);
                    if ($registros >= 1) {
                        $row = pg_fetch_assoc($resultados);
                        $idcodigo = $row['idcodigo']; // Captura el campo idcodigo
                        $nivel = $row['nivel']; // Captura el campo idcodigo
                     
                        // Preparar y ejecutar la consulta para obtener la persona asociada
                        $resul = pg_prepare($conexion, "consulta_persona", "SELECT * FROM tbl_personas WHERE idcodigo = $1");
                        $resul = pg_execute($conexion, "consulta_persona", array($idcodigo));
                        $row2 = pg_fetch_assoc($resul);
                        $nusuario = $row2['apellidos']; // Captura el campo idcodigo
                        $ausuario = $row2['nombres']; // Captura el campo idcodigo
                        $serie = $row2['serie']; // Captura el campo idcodigo
                        if (!$resul) {
                            echo "Error en la consulta de tbl_personas.";
                            exit;
                        } else {
                            session_start();
                            $_SESSION['misession'] = array();
                            $_SESSION['misession']['idcodigo'] = $idcodigo;
                            $_SESSION['misession']['usuario'] = $ausuario." , ".$nusuario;
                            $_SESSION['misession']['nivel'] = $nivel;
                            $_SESSION['misession']['serie'] = $serie;

                           if ($nivel == "ADMINISTRADOR")
                                 {       echo "<script>
                                                window.location.href = 'vista/menuadmin/menu.php';
                                            </script>";
                                 }      

                            else          

                              { echo "<script>
                                   
                                     window.location.href = 'vista/menudele/menu.php';
                                </script>";
                                
                            }
                            include("abrir_conexion.php");
                            pg_close($conexion);
                                                   
                        }
                    } else {
                        echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Uups...',
                                    text: 'Usuario o contraseña incorrectos.',
                                    footer: '<a href=\"https://intranet.cippiura.org/estados/vista/estado_cuenta/\">Puedes Verificar tu Información?</a>'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'index.php';
                                    }
                                });
                              </script>";
                    }
                }
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Uups...',
                            text: 'Por favor, completa todos los campos.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php';
                            }
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Uups...',
                        text: 'Verifica CAPTCHA!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Uups...',
                    text: 'Verifica CAPTCHA!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
              </script>";
    }
    include("abrir_conexion.php");
    pg_close($conexion);
}
?>
<script type="text/javascript">
    function mostrar() {
        swal('Verificar');
    }
</script>
</body>
</html>


