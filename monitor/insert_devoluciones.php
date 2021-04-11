<!-- MODAL PARA AGREGAR DEVOLUCIONES -->
<div id="devolucion" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- TITLE MODAL -->
			<div class="modal-header bg-success text-center">
				<h4 class="modal-title text-light ">Devolver artículo</h4>
			</div>
			<div class="modal-body">
				<!-- BODY MODAL -->
				<?php
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
						
						if(isset($carnet['id_usuario'])&& isset($codigo['id_articulo'])){
						    $idA =$codigo['id_articulo'];
						    $idU =$carnet['id_usuario'];
						}

						//busco las filas de prestamos que contengan el id de usuario y el id de articulo
						$sentencia_select=$con->prepare('call confirmar_dev(?,?)');
						$sentencia_select->bindParam(1, $idU, PDO::PARAM_INT);
						$sentencia_select->bindParam(2, $idA, PDO::PARAM_INT);
						$sentencia_select->execute();											
						$confirmar=$sentencia_select->fetchAll();	

						if (!empty($confirmar)) {
							//recorre el array confirmar para luego elegir que fila 
							foreach ($confirmar as $filaV ) {}
							$id_articulo=$filaV['id_articulo'];
							$id_usuario=$filaV['id_usuario'];
						}
						
        			    

						if (!empty ($id_usuario) && !empty ($id_articulo)) {
							// buscar en la tabla articulo para luego comparar que exista
							$sentencia_select = $con->prepare('SELECT * FROM articulos WHERE id_articulo LIKE :campo ORDER BY id_articulo DESC');
							$sentencia_select->execute(array(':campo'=>"%".$id_articulo."%"));
							$estado=$sentencia_select->fetch();

									if ($estado['disponibilidad']==2) {
										//agrega loas datos de metodo post a la tabla devoluciones
										$sentencia_insert=$con->prepare('CALL spCrearDevolucion(?,?)');
										$sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
										$sentencia_insert->bindParam(2, $id_articulo, PDO::PARAM_INT);
										$sentencia_insert->execute();

										//Busca la tabla devoluciones para sacar el id y llenar el detallle de devolucion
										$sentencia_select=$con->prepare('SELECT MAX(devoluciones.id_devolucion) FROM devoluciones;');
										$sentencia_select->execute();
										$resultado=$sentencia_select->fetch();
										

										//LLENAR DETALLE DEVOLUCION
										$sentencia_insert=$con->prepare('CALL det_devolucion(?)');
										$sentencia_insert->bindParam(1,$resultado['MAX(devoluciones.id_devolucion)'], PDO::PARAM_INT);
										$sentencia_insert->execute();

										//cambia de estado el usuario
										$sentencia_insert=$con->prepare('CALL estado_usuario(1,?)');
										$sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
										$sentencia_insert->execute();

										//cambia de estado el articulo
										$sentencia_insert=$con->prepare('CALL estado_prestamo(1,?)');
										$sentencia_insert->bindParam(1, $id_articulo, PDO::PARAM_INT);
										$sentencia_insert->execute();
										echo '<script language="javascript">alertOk("Devolucion aprobada");</script>';
										echo '<script type="text/javascript">window.location="devoluciones.php";</script>';
									} else {
										echo '<script language="javascript">alertError("Este artículo No esta prestado");</script>';
									}
								
						} else {
							echo '<script language="javascript">alertError("No hay registros de prestamos con los datos ingresados");</script>';
						}
					}
				?>
				<!-- Formulario con campos a insertar -->
				<form class="row g-3 p-3" action="" method="POST">
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Numero carnet:</label>
						<input type ="text" name ="carnet" class="form-control" placeholder="Carnet" required>
					</div>
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Artículo:</label>
						<input type ="text" name ="c_barras" class="form-control" placeholder="Codigo de barras" required>
					</div>
					<div class="col-12 text-center">
						<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white mt-2 shadow">
					</div>
				</form>				
			</div>
			<!-- FOOTER MODAL -->
			<div class="modal-footer">
				<div class="row align-items-center">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>							
				</div>
			</div>
		</div>
	</div>
</div>