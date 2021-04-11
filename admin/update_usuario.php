<?php 
include_once "../confirmarInicio.php";
confirmar(1);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<?php 
			$title="Actualizar usuario";
			include_once "../plantillas/head.php";
			include_once "../conexion.php";			
		?>
	</head>	
	<body style="font-family: 'Noto Sans JP', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
		<!--  -->
		<?php
			// BARRA NAVEGACION
		 include_once "../plantillas/navegacion.plantilla.php";
		
			// FORMULARIO
			if (isset($_GET['id_usuario'])){
				$id_usuario=(int)$_GET['id_usuario'];
				$buscar_registro=$con->prepare('SELECT * FROM usuarios WHERE id_usuario= :id_usuario');
				$buscar_registro -> execute(array(':id_usuario'=>$id_usuario));
				$resultado= $buscar_registro -> fetch();
			} else {
				header('location: usuarios.php');
			}

			if (isset($_POST['btn_guardar'])){
				$tipo_usuario=$_POST['tipo_usuario'];
				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numero_carnet=$_POST['numero_carnet'];
				$estado_usuario=$_POST['estado_usuario'];
				$contrasenia=$_POST['contrasenia'];
				$id_usuario=(int)$_GET['id_usuario'];

				if (!empty ($id_usuario) && !empty ($tipo_usuario) && !empty ($nombre) && !empty($apellido)&& !empty($numero_carnet)&& !empty($estado_usuario)&& !empty($contrasenia) && !empty($id_usuario)){
					$modificar_usuario= $con-> prepare ('UPDATE usuarios SET tipo_usuario=:tipo_usuario, nombre=:nombre, apellido=:apellido, estado_usuario=:estado_usuario, contrasenia=:contrasenia WHERE id_usuario=:id_usuario');
					$modificar_usuario-> execute(array( 
						':id_usuario'=>$id_usuario, 
						':tipo_usuario'=>$tipo_usuario, 
						':nombre'=>$nombre, 
						':apellido'=> $apellido,
						':estado_usuario'=>$estado_usuario,
						':contrasenia'=>$contrasenia
					)); 
					echo "<script> alertOk('Usuario modificado')</script>";
					echo '<script> window.location="usuarios.php";</script>';
				} else {
					echo '<script language="javascript">alert("Debes seleccionar tipo de usuario");</script>';
				}
			}
		?>
		<div class="container mt-5 mb-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8 mt-5">
					<div class="card shadow">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="h2 text-success" style="font-family: 'Noto Sans JP', sans-serif;">Actualizar Datos de Usuario</h2>
								<label class="h6 fw-bold text-success">Nº <?php if($resultado) echo $resultado['id_usuario']; ?></label>
							</div>
						</div>
						<div class="card-body">
							<!-- Formulario con campos a modificar -->
							<form class="row g-3 p-3" action="" method="POST">
								<div class="col-md-4">
									<label for="inputState" class="form-label p-2">Tipo de usuario:</label>
									<select id="inputState" class="form-select" name="tipo_usuario">
										<option  value="0" selected>Seleccione tipo de usuario</option>
										<?php 
											$query = $con -> prepare("SELECT * FROM perfiles");
											$query -> execute();
											foreach ($query as $key ) {
												if($key[id_perfil] == 1 || $key[id_perfil] == 2 || $key[id_perfil] == 5) {
													echo '<option value ="'.$key[id_perfil].'">'.$key[nombre_perfil].'</option>';					 	
												}				 	
											} 
										?>
									</select>
								</div>
								<div class="col-md-4">
									<label for="inputState" class="form-label p-2">Estado de usuario:</label>
									<select id="inputState" class="form-select" name="estado_usuario">
										<option  value="0" selected>Seleccione estado de usuario</option>
										<?php 
											$query = $con -> prepare("SELECT * FROM estados");
											$query -> execute();
											foreach ($query as $key) {
												echo '<option value ="'.$key[id_estado].'">'.$key[nombre_estado].'</option>';					 	
											} 
										?>
									</select>
								</div>
								<div class="col-md-4">
									<label for="inputState" class="form-label p-2">Número de carnet:</label>
									<input class="form-control" type="text" name="numero_carnet" placeholder="Ingrese Numero de carnet" value=" <?php if($resultado) echo $resultado['numero_carnet']; ?>" required>
								</div>	
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Nombre:</label>
									<input class="form-control" type="text" name="nombre" placeholder="Digite Nombre" value=" <?php if($resultado) echo $resultado['nombre']; ?>" onkeypress="return soloLetras(event)" required>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Apellido:</label>
									<input class="form-control" type="text" name="apellido" placeholder="Digite Apellido" value=" <?php if($resultado) echo $resultado['apellido']; ?>" onkeypress="return soloLetras(event)" required>
								</div>
								<div class="col-md-4 d-none">
									<label for="inputState" class="form-label p-2">Contraseña:</label>
									<input class="form-control" type="password" name="contrasenia" placeholder="Digite Contraseña" value=" <?php if($resultado) echo $resultado['contrasenia']; ?>" onclick="funcion_javascript()" required>
								</div>	
								<div class="col-12 text-center">
									<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white mt-2 shadow">
								</div>
							</form>	

						</div>
						<div class="card-footer text-muted text-center pt-3">
							<!-- Botones atras y refrescar -->
							<div class="row align-items-center">
								<div class="col-6 mb-2">
									<a href="usuarios.php" class="btn btn-outline-success ">
										<i class="fas fa-chevron-left fa-lg " title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="update_usuario.php?id_usuario=<?php if($resultado) echo $resultado['id_usuario']; ?>" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Columna vacia esta ahí para el correcto funcionamiento del diseño responsive -->
				<div class="col-2"></div>
			</div>
		</div>
		<div class="row d-none d-sm-none d-md-none d-lg-none d-xl-block">
			<!-- FOOTER -->
			<?php include_once "../plantillas/footer.php" ?>
		</div>
	</body>
</html>