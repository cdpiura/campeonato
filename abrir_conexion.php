<?php
// Parámetros de conexión
$host     = "localhost";
$port     = "5432";
$dbname   = "data";
$user     = "miusuario";
$password = "Camila@2025@";

// Cadena de conexión
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Intentar conectar
$conexion = pg_connect($conn_string);

// Verificamos la conexión
if (!$conexion) {
    echo "❌ Error: No se pudo conectar a la base de datos PostgreSQL.";
} else {
   /// echo "✅ Conexión exitosa a la base de datos PostgreSQL.";
}
?>
