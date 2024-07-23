
<?php
// Datos de configuración
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'mispeliculas';

// Conexión a la base de datos
$conpel = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conpel) {
    die("Conexión fallida: " . mysqli_connect_error());
}
$tmdb_apikey='d88ba9ba1569e78c86d0716612d08dd1'; // registrarse en themoviedb.org y obtener tu apikey
$tmdb_ruta_poster = 'https://image.tmdb.org/t/p/w154'; 
//token de acceso de autentificación: eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkODhiYTliYTE1NjllNzhjODZkMDcxNjYxMmQwOGRkMSIsIm5iZiI6MTcyMTIxMDY0NS40MDIzMzIsInN1YiI6IjY2ODY3MmIzZGM3YTlhY2NjOTFhNmM4ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Pdpb30SYOylE1MKV413PWTgp3KXYqknMT5QHHvJ8xns
?>


