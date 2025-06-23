<?php
///registrar delegados
$host = "192.168.20.1";
$dbname = "cippiura";
$user = "cip2018";
$password = "cip_102080";

 

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idcodigo = $_POST['idcodigo'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $celular = $_POST['celular'];
        $email = $_POST['email'];
        $dni = $_POST['dni'];
        $direccion = $_POST['direccion'];
        $promocion = $_POST['promocion'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        $sql = "INSERT INTO tbl_personas (idcodigo, nombres, apellidos, celular, email, dni, direccion, promocion, fecha_nacimiento) 
                VALUES (:idcodigo, :nombres, :apellidos, :celular, :email, :dni, :direccion, :promocion, :fecha_nacimiento)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idcodigo', $idcodigo);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':promocion', $promocion);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center mt-4'>Registro exitoso.</div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-4'>Error al registrar.</div>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
