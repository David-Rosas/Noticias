<?php
$enlace = mysqli_connect("127.0.0.1", "root", "vale2013", "noticias2");

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." ;
    
}



mysqli_close($enlace);
?>