<?php
// Configuración de la base de datos

 $servername = "localhost";
 $username = "root";
$password = "";
$dbname = "mispeliculas";

//Los datos en comentario estan rellenados del infinity free para cuando subimos el proyecto al servidor y no local. Así se conectara a la base de datos. Se tendrá que cambiar una conexión u otra dependiendo de lo que queramos.

// $servername = "sql107.infinityfree.com";
// $username = "if0_36843442";
// $password = "UCdEIzMBJciad";
// $dbname = "if0_36843442_mispeliculas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }
// ?>