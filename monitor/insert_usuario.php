<!-- MODAL PARA AGREGAR USUARIOS -->
<div id="usuario" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- TITLE MODAL -->
			<div class="modal-header bg-success text-center">
				<h4 class="modal-title text-light ">Crear usuario</h4>
			</div>
			<!-- BODY MODAL -->
			<div class="modal-body">
				<?php 
					if (isset($_POST['btn_guardar'])){
						if($_POST['tipo_usuario'] == 3 || $_POST['tipo_usuario'] == 4){
							$tipo_usuario=$_POST['tipo_usuario'];
							$nombre=$_POST['nombre'];
							$apellido=$_POST['apellido'];
							$numero_carnet=$_POST['numero_carnet'];
							$estado_usuario=$_POST['estado_usuario'];

							if (!empty ($tipo_usuario) && !empty ($nombre) && !empty($apellido) && !empty($numero_carnet) && !empty($estado_usuario)){
								try {
									$insert_usuario= $con-> prepare ('INSERT INTO usuarios(tipo_usuario,nombre,apellido,numero_carnet,estado_usuario) VALUES (:tipo_usuario,:nombre,:apellido,:numero_carnet,:estado_usuario)');
									$insert_usuario-> execute(array(			
										':tipo_usuario'=>$tipo_usuario,
										':nombre'=>$nombre,
										':apellido'=>$apellido,
										':numero_carnet'=>$numero_carnet,
										':estado_usuario'=>$estado_usuario
									));

									//usuario agregado alert  PRUEBA ----------------------->
									echo "<script> alertOk('Agregado con éxito'); location.href='usuarios.php';</script>";
								} catch (Exception $e) {
									//usuario ya existe
									echo "<script> alertError('El carnet que esta agregando ya existe') </script>";
								}
							} else {
								//no esta autorizado para agregar el tipo de usuario alert
								echo "<script> alertError( 'Debe llenar todos los campos' ) </script>	";
							}
						} else {
							echo "<script> alertError( 'No esta autorizado para agregar este tipo de usuario' ) </script>";
						}
					}
				?>
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
			<!-- FOOTER MODAL -->
			<div class="modal-footer">
				<div class="row align-items-center">					
					<div class="col-6 mb-2">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>							
					</div>				
				</div>					
			</div>
		</div>
	</div>
</div>