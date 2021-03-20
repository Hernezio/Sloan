<?php
	
	include_once "../conexion.php";
	
	if (isset($_POST['btn_guardar'])) {
		
		// busca un usuario con el carnet ingresado en el input y toma su id de usuario
		$sentencia_select=$con->prepare('call carnet_id(?)');
		$sentencia_select->bindParam(1, $_POST['carnet'], PDO::PARAM_INT);
		$sentencia_select->execute();											
		$carnet=$sentencia_select->fetch();
		$sentencia_select=$con->prepare('call codigo_barras(?)');
		$sentencia_select->bindParam(1, $_POST['c_barras'], PDO::PARAM_INT);
		$sentencia_select->execute();											
		$codigo=$sentencia_select->fetch();
		
		// lleva los input a dos variables para lluego llevarlas a el procedimiento almacenado
		$id_articulo=$codigo['id_articulo'];
		$id_usuario=$carnet['id_usuario'];
		
		if (!empty ($id_usuario) && !empty ($id_articulo)) {
			
			// traer tabla articulo para comparar
			$sentencia_select = $con->prepare('SELECT * FROM articulos ORDER BY id_articulo ASC');
			$sentencia_select->execute();
			$estado=$sentencia_select->fetchAll();
			
			foreach ($estado as $f_art) {
				
				//comparar articulo con metodo post para saber si esta diponible
				if ($id_articulo == $f_art['id_articulo']){
					
					// este if confirma que el articulo se pueda prestar
					if ($f_art['disponibilidad']==1 || $f_art['disponibilidad']==1) {
						
						//este if confirma que el usuario pueda prestar
						if ($carnet['tipo_usuario']== 3 ||$carnet['tipo_usuario']== 4 ){
							
							// inserta el id de usuario y el de articulo en la tabla de prestamos
							$sentencia_insert=$con->prepare('CALL prestamos(?,?)');
							$sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
							$sentencia_insert->bindParam(2, $id_articulo, PDO::PARAM_INT);
							$sentencia_insert->execute();
							
							// cambia de estado el articulo
							$sentencia_insert=$con->prepare('CALL estado_prestamo(2,?)');
							$sentencia_insert->bindParam(1, $id_articulo, PDO::PARAM_INT);
							$sentencia_insert->execute();
							
							// cambia de estado el usuario
							$sentencia_insert=$con->prepare('CALL estado_usuario(2,?)');
							$sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
							$sentencia_insert->execute();
							$sentencia_select=$con->prepare('SELECT * FROM prestamos ORDER BY id_prestamo ASC');
							$sentencia_select->execute();
							$resultado=$sentencia_select->fetchAll();
							foreach ($resultado as $fila) {}
							
							//LLENAR DETALLE PRESTAMO
							$sentencia_insert=$con->prepare('CALL detalle_prestamo(?)');
							$sentencia_insert->bindParam(1,$fila['id_prestamo'], PDO::PARAM_INT);
							$sentencia_insert->execute();
							header('location: prestamo.php');
						} else {
							echo '<script language="javascript">alert("No puedes realizar este tramite");</script>';
						}
					}else {
						echo '<script language="javascript">alert("El artículo NO se puede prestar");</script>';
					}
				}else {	
					echo '<script language="javascript">alert("Este artículo ya esta siendo utilizado");</script>';
				}
			}
		}else {
			echo '<script language="javascript">alert("Ingresa los datos correctamente, porfavor");</script>';
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
        <link rel="stylesheet" href="../css/custom.css">
		
		<title>Préstamos Sloan</title>
		<link rel="shortcut icon" href="../img/LogoS.png">

		<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="../js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	</head>
	
	<body style="font-family: 'Noto Sans JP', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
		
        <!-- BARRA NAVEGACION -->
        <?php include_once "../plantillas/navegacion.plantilla.php" ?>   

        <!-- Contenedor -->
		<div class="container mt-5 mb-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8 mt-5">
					<div class="card shadow">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="h2 text-success" style="font-family: 'Noto Sans JP', sans-serif;">Generar Préstamo</h2>
							</div>
						</div>
						<div class="card-body">

							<!-- Formulario con campos a insertar -->
							<form class="row g-3 p-3" action="" method="POST">
							<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Numero carnet:</label>
									 <input type ="text" name ="carnet" class="form-control" placeholder="Carnet" required>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Artículo:</label>
									<input type ="text" name ="c_barras" class="form-control" placeholder="codigo de barras" required>
								</div>
								<div class="col-12 text-center">
									<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white mt-2 shadow">
								</div>
							</form>	

						</div>
						<div class="card-footer text-muted text-center pt-3">
							<div class="row align-items-center">

								<!-- Botones atras y refrescar -->
								<div class="col-6 mb-2">
									<a href="prestamo.php" class="rounded-circle p-2 bg-success border border-3 border-white text-decoration-none mt-2">
										<i class="fas fa-chevron-left fa-lg text-white" title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="insert_prestamos.php" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
								</div>

							</div>
						</div>
					</div>
				</div>
				<!-- Columna vacia, está ahí para el correcto funcionamiento del diseño responsive -->
				<div class="col-2"></div>
			</div>
		</div>		 
		
	</body>
</html>