<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCESO DE CAMPEONATO JCM 2024</title>
    <link rel="shortcut icon" href="img/favicon.ico" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php	
       /// unset($_SESSION['misesion']);
        $key="6LdDmh4oAAAAADGTxft4SHEOunJisncT_ud1voKd";
        //$key="6LfVMB4oAAAAAFbZFvXyRYwZY9MoL3GEQAjY_0y3";

    ?>   

    <div class="formulario">
    <h1 style="color: #033b5c;">DIRECTIVA 2024</h1>
        <form action="codigo.php" method="POST">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 col-4">
                            <div class="form-group">
                                <img src="img/logomari2.png" alt="Logo">
                            </div>
                        </div>
                        <div class="col-sm-4 col-4">
                            <div class="form-group" style="text-align: center;">
                                <h3 style="color: #033b5c; font-size: 18px;">ACCESO DELEGADOS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="username">
                <input type="text" required placeholder="Usuario (Delegado)" name="txtcorreo" require title="Por favor, Registre su Usuario Personal  Registrado en el Cd Piura">
                <label>Usuario</label>
            </div>

            <div class="username">
                <input type="password" required placeholder="Password" name="txtdni"  require title="Por favor, Registre su Password">
                <label>Password</label>
            </div>

            

            <input type="submit" value="ACCESO">
            <div class="registrarse">
                <div class="g-recaptcha" data-sitekey=<?=$key?>></div>
            </div>
           
        </form>
    </div>
</body>

</html>
