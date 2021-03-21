<?php
	
	include_once "../conexion.php";

	if (isset($_POST['btn_guardar'])){
		
		if($_POST['tipo_usuario'] == 3 || $_POST['tipo_usuario'] == 4){
			$tipo_usuario=$_POST['tipo_usuario'];
			$nombre=$_POST['nombre'];
			$apellido=$_POST['apellido'];
			$numero_carnet=$_POST['numero_carnet'];
			$estado_usuario=$_POST['estado_usuario'];
			
			if (!empty ($tipo_usuario) && !empty ($nombre) && !empty($apellido) && !empty($numero_carnet) && !empty($estado_usuario)){
				$insert_usuario= $con-> prepare ('INSERT INTO usuarios(tipo_usuario,nombre,apellido,numero_carnet,estado_usuario) VALUES (:tipo_usuario,:nombre,:apellido,:numero_carnet,:estado_usuario)');
				$insert_usuario-> execute(array(			
					':tipo_usuario'=>$tipo_usuario,
					':nombre'=>$nombre,
					':apellido'=>$apellido,
					':numero_carnet'=>$numero_carnet,
					':estado_usuario'=>$estado_usuario
				));

				header('location: usuarios.php');

			} else {
				echo '<script language="javascript">alert("No estas autorizado para agregar este tipo de usuario");</script>';
			}

		} else {
			echo '<script language="javascript">alert("Debes seleccionar tipo de usuario");</script>';
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
		<script type="text/javascript" src="../sweetAlert2/sweetalert2.all.min.js"></script>
		<script type="text/javascript" src="../js/alertas.js"></script>
	</head>
	
	<body style="font-family: 'Noto Sans JP', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
		
        <!-- BARRA NAVEGACION -->
        <?php include_once "../plantillas/navegacion.plantilla.php" ?>   
        
        <!-- Contenedor -->
		<div class="container mt-5 mb-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8 mt-3">
					<div class="card shadow">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="h2 text-success" style="font-family: 'Noto Sans JP', sans-serif;">Agregar Nuevo Usuario</h2>
							</div>
						</div>
						<div class="card-body">

							<!-- Formulario con campos a insertar -->
							<form class="row g-3 p-3" action="" method="POST">
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Tipo de usuario:</label>
									<select id="inputState" class="form-select" name="tipo_usuario">
										<option  value="0" selected>Seleccione el rol del usuario</option>
										<?php 
											$query = $con -> prepare("SELECT * FROM perfiles");
											$query -> execute();
											foreach ($query as $key ) {
												if($key[id_perfil] == 3 || $key[id_perfil] == 4) {
													echo '<option value ="'.$key[id_perfil].'">'.$key[nombre_perfil].'</option>';					 	
												}
											} 
										?>
									</select>
								</div>
								<div class="col-md-4 d-none">
									<label for="inputState" class="form-label p-2">Estado de usuario:</label>
									<select id="inputState" class="form-select" name="estado_usuario">
										<?php 
											$query = $con -> prepare("SELECT * FROM estados");
											$query -> execute();
											foreach ($query as $key) {
												echo '<option value ="'.$key[id_estado].'">'.$key[nombre_estado].'</option>';					 	
											} 
										?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Número de carnet:</label>
									<input class="form-control" type="text" name="numero_carnet" placeholder="Ingrese Numero de carnet" required>
								</div>	
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Nombre:</label>
									<input class="form-control" type="text" name="nombre" placeholder="Digite Nombre" onkeypress="return soloLetras(event)" required>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Apellido:</label>
									<input class="form-control" type="text" name="apellido" placeholder="Digite Apellido" onkeypress="return soloLetras(event)" required>
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
									<a href="usuarios.php" class="rounded-circle p-2 bg-success border border-3 border-white text-decoration-none mt-2">
										<i class="fas fa-chevron-left fa-lg text-white" title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="insert_usuario.php" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
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