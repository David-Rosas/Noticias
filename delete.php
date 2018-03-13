<?php
require "config.php";
$elimina = $_POST['id'];
$imagen = $_POST['imagen'];
$instruccion_2 = "select imagen from noticias where noticia_id = $elimina ";
$consulta_2 = mysql_query ($instruccion_2, $conexion);
$resultado_2 = mysql_fetch_array ($consulta_2);
    //variable para almacenar el nobre del archivo
    $nombre_archivo = '../images/'.$resultado_2['imagen'];
    //verificamos si el archivo existe. si existe lo borramos fisicamente
    if(file_exists($nombre_archivo)) unlink($nombre_archivo );
$instruccion = "delete from noticias where noticia_id = $elimina";
$consulta = mysql_query ($instruccion, $conexion)
            or die ("Eliminación errónea");
?>