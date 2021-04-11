<?php 
include_once "../confirmarInicio.php";
confirmar(1);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<?php 
			$title="Actualizar artículo";
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
			if (isset($_GET['id_articulo'])){
				$id_articulo=(int)$_GET['id_articulo'];
				$buscar_registro=$con->prepare('SELECT * FROM articulos WHERE id_articulo= :id_articulo');
				$buscar_registro -> execute(array(':id_articulo'=>$id_articulo));
				$resultado= $buscar_registro -> fetch();
			} else {
				header('location: inventario.php');
			}

			if (isset($_POST['btn_guardar'])){
				$categoria=$_POST['categoria'];
				$nombre_articulo=$_POST['nombre_articulo'];
				$descripcion=$_POST['descripcion'];
				$codigo_barras=$_POST['codigo_barras'];
				$disponibilidad=$_POST['disponibilidad'];
				$estado=$_POST['estado'];
				$id_articulo=(int)$_GET['id_articulo'];

				if (!empty ($id_articulo) && !empty ($categoria) && !empty ($nombre_articulo) && !empty($descripcion)&& !empty($codigo_barras)&& !empty($disponibilidad)&& !empty($estado) && !empty($id_articulo)){
					$modificar_articulo= $con-> prepare ('UPDATE articulos SET categoria=:categoria, nombre_articulo=:nombre_articulo, descripcion=:descripcion, disponibilidad=:disponibilidad, estado=:estado WHERE id_articulo=:id_articulo');
					$modificar_articulo-> execute(array( 
						':id_articulo'=>$id_articulo,
						':categoria'=>$categoria, 
						':nombre_articulo'=>$nombre_articulo, 
						':descripcion'=> $descripcion,
						':disponibilidad'=>$disponibilidad,
						':estado'=>$estado
					));
					echo '<script> alertOk("Artículo modificado")</script>';
					echo '<script> window.location="inventario.php";</script>';
				} else {
					echo '<script language="javascript">alertError("Debes seleccionar una categoria");</script>';
				}
			}
		?>
		<div class="container mt-5 mb-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="card shadow mt-4">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="h2 text-success" style="font-family: 'Noto Sans JP', sans-serif;">Actualizar Artículo Audiovisual</h2>
								<label class="h6 fw-bold text-success">Nº <?php if($resultado) echo $resultado['id_articulo']; ?></label>
							</div>
						</div>
						<div class="card-body">
							<!-- Formulario con campos a modificar -->
							<form class="row g-3 p-3" action="" method="POST">
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Categoria:</label>
									<select id="inputState" class="form-select " name="categoria">
										<option  value="0" selected>Seleccione categoria del artículo</option>
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
									<input class="form-control" type="text" name="codigo_barras" placeholder="Codigo de barras" value=" <?php if($resultado) echo $resultado['codigo_barras']; ?>" required>
								</div>	
								<div class="col-md-4">
									<label for="inputState" class="form-label p-2">Artículo:</label>
									<input class="form-control" type="text" name="nombre_articulo" placeholder="Ingrese el nombre del artículo" value=" <?php if($resultado) echo $resultado['nombre_articulo']; ?>" onkeypress="return soloLetras(event)" required>
								</div>
								<div class="col-md-4">
									<label for="inputState" class="form-label p-2">Descripción:</label>
									<input class="form-control" type="text" name="descripcion" placeholder="Ingrese la marca o descripción del articulo" value=" <?php if($resultado) echo $resultado['descripcion']; ?>" required>
								</div>
								<div class="col-md-4 d-none">
									<label for="inputState" class="form-label p-2">Disponibilidad:</label>
									<select id="inputState" class="form-select " name="disponibilidad">
										<?php 
											$query = $con -> prepare("SELECT * FROM disponibles");
											$query -> execute();
											foreach ($query as $key ) {
												echo '<option value ="'.$key[id_disponible].'">'.$key[nombre_disponible].'</option>';					 	
											} 
										?>
									</select>
								</div>
								<div class="col-md-4">
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
						<div class="card-footer text-muted text-center pt-3">
							<!-- Botones atras y refrescar -->
							<div class="row align-items-center">
								<div class="col-6 mb-2">
									<a href="inventario.php" class="btn btn-outline-success ">
										<i class="fas fa-chevron-left fa-lg " title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="update_articulo.php?id_articulo=<?php if($resultado) echo $resultado['id_articulo']; ?>" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
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