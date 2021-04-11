<?php
	include_once "../confirmarInicio.php";
	include_once "../conexion.php";
	confirmar(1);
?>
<!-- MODAL -->
<div id="usuario" class="modal fade" role="dialog">
	<div class="modal-dialog">		
		<div class="modal-content">
			<!-- TITULO  MODAL -->
			<div class="modal-header bg-success text-center">
				<h4 class="modal-title text-light ">Agregar Nuevo Usuario</h4>
			</div>
			<!-- CUERPO MODAL -->
			<div class="modal-body">
				<?php
					if (isset($_POST['btn_guardar'])){
						if($_POST['tipo_usuario'] == 1 || $_POST['tipo_usuario'] == 2 || $_POST['tipo_usuario'] == 2){
							$tipo_usuario=$_POST['tipo_usuario'];
							$nombre=$_POST['nombre'];
							$apellido=$_POST['apellido'];
							$numero_carnet=$_POST['numero_carnet'];
							$estado_usuario=$_POST['estado_usuario'];
							$contrasenia=$_POST['contrasenia'];

							if (strlen($contrasenia)<=10){
								if (!empty ($tipo_usuario) && !empty ($nombre) && !empty($apellido) && !empty($numero_carnet) && !empty($estado_usuario) && !empty($contrasenia)){
									try {
										$insert_usuario= $con-> prepare ('INSERT INTO usuarios(tipo_usuario, nombre, apellido, numero_carnet, estado_usuario, contrasenia) VALUES (:tipo_usuario, :nombre, :apellido, :numero_carnet, :estado_usuario, :contrasenia)');
										$insert_usuario-> execute(array(			
											':tipo_usuario'		=>$tipo_usuario,
											':nombre'					=>$nombre,
											':apellido'				=>$apellido,
											':numero_carnet'	=>$numero_carnet,
											':estado_usuario'	=>$estado_usuario,
											':contrasenia'		=>$contrasenia
										));
										echo "<script> alertOk('Usuario agregado')</script>";
										echo '<script> window.location="usuarios.php";</script>';
									} catch (Exception $e) {
										//usuario ya existe
										echo "<script> alertError('El carnet que esta agregando ya existe') </script>";
									}
								} else {
									//campos vacios
									echo "<script> alertError('Debe llenar todos los campos') </script>";
								}
							}else{
								echo "<script> alertError('Introduzca una contraseña menor a 10 digitos') </script>";
							}
						} 
					}
				?>
				<form class="row g-3 p-3" action="" method="POST">
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Tipo de usuario:</label>
						<select id="inputState" class="form-select" name="tipo_usuario">
							<option  value="0" selected>Seleccione el rol del usuario</option>
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
					<div class="col-md-4">
						<label for="inputState" class="form-label p-2">Nombre:</label>
						<input class="form-control" type="text" name="nombre" placeholder="Digite Nombre" onkeypress="return soloLetras(event)" required>
					</div>
					<div class="col-md-4">
						<label for="inputState" class="form-label p-2">Apellido:</label>
						<input class="form-control" type="text" name="apellido" placeholder="Digite Apellido" onkeypress="return soloLetras(event)" required>
					</div>
					<div class="col-md-4">
						<label for="inputState" class="form-label p-2">Contraseña:</label>
						<input class="form-control" type="password" name="contrasenia" placeholder="Digite Contraseña" required="">
					</div>	
					<div class="col-12 text-center">
						<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white mt-2 shadow">
					</div>
				</form>	
			</div>
			<!-- FOOTER MODAL -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
			</div>    
		</div>
	</div>
</div>