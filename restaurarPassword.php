<?php 

	include_once"conexion.php";

	$inputCarnet = "class = \"form-control pr-3 pl-3 mt-3 mb-4\" placeholder=\"Ingrese el número de carnet\"";
	$nuevaClave = "class = \"form-control pr-3 pl-3 mt-3 mb-4\" placeholder=\"Ingrese nueva contraseña\"";
	$nuevaClaveComparacion = "class = \"form-control pr-3 pl-3 mt-3 mb-4\" placeholder=\"Repita la nueva contraseña\"";
	if (isset($_POST['numero_carnet'])) {

		// En el campo va la llave primaria
		$numero_carnet=(int)$_POST['numero_carnet'];

		// Seleccionar los campos del registro que va ser modificado
		$buscar_registro = $con->prepare('SELECT * FROM usuarios WHERE numero_carnet= :numero_carnet');
		$buscar_registro -> execute(array(':numero_carnet'=>$numero_carnet));
		$resultado = $buscar_registro -> fetch();
	}

	if (isset($_POST['confirmar'])) {
		$contraseña = $_POST['contrasenia'];
		$contraseñaC = $_POST['contraseniaC'];
		$numero_carnet = (int)$_POST['numero_carnet'];

		if (!empty($contraseña) && !empty($numero_carnet)) {
			if ($contraseña === $contraseñaC) {	

				$modificar_usuario = $con-> prepare('UPDATE usuarios SET contrasenia=:contrasenia WHERE numero_carnet=:numero_carnet');
				
				// Para asociar el script de la linea 10 y los almacenamos en un array
				$modificar_usuario-> execute(array( ':numero_carnet'=>$numero_carnet,':contrasenia'=>$contraseña));

				header('location: index.php');

			}else{
				echo '<script language="javascript">alert("Debes llenar los campos con la misma contraseña");</script>';			
				$nuevaClave = "class = \"form-control border-danger pr-3 pl-3 mt-3 mb-4\" placeholder=\"Contraseña no coincibe\"";
				$nuevaClaveComparacion = "class = \"form-control border-danger pr-3 pl-3 mt-3 mb-4\" placeholder=\"Contraseña no coincibe\"";
			}
		}

		if (empty($resultado['numero_carnet'])) {
			echo '<script language="javascript">alert("No se encontro este usuario");</script>';			
			$inputCarnet = "class = \"form-control border-danger pr-3 pl-3 mt-3 mb-4\" placeholder=\"Usuario no existe\"";
		}

		if(empty($contraseña)){
			$nuevaClave = "class = \"form-control border-danger pr-3 pl-3 mt-3 mb-4\" placeholder=\"Debe llenar este campo\"";
		}

		if(empty($contraseñaC)){
			$nuevaClaveComparacion = "class = \"form-control border-danger pr-3 pl-3 mt-3 mb-4\" placeholder=\"Debe llenar este campo\"";
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<!-- ICONO Font Awesome -->
		<script src="https://kit.fontawesome.com/9f429f9981.js" crossorigin="anonymous"></script>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="sass/custom.css">
		
		<title>Recuperar contraseña</title>
		<link rel="shortcut icon" href="img/LogoS.png">
	</head>

	<body class="text-dark" style="font-family: 'Lato', sans-serif; background-image: url(img/F4.jpg); background-size: cover; height: 100%; background-attachment: fixed;">
		<div class="container position-relative">
			<div class="row mt-3 mt-lg-3 pt-lg-5">

				<!-- Icono Atras -->
				<div class="col-4 embed-responsive-item">
					<div class="row mt-5 pt-5 mr-1 text-center align-items-center justify-content-center">
						<div class="col-7"></div>
						<div class="col-3">
							<a href="index.php" class="rounded-circle p-2 bg-success border border-3 border-white text-decoration-none mt-2 shadow">
								<i class="fas fa-chevron-left fa-lg text-white" title="Atras"></i>
							</a>
						</div>
						<div class="col-2"></div>
					</div>
				</div>

				<!-- Targeta de recuperacion -->
				<div class="col-4">
					<div class="card bg-light text-center shadow-lg p-3 bg-white rounded">
						<div class="card-header">
							<h2 class="h2 pt-2">Recuperar contraseña</h2>
							<img width="200" src="img/LogoCandado.png" class="img-fluid mt-2 mb-2" alt="candado">
						</div>
						<div class="card-body">
							<form method="post" class="form-group">
								<input type="text" <?php echo $inputCarnet; ?> name="numero_carnet" required>
								<input type="password" <?php echo $nuevaClave; ?> name="contrasenia" onclick="funcion_javascript()" required>
								<input type="password" <?php echo $nuevaClaveComparacion; ?> name="contraseniaC" title="Minimo 10 digitos" required>
								<button class="btn btn-success text-white btn-lg pr-5 pl-5 mt-1 shadow" id="btnConfirmar" name="confirmar">Guardar</button>
							</form>
						</div>
					</div>
				</div>

				<div class="col-4"></div>
				
			</div>
		</div>

	 	<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="sweetAlert2/sweetalert2.all.min.js"></script>
		<script type="text/javascript" src="js/alertas.js"></script>

	</body>
</html>