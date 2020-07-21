// JavaScript Document
$(document).ready(function(){
	/*$('#ingresarButton').click(function(){
		comprobarRegistro($('#password').val());
	})*/


	function comprobarRegistro(password){
		var variable={id:password};
		$.ajax({
			type: 'POST',
			 url: "CRUD/datos.php?accion=ingresar",
			 data: variable,
			 dataType:"json",
			 success: function(msg) {
              tabla1.ajax.reload();
            },
            error: function() {
              alert("Hay un problema en la función comprobarRegistro");
            }
		});


	}
})
