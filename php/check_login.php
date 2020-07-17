<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Autocamiones Chinese</title>
		<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="../css/PAC.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
	</head>

	<body>
		<div class="shadow-none p-3 mb-5 rounded container" id="recuadro">
			<img src="../images/logo.png" class="rounded mx-auto d-block logo">
			
			
			<?php
			error_reporting(0);
			
			if(isset($_REQUEST['pass'])==false){
				echo 
					"<div class='alert alert-danger' role='alert'>
  						Aún no has ingresado al inventario, debes logearte haciendo click <a href='../index.php' class='alert-link'>AQUÍ</a>.
					</div>
					<br>	
					<a href='../index.php'>
						<img src='../images/icons/log_in.png' class='rounded mx-auto d-block icono' title='Verifica primero tu identidad'>
					</a>";
				
				
			}
			else{
				include("conection.php");
				$registros = mysqli_query($conexion, "select Nombre, Apellido1, Cargo from usuarios where Documento_Identidad='$_REQUEST[pass]'") or die("Problemas en el select:".mysqli_error($conexion));
				if ($reg = mysqli_fetch_array($registros)) {
					echo "Nombre completo: ".$reg['Nombre']." ".$reg['Apellido1']." ".$reg['Cargo']."<br>";
					
					
			  } else {
					header("location: ../index.php?fallo=true");
			  }
			  mysqli_close($conexion);
			}
			
			?>			
			
		</div>		
		
		<!--Bootstrap-->
		<script src="js/PAC.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<!--Finaliza acá>-->
	</body>
</html>