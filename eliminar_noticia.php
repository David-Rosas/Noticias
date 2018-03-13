//incluimos la conexion
<?php
require "config.php";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>Sistema de noticias con jQuery ,PHP MYSQL....!!!</title>
        //enlaces al css
        <link type="text/css" href="estilo.css" rel="stylesheet" />
        //enlaces al jquery
        <script type="text/javascript" src="jquery.js"></script>
         
    </head>
<body>
        <div id="central">
            <div class="service_category">Sistema de Noticias Php mysql Ajax</div>
            //escondemos el mensaje hasta que sea necesario
                <div id="delete-ok" style="display:none;"> </div>
<?
      $instruccion = "select * from noticias order by noticia_id desc";
      $consulta = mysql_query ($instruccion, $conexion)
         or die ("Consulta de datos errónea...");
      $nfilas = mysql_num_rows ($consulta);
      if ($nfilas > 0)
      {
 
         for ($i=0; $i<$nfilas; $i++)
         {
            $resultado = mysql_fetch_array ($consulta);
            echo "<div class='service_list' id='". $resultado['noticia_id'] ."' data='". $resultado['noticia_id'] ."'>";
            echo "<div class='center_block'>";
 
            echo "<a href='". $resultado['url'] ."' class='product_img_link' target='_blank' title='". $resultado['titulo'] ."'> <img width='129' height='129' src='images/". $resultado['imagen'] ."'></a>";
            echo '<span class="info_categoria">Categoria: '. $resultado['nombre_categoria'] .'</span>';
 
            echo '<h3><a title="'. $resultado['titulo'] .'" href="'. $resultado['url'] .'" target="_blank">'. $resultado['titulo'] .'</a></h3>';
            echo '<p class="product_desc">' . $resultado['descripcion'] . '<br></p>';
 
             echo"</div>";
             echo "<a class='delete' id='". $resultado['noticia_id'] ."'>Eliminar</a>";
             echo "</div>";
 
}
 
      }
      else
        print '<p class="no_noticia">No hay noticias para eliminar...</p><a class="product_desc" href="ingresar_noticia.php">Ingresar noticia nueva</a>';
             echo "</div>";
?>
 
           //creamos el javascript para la elimnacion
<script type="text/javascript">
$(document).ready(function() {
 
    $('.delete').click(function(){
     
        var parent = $(this).parent().attr('id');
        var noticia = $(this).parent().attr('data');
                 
        var dataString = 'id='+noticia;
         
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: dataString,
            success: function() {          
                $('#delete-ok').empty();
                $('#delete-ok').append('<div class="correcto">Noticia # '+noticia+' eliminada correctamente.</div>').fadeIn("slow");
                $('#'+parent).fadeOut("slow");
                //$('#'+parent).remove();
            }
        });
    });                
});   
</script>
    </body>
</html>