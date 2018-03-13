<?php
require "config.php";
?>
<?php
 
function validateTitulo($title){
    //NO cumple longitud minima
    if(strlen($title) < 8)
        return false;
    //SI longitud pero NO cumple acaracteres solo caracteres A-z
    else if(!preg_match("/^[0-9a-z A-Z]+$/", $title))
        return false;
    // SI longitud, SI caracteres A-z
    else
        return true;
}
function validateNoticia($notice){
    //NO cumple longitud minima
    if(strlen($notice) < 10)
        return false;
    //SI longitud pero NO solo caracteres A-z
    else if(!preg_match("/^[0-9a-z A-Z]+$/", $notice))
        return false;
    // SI longitud, y SI caracteres A-z
    else
        return true;
}
function validateEmail($email){
    //NO hay nada escrito
    if(strlen($email) == 0)
        return false;
    // esta escrito,pero  NO es VALIDO email
    else if(!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))
        return false;
    // todo el mail es ok
    else
        return true;
}
//variables valores por defecto
$titulo = "";
$tituloValue = "";
$noticia = "";
$noticiaValue = "";
$email = "";
$emailValue = "";
   
   
//Validacion de datos enviados
   if (isset($insertar))
   {
   if(!validateTitulo($_POST['titulo']))
        $titulo = "error";
    if(!validateNoticia($_POST['noticia']))
        $noticia = "error";
    if(!validateEmail($_POST['email']))
        $email = "error";
     
    //Guardamos valores para que no tenga que reescribirlos
    $tituloValue = $_POST['titulo'];
    $noticiaValue = $_POST['noticia'];
    $emailValue = $_POST['email'];
    $urlnoticiaValue = $_POST['urlnoticia'];
 
 
    if($titulo != "error" && $noticia != "error" && $email != "error")
        $status = 1;
         
       // Subir fichero
      $copiarFichero = false;
 
   // Copiar fichero en directorio de ficheros subidos
   // Se renombra para evitar que sobreescriba un fichero existente
   // Para garantizar la unicidad del nombre se añade una marca de tiempo
      if (is_uploaded_file ($_FILES['imagen']['tmp_name']))
      {
         $nombreDirectorio = "images/";
         $nombreFichero = $_FILES['imagen']['name'];
         $copiarFichero = true;
 
      // Si ya existe un fichero con el mismo nombre, renombrarlo
         $nombreCompleto = $nombreDirectorio . $nombreFichero;
         if (is_file($nombreCompleto))
         {
            $idUnico = time();
            $nombreFichero = $idUnico . "-" . $nombreFichero;
         }
      }
   // El fichero introducido supera el límite de tamaño permitido
      else if ($_FILES['imagen']['error'] == UPLOAD_ERR_FORM_SIZE)
      {
         $maxsize = $_REQUEST['MAX_FILE_SIZE'];
         $errores["imagen"] = "¡El tamaño del fichero supera el límite permitido ($maxsize bytes)!";
         $error = true;
      }
   // No se ha introducido ningún fichero
      else if ($_FILES['imagen']['name'] == "")
         $nombreFichero = '';
   // El fichero introducido no se ha podido subir
      else
      {
         $errores["imagen"] = "¡No se ha podido subir el fichero!";
         $error = true;
      }
    
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>Insertar noticias con jQuery , PHP MYSQL....!!!</title>
        
        <link type="text/css" href="estilo.css" rel="stylesheet" />
      
        <script type="text/javascript" src="jquery.js"></script>
        //enlaces al javascript de funciones y errores
        <script type="text/javascript" src="main.js"></script>
    </head>
    //posicionamos el foco en el formulario
<body OnLoad="formulario.titulo.focus();">
        <div id="central">
            <div class="service_category">Insertar noticias ...</div>
            <?PHP
               if (isset($insertar) && $error==false)
                {
                 
                  $fecha = date ("Y-m-d"); // Fecha actual
                  $instruccion = "INSERT INTO noticias (titulo, descripcion, nombre_categoria, fecha_post_ini, mail, imagen) values ('$titulo', '$noticia', '$categoria', '$fecha' , '$email','$urlnoticia', '$nombreFichero' )";
                  $consulta = mysqli_query ($instruccion, $conexion)
                    or die ("Fallo en la consulta");
                    mysqli_close ($conexion);
                       // Mover fichero de imagen a su ubicación definitiva
                  if ($copiarFichero)
                    move_uploaded_file ($_FILES['imagen']['tmp_name'],
                    $nombreDirectorio . $nombreFichero);
   // Mostrar datos introducidos
      print ("<H2 class='info'>Noticia Insertada con exito</H2>\n");
      print ("<UL>");
      print ("<LI>Título: " . $titulo);
      print ("<LI>Texto: " . $noticia);
      print ("<LI>Categoría: " . $categoria);
      print ("<LI>Email: " . $email);
 
      if ($nombreFichero != "")
         print ("<LI>Imagen: <A TARGET='_blank' HREF='" . $nombreDirectorio . $nombreFichero . "'>" . $nombreFichero . "</A>");
      else
         print ("<LI>Imagen: (no subió imagen)");
      print ("</UL>");
 
      print ("<BR>");
      print ("[ <A HREF='ingresar_noticia.php'>Insertar otra noticia</A> ]");
      print ("[ <A HREF='eliminar_noticia.php'>Eliminar noticia</A> ]");
 
   }
   else
   {
?>
 
 
            <form  id="formulario" action="" method="post" enctype="multipart/form-data">
                 
                <label for="titulo">Ingrese el Titulo de la noticia (<span id="req-titulo" class="requisites <?php echo $titulo ?>">Mínimo 8 caracters no caracteres especiales...</span>):</label>
                <input tabindex="1" name="titulo" id="titulo" type="text" class="text <?php echo $titulo ?>" value="<?php echo $tituloValue ?>" />
                 
                <label for="noticia">Ingrese Noticia (<span id="req-noticia" class="requisites <?php echo $noticia ?>">Mínimo 40 caracteres no caracteres especiales...</span>):</label>                              <input tabindex="2" name="noticia" id="noticia" type="text" class="text <?php echo $noticia ?>" value="<?php echo $noticiaValue ?>" />
 
                <label for="email">E-mail (<span id="req-email" class="requisites <?php echo $email ?>">Ingrese un email válido por favor</span>) No saldrá publicado:</label>
                <input tabindex="3" name="email" id="email" type="text" class="text <?php echo $email ?>" value="<?php echo $emailValue ?>" />
                 
                <label for="urlnoticia">Ingrese imagen de la noticia max.102400mb:</label>
                <INPUT tabindex="5"  TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="102400" >
                <INPUT TYPE="FILE" SIZE="44" NAME="imagen" class="text">
                <?PHP
   if ($errores["imagen"] != "")
      print ("<BR><SPAN CLASS='error'>" . $errores["imagen"] . "</SPAN>");
?>
</P>
                <LABEL for="categoria">Categoría:</LABEL>
<SELECT NAME="categoria">
   <OPTION SELECTED>Tecnología
   <OPTION>Celulares
   <OPTION>Hogar
   <OPTION>Personajes
   <OPTION>Farandula
   <OPTION>Redes Sociales
   <OPTION>Cultura
   <OPTION>Cine
   <OPTION>Polémica
   <OPTION>Series
   <OPTION>Animados
   <OPTION>Computadoras
   <OPTION>Empresas
</SELECT>
 
                <br/>
                    <input tabindex="6" name="insertar" id="insertar" type="submit" class="submit" value="Enviar Noticia" />
                     
 
                </div>
 
                 
            </form>
 
<?PHP
   }
?>
 
    </body>