$(document).ready(function(){
    //variables globales
    var searchBoxes = $(".text");
    var inputTitulo = $("#titulo");
    var reqTitulo = $("#req-titulo");
    var inputNoticia = $("#noticia");
    var reqNoticia = $("#req-noticia");
    var inputEmail = $("#email");
    var reqEmail = $("#req-email");
 
    //funciones de validacion
    function validateTitulo(){
        //NO cumple longitud minima
        if(inputTitulo.val().length < 8){
            reqTitulo.addClass("error");
            inputTitulo.addClass("error");
            return false;
        }
        //SI longitud pero NO solo caracteres A-z
        else if(!inputTitulo.val().match(/^[0-9a-z A-Z]+$/)){
            reqTitulo.addClass("error");
            inputTitulo.addClass("error");
            return false;
        }
        // SI longitud, SI caracteres A-z
        else{
            reqTitulo.removeClass("error");
            inputTitulo.removeClass("error");
            return true;
        }
    }
     
     
    function validateNoticia(){
        //NO cumple longitud minima
        if(inputNoticia.val().length < 40){
            reqNoticia.addClass("error");
            inputNoticia.addClass("error");
            return false;
        }
        //SI longitud pero solo caracteres A-z
        else if(!inputNoticia.val().match(/^[0-9a-z A-Z]+$/)){
            reqNoticia.addClass("error");
            inputNoticia.addClass("error");
            return false;
        }
        // SI longitud, SI caracteres A-z
        else{
            reqNoticia.removeClass("error");
            inputNoticia.removeClass("error");
            return true;
        }
    }
     
    function validateEmail(){
        //NO hay nada escrito
        if(inputEmail.val().length == 0){
            reqEmail.addClass("error");
 
            inputEmail.addClass("error");
            return false;
        }
        else if(!inputEmail.val().match(/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i)){
            reqEmail.addClass("error");
            inputEmail.addClass("error");
            return false;
        }
        // SI rellenado, SI email valido
        else{
            reqEmail.removeClass("error");
            inputEmail.removeClass("error");
            return true;
        }
    }
     
     
    //controlamos la validacion en los distintos eventos
    // Perdida de foco
    inputTitulo.blur(validateTitulo);
    inputNoticia.blur(validateNoticia); 
    inputEmail.blur(validateEmail); 
     
    // Pulsacion de tecla
    inputTitulo.keyup(validateTitulo);
    inputNoticia.keyup(validateNoticia);
     
    // Envio de formulario
    $("#formulario").submit(function(){
        if(validateTitulo() & validateNoticia() & validateEmail())
            return true;
        else
            return false;
    });
     
    //controlamos el foco / perdida de foco para los input text
    searchBoxes.focus(function(){
        $(this).addClass("active");
    });
    searchBoxes.blur(function(){
        $(this).removeClass("active"); 
    });
 
});