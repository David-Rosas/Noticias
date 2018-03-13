
<?php
require "config.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Control de noticias</title>
        
        <link type="text/css" href="estilo.css" rel="stylesheet" />
        
        <script type="text/javascript" src="jquery.js"></script>
        
        <SCRIPT LANGUAGE='JavaScript'>
        <!--
        // Función que actualiza la página al cambiar la categoría de noticia
    function actualizaPagina ()
        {
            i = document.forms.selecciona.categoria.selectedIndex;
            categoria = document.forms.selecciona.categoria.options[i].value;
            window.location = 'index.php?categoria=' + categoria;
        }
        // -->
        </SCRIPT>
         
    </head>
<body>
        <div id="central">
            <div class="service_category">Sistema de Noticias</div>
<?php
 
      // Mostrar formulario con elemento SELECT para seleccionar categoría de noticia
      print ("<FORM NAME='selecciona' ACTION='index.php' METHOD='POST'>\n");
      print ("<p>Elija la categoría:</p>\n");
      print ("<SELECT NAME='categoria' ONCHANGE='actualizaPagina()'>\n");
 
   // Obtener los valores del tipo enumerado
      $instruccion = "SHOW columns FROM noticias LIKE 'nombre_categoria'";
      $consulta = mysqli_query ($instruccion, $conexion);
      $row = mysqli_fetch_array ($consulta);
 
   // Pasar los valores a una tabla y añadir el valor "Todas" al principio
      $lis = strstr ($row[1], "(");
      $lis = ltrim ($lis, "(");
      $lis = rtrim ($lis, ")");
      $lis = "'Todas'," . $lis;
      $lista = explode (",", $lis);
 
   // Mostrar cada valor en un elemento OPTION
      $categoria = $_REQUEST['categoria'];
      if (isset($categoria))
         $selected = $categoria;
      else
         $selected = "Todas";
      for ($i=0; $i<count($lista); $i++)
      {
         $cad = trim ($lista[$i], "'");
         if ($cad == $selected)
            print ("   <OPTION VALUE='$cad' SELECTED>$cad\n");
         else
            print ("   <OPTION VALUE='$cad'>$cad\n");
      }
 
      print ("</SELECT></P>\n");
      print ("</FORM>\n");
 
   // Enviar consulta
      $instruccion = "select * from noticias";
 
      if (isset($categoria) && $categoria != "Todas")
         $instruccion = $instruccion . " where nombre_categoria='$categoria'";
 
      $instruccion = $instruccion . " order by fecha_post_ini desc";
      $consulta = mysqli_query ($instruccion, $conexion)
         or die ("Fallo en la consulta");
 
   // Mostrar resultados de la consulta
      $nfilas = mysqli_num_rows ($consulta);
      if ($nfilas > 0)
      {
 
         for ($i=0; $i<$nfilas; $i++)
         {
            $resultado = mysqli_fetch_array ($consulta);
            echo "<div class='service_list' id='". $resultado['noticia_id'] ."' data='". $resultado['noticia_id'] ."'>";
            echo "<div class='center_block'>";
 
            echo "<a href='". $resultado['url'] ."' class='product_img_link' target='_blank' title='". $resultado['titulo'] ."'> <img width='129' height='129' src='images/". $resultado['imagen'] ."'></a>";
            echo '<span class="info_categoria">Categoria: '. $resultado['nombre_categoria'] .'</span>';
            echo '<h3><a title="'. $resultado['titulo'] .'" href="'. $resultado['url'] .'" target="_blank">'. $resultado['titulo'] .'</a></h3>';
            echo '<p class="product_desc">' . $resultado['descripcion'] . '<br></p>';
 
             echo"</div>";
             echo '<p class="info_general">Publicado: '. $resultado['fecha_post_ini'] .' visto: '. $resultado['leido'] .' veces</p> ';
             echo "</div>";
 
}
 
      }
      //si no hay noticias mostramos el mensaje
      else
        print '<div class="no_noticia">No hay noticias disponibles... </div><a class="product_desc" href="ingresar_noticia.php">Ingresar noticia nueva</a>';
             echo "</div>";
?>
 
 </body>
</html>