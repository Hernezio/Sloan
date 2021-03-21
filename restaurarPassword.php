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

		<!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
		
		<!-- ICONO Font Awesome -->
		<script src="https://kit.fontawesome.com/9f429f9981.js" crossorigin="anonymous"></script>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/login.css">
		
		<title>Recuperar contraseña</title>
		<link rel="shortcut icon" href="img/LogoS.png">
	</head>

	<body class="text-dark" style="font-family: 'Noto Sans JP', sans-serif;">
		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6 px-0 d-none d-sm-block">
						<img src="img/man.jpg" alt="login image" class="login-img img-fluid">
					</div>
					<div class="col-sm-6 login-section-wrapper">
						<div class="align-items-center text-center align-content-center">
							<img src="img/LogoCandado.png" alt="logo" width="150" class="logo img-fluid">
						</div>
						<div class="login-wrapper my-auto">
							<h1 class="h3 fw-bold text-success">Recuperar contraseña</h1>
							<form method="post">
								<div class="form-group mt-5">
									<label class="text-dark">Identificación</label>
									<input type="text" class="form-control" <?php echo $inputCarnet; ?> name="numero_carnet" required>
								</div>
								<div class="form-group mb-1 mt-2">
									<label class="mb-2 text-dark">Nueva contraseña</label>
									<input type="password" class="form-control" <?php echo $nuevaClave; ?> name="contrasenia" onclick="funcion_javascript()" required>
								</div>
								<div class="form-group mb-5">
									<input type="password" class="form-control" <?php echo $nuevaClaveComparacion; ?> name="contraseniaC" title="Minimo 10 digitos" required>
								</div>
								<a href="index.php" class="mb-5 m-1 btn btn-block bg-warning login-btn">Atras</a>
								<button class="mb-5 m-1 btn btn-block bg-success login-btn" id="btnConfirmar" name="confirmar">Guardar</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>

	 	<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="sweetAlert2/sweetalert2.all.min.js"></script>
		<script type="text/javascript" src="js/alertas.js"></script>
	</body>
</html>