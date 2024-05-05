<!--?php
   // Dirección o IP del servidor MySQL
   $host = "localhost";
   // Puerto del servidor MySQL
   $puerto = "3306";
   // Nombre de usuario del servidor MySQL
   $usuario = "root";
   // Contraseña del usuario
   $contrasena = "";
   // Nombre de la base de datos 
   $baseDeDatos = "sistemaabarrotes"; 
   // Nombre de la tabla a trabajar 
   $tabla = "productos";
   
   $enlace = mysqli_connect($host.":".$puerto, $usuario, $contrasena, $baseDeDatos);
   if (!$enlace){
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "Error: de depuración:" . mysqli_connect_error() . PHP_EOL;
    exit();
   }
   echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial.";
   echo "Información del host: " . mysqli_get_host_info($enlace) . PHP_EOL;
?-->
<?php
$host = "localhost"; //ruta de la base de datos ó link de la pagina
$usuario = "root"; //cambiar
$contrasena = ""; 
$baseDeDatos = "sistemaabarrotes";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $baseDeDatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
