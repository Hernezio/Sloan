<?php 
include_once "../confirmarInicio.php";
confirmar(2);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<?php 
			$title="Actualiza incidencia";
			include_once "../plantillas/head.php";
		?>
	</head>
	<body style="font-family: 'Noto Sans JP', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
		<?php
			include_once "../conexion.php";

			if (isset($_GET['id_incidencia'])){
				$id_incidencia=(int)$_GET['id_incidencia'];
				$buscar_registro=$con->prepare('SELECT * FROM incidencias WHERE id_incidencia= :id_incidencia');
				$buscar_registro -> execute(array(':id_incidencia'=>$id_incidencia));
				$resultado= $buscar_registro -> fetch();
				// $resultado->closeCursor();
			}else {
				header('location: inciencia.php');
			}

			if (isset($_POST['btn_guardar'])) {
				$id_det_devolucion=$_POST['id_det_devolucion'];
				$tipo_incidencia=$_POST['tipo_incidencia'];
				$observaciones=$_POST['observaciones'];
				$id_incidencia=(int)$_GET['id_incidencia'];

				if (!empty ($id_incidencia) && !empty ($id_det_devolucion) && !empty ($tipo_incidencia) && !empty($observaciones) && !empty($id_incidencia)){
					$modificar_articulo= $con-> prepare ('UPDATE incidencias SET id_det_devolucion=:id_det_devolucion, tipo_incidencia=:tipo_incidencia, observaciones=:observaciones WHERE id_incidencia=:id_incidencia');
					$modificar_articulo-> execute(array( 
						':id_incidencia'=>$id_incidencia,
						':id_det_devolucion'=>$id_det_devolucion, 
						':tipo_incidencia'=>$tipo_incidencia, 
						':observaciones'=> $observaciones
					));
					echo '<script language="javascript">alertOk("Incidencia actualizada");</script>';
					echo '<script type="text/javascript">window.location="incidencia.php";</script>';
				} else {
					echo '<script language="javascript">alertError("Debe seleccionar id de devolución y el tipo de incidencia");</script>';
				}
			}

			// BARRA NAVEGACION
			include_once "../plantillas/navegacion.plantilla.php";
		?>
		<!-- FORMULARIO -->
		<div class="container mt-5 mb-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8 mt-3">
					<div class="card shadow">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="h2 text-success" style="font-family: 'Yusei Magic', sans-serif;">Modificar Incidencia</h2>
								<label class="h6 fw-bold text-success">Nº <?php if($resultado) echo $resultado['id_incidencia']; ?></label>
							</div>
						</div>
						<div class="card-body">
							<form class="row g-3 p-3" action="" method="POST">
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Id devolución</label>
									<input type="text" id="text" class="form-control" name="id_det_devolucion" placeholder="Id devolución" required>
									<!-- <label for="inputState" class="form-label p-2">Detalle de devolución:</label>
									<select id="inputState" class="form-select" name="id_det_devolucion">
										<option  value="0" selected>Seleccione detalle de devolución</option>
										<?php 
											$query = $con -> prepare("SELECT * FROM det_devolucion");
											$query -> execute();
											foreach ($query as $key ) {
												echo '<option value ="'.$key[id_det_devolucion].'">'.$key[id_devolucion].'</option>';					 	
											} 
										?>
									</select> -->
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Daño o Perdida?</label>
									<select class="form-select h6" name="tipo_incidencia" id="inputState">
										<option value="0">Seleccione una opción</option>
										<option value="1">Daño</option>
										<option value="2">Perdida</option>
									</select>
								</div>
								<div class="col-12">
									<label for="inputState" class="form-label p-2">Observaciones:</label>
									<textarea class="form-control" name="observaciones" placeholder=" <?php if($resultado) echo $resultado['observaciones']; ?>" required></textarea>		
								</div>
								<div class="col-12 text-center">
									<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white mb-3 mt-2 shadow">
								</div>
							</form>	
						</div>
						<div class="card-footer text-muted text-center pt-3">
							<div class="row align-items-center">
								<!-- Botones atras y refrescar -->
								<div class="col-6 mb-2">
									<a href="incidencia.php" class="btn btn-outline-success ">
										<i class="fas fa-chevron-left fa-lg " title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="update_incidencia.php?id_incidencia=<?php if($resultado) echo $resultado['id_incidencia']; ?>" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Columna vacia, está ahí para el correcto funcionamiento del diseño responsive -->
				<div class="col-2"></div>
			</div>
		</div>
		<div class="row d-none d-sm-none d-md-none d-lg-none d-xl-block">
			<!-- FOOTER -->
			<?php include_once "../plantillas/footer.php" ?>
		</div>
	</body>
</html>