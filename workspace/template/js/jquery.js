/* global $ */

$(document).ready(function(){

    $(".elimDisco").click(function(){
        if(!confirm("¿Realmente quieres borrar el disco?")){
            event.preventDefault();
        } else {
        }
    });
    
    $(".elimUsuario").click(function(){
        if(!confirm("¿Realmente quieres borrar al usuario?")){
            event.preventDefault();
        } else {
        }
    });

});