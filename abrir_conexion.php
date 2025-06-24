<?php
// Parámetros de conexión
 $host     = "db.dwlcppphdvrgewkvzbpi.supabase.co";  // El host proporcionado por Supabase
$port     = "5432";  // Puerto estándar de PostgreSQL
$dbname   = "postgres";  // Nombre de la base de datos (si es postgres por defecto, si no usa otro nombre)
$user     = "postgres";  // Usuario de conexión a la base de datos
$password = "Camila@2025@";  // Contraseña de la base de datos

// Cadena de conexión
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Conexión a la base de datos
$conn = pg_connect($conn_string);

if (!$conn) {
    echo "Error: No se pudo conectar a la base de datos.";
} else {
    echo "Conexión exitosa a la base de datos.";
}


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
