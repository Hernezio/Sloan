<?php  

	// Conexión
	include_once"conexion.php";

	// Variables
	$claseUsuario = "class = \"form-control mt-3 mb-4 pr-3 pl-3\"";
	$claseContraseña = "class = \"form-control mb-3 pr-3 pl-3\"";
	$inputUsuario = " placeholder=\"Usuario\"";
	$inputClave = " placeholder=\"Contraseña\"";
	$sentencia_select = $con->prepare('SELECT * FROM usuarios ORDER BY id_usuario ASC');
	$sentencia_select->execute();
	$resultado = $sentencia_select->fetchAll();

	// Ciclos donde se verifican los datos
	if(isset($_POST['inicio'])) {
		$buscar_text = $_POST['nUsuario'];
		$select_buscar = $con->prepare('SELECT * FROM usuarios WHERE numero_carnet LIKE :campo;');
		$select_buscar->execute(array(':campo' =>"%".$buscar_text."%"));
		$resultado = $select_buscar->fetchAll();
		$arrayVacio = 0;

		foreach ($resultado as $fila) {

			$arrayVacio++;
			
			if ($fila['numero_carnet'] == $_POST['nUsuario']) {
				
				if ($fila['contrasenia'] == $_POST['contraseña']) {
					
					if ($fila['tipo_usuario'] == 1) {
						
						$sesion = "activo";
						
						try {

							$stmt = $con -> prepare('call inicioSesion(?,?)');
							$stmt -> bindParam(1, $sesion, PDO::PARAM_STR);
							$stmt -> bindParam(2, $fila['numero_carnet'], PDO::PARAM_STR);

							$stmt -> execute();

							session_start();
							ob_start();

							$_SESSION['carnetUsuario'] = $fila['numero_carnet'];

							header('location: admin/home.php');

						} catch (PDOException $e) {
							echo "error en el inicio de sesion".$e -> getMessage();
						}
					}

					if ($fila['tipo_usuario'] == 2) {

						$sesion = "activo";

						try {

							$stmt = $con -> prepare('call inicioSesion(?,?)');
							$stmt -> bindParam(1, $sesion, PDO::PARAM_STR);
							$stmt -> bindParam(2, $fila['numero_carnet'], PDO::PARAM_STR);

							$stmt -> execute();

							session_start();
							ob_start();

							$_SESSION['carnetUsuario']=$fila['numero_carnet'];
							
							header('location: monitor/home.php');

						} catch (PDOException $e) {
							echo "error en el inicio de sesion".$e -> getMessage();
						}
					}

				} else {
					echo '<script language="javascript">alert("La contraseña es incorrecta");</script>';			
					$inputClave= "placeholder = \"Contraseña incorrecta\"";
					$claseContraseña ="class = \"form-control border-danger mb-4\"";
				}
			}
		}

		if ($arrayVacio <= 0) {
			echo '<script language="javascript">alert("No se encontro este usuario");</script>';			
			$inputUsuario= "placeholder = \"Usuario no existe\"";
			$claseUsuario ="class = \"form-control border-danger mt-3 mb-4\"";
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
		
		<title>Ingreso de usuarios SLOAN</title>
		<link rel="shortcut icon" href="img/LogoS.png">
	</head>

	<body style="font-family: 'Noto Sans JP', sans-serif;">
		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6 login-section-wrapper">
						<div class="align-items-center text-center align-content-center">
							<img src="img/LogoSloan.png" alt="logo" width="150" class="logo img-fluid">
						</div>
						<div class="login-wrapper my-auto">
							<h1 class="login-title text-success">Ingreso Sloan</h1>
							<form method="post">
								<div class="form-group">
									<label class="text-dark fw-bold">Usuario</label>
									<input type="text" name="nUsuario" <?php echo $claseUsuario; ?> id="nUsuario" class="form-control" <?php echo $inputUsuario; ?> required>
								</div>
								<div class="form-group mb-5">
									<label class="mb-3 text-dark fw-bold">Contraseña</label>
									<input type="password" name="contraseña" <?php echo $claseContraseña; ?> id="contraseña" class="form-control" <?php echo $inputClave; ?> requiered>
								</div>
								<button class="btn btn-block bg-warning login-btn" id="btnInicio" name="inicio">Ingresar</button>
							</form>
							<a href="restaurarPassword.php" class="forgot-password-link">¿Se le olvidó su contraseña?</a>
						</div>
					</div>
					<div class="col-sm-6 px-0 d-none d-sm-block">
						<img src="img/persona.jpg" alt="login image" class="login-img img-fluid">
					</div>
				</div>
			</div>
		</main>
		
		<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>