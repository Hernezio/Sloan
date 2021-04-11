<?php
	include_once "../confirmarInicio.php";
	include_once "../conexion.php";
	confirmar(1);

	if (isset($_POST['btn_guardar'])){
		//no se coloca el campo primario
		$categoria=$_POST['categoria'];
		$nombre_articulo=$_POST['nombre_articulo'];
		$descripcion=$_POST['descripcion'];
		$codigo_barras=$_POST['codigo_barras'];
		$disponibilidad=$_POST['disponibilidad'];
		$estado=$_POST['estado'];

		if (!empty ($categoria) && !empty ($nombre_articulo) && !empty($descripcion) && !empty($codigo_barras) && !empty($disponibilidad) && !empty($estado)){
			try {
				$insert_articulo= $con-> prepare ('INSERT INTO articulos(categoria,nombre_articulo,descripcion,codigo_barras,disponibilidad,estado) VALUES (:categoria,:nombre_articulo,:descripcion,:codigo_barras,:disponibilidad,:estado)');
				$insert_articulo-> execute(array(			
					':categoria'=>$categoria,
					':nombre_articulo'=>$nombre_articulo,
					':descripcion'=>$descripcion,
					':codigo_barras'=>$codigo_barras,
					':disponibilidad'=>$disponibilidad,
					':estado'=>$estado
				));
				echo "<script>alertOk('Artículo agregado con éxito');</script>";
				echo '<script type="text/javascript">window.location="inventario.php"</script>';
			} catch (Exception $e) {				
				echo "<script>alertError('El codigo de barras que está ingresando ya existe');</script>";
			}
		} else {
			echo "<script>alertError('Uno de los campos esta vacío');</script>";
		}
	}
?>

<!-- VENTANA MODAL DE INSERCIÓN -->
<div id="articulo" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-success text-center">
				<!-- 	TITULO MODAL -->
				<h4 class="modal-title text-light ">Agregar Nuevo Artículo</h4>
			</div>
			<!-- CUERPO MODAL -->
			<div class="modal-body">
				<!-- Formulario con campos a insertar -->
				<form class="row g-3 p-3" action="" method="POST">
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Categoria:</label>
						<select id="inputState" class="form-select" name="categoria">
							<option  value="0" selected >Seleccione categoria del artículo</option>
							<?php 
								$query = $con -> prepare("SELECT * FROM categorias");
								$query -> execute();
								foreach ($query as $key ) {
									echo '<option value ="'.$key[id_categoria].'">'.$key[nombre_categoria].'</option>';					 	
								} 
							?>
						</select>
					</div>
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Codigo de barras:</label>
						<input class="form-control" type="text" name="codigo_barras" placeholder="Codigo de barras" required>
					</div>	
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Artículo:</label>
						<input class="form-control" type="text" name="nombre_articulo" placeholder="Ingrese el nombre del artículo" onkeypress="return soloLetras(event)" required>
					</div>
					<div class="col-md-6">
						<label for="inputState" class="form-label p-2">Descripción:</label>
						<input class="form-control" type="text" name="descripcion" placeholder="Ingrese la marca o descripción del articulo" required>
					</div>
					<div class="col-md-4 d-none">
						<label for="inputState" class="form-label p-2">Disponibilidad:</label>
						<select id="inputState" class="form-select" name="disponibilidad">
							<?php 
								$query = $con -> prepare("SELECT * FROM disponibles");
								$query -> execute();
								foreach ($query as $key ) {
									echo '<option value ="'.$key[id_disponible].'">'.$key[nombre_disponible].'</option>';					 	
								} 
							?>
						</select>
					</div>
					<div class="col-md-4 d-none">
						<label for="inputState" class="form-label p-2">Estado:</label>
						<select id="inputState" class="form-select " name="estado">
							<?php 
								$query = $con -> prepare("SELECT * FROM estados");
								$query -> execute();
								foreach ($query as $key ) {
									echo '<option value ="'.$key[id_estado].'">'.$key[nombre_estado].'</option>';					 	
								} 
							?>
						</select>
					</div>	
					<div class="col-12 text-center">
						<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white mt-2 shadow">
					</div>
				</form>
			</div>
			<!--  FOOTER MODAL -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>    
		</div>
	</div>
</div>