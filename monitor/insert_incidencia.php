<?php
	include_once "../conexion.php";	

	if (isset($_POST['btn_guardar'])){
		$parametro = $_POST['id_det_devolucion'];
		$stmt = $con -> prepare('SELECT det_devolucion.id_det_devolucion FROM det_devolucion WHERE det_devolucion.id_devolucion = :parametro');
		$stmt -> execute(array(':parametro'=>$parametro ));
		$resultSet = $stmt -> fetch();
		$stmt -> closeCursor();

		if (!empty($resultSet)){
			$id_det_devolucion= $resultSet['id_det_devolucion'];
			$tipo_incidencia=$_POST['tipo_incidencia'];
			$observaciones=$_POST['observaciones'];

			try {
				if (!empty ($id_det_devolucion) && !empty ($tipo_incidencia) && !empty($observaciones)){
					$insert_devolucion= $con-> prepare ('INSERT INTO incidencias(id_det_devolucion, tipo_incidencia, observaciones) VALUES (:id_det_devolucion, :tipo_incidencia, :observaciones)');
					$insert_devolucion-> execute(array(
						':id_det_devolucion'=>$id_det_devolucion, 
						':tipo_incidencia'=>$tipo_incidencia,
						':observaciones'=>$observaciones
					));	
					echo '<script language="javascript">alertOk("Incidencia creada"); </script>';
					echo '<script type="text/javascript">window.location="incidencia.php";</script>';
				} else {
					echo '<script language="javascript">alertError("Debe seleccionar detalle de devolución y el tipo de incidencia");</script>';
				}
			} catch (PDOException $e) {
				if ($e = "SQLSTATE[23000]"){
					echo '<script language="javascript">alertError("Ya existe incidencia con este numero de devolución");</script>';
				}
			}				
		}
	}
?>

<!-- MODAL PARA AGREGAR INCIDENCIAS -->
<div id="incidencias" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- TITLE MODAL -->
			<div class="modal-header bg-success text-center">
				<h4 class="modal-title text-light ">Agregar Nueva incidencia</h4>
			</div>
			<!-- BODY MODAL -->
			<div class="modal-body">
				<form class="row g-3 p-3" action="" method="POST">
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Id devolución</label>
						<input type="text" id="text" class="form-control" name="id_det_devolucion" placeholder="Id devolución" required>
					</div>
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Daño o Perdida?</label>
						<select class="form-select" name="tipo_incidencia" id="inputState">
							<option value="0">Seleccione una opción</option>
							<option value="1">Daño</option>
							<option value="2">Perdida</option>
						</select>
					</div>
					<div class="col-12">
						<label for="inputState" class="form-label p-2">Observaciones:</label>
						<textarea class="form-control" name="observaciones" placeholder="Digite el motivo de la incidencia" required></textarea>		
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