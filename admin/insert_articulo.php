<?php

	include_once "../conexion.php";

	if (isset($_POST['btn_guardar'])){

		//no se coloca el campo primario
		$categoria=$_POST['categoria'];
		$nombre_articulo=$_POST['nombre_articulo'];
		$descripcion=$_POST['descripcion'];
		$codigo_barras=$_POST['codigo_barras'];
		$disponibilidad=$_POST['disponibilidad'];
		$estado=$_POST['estado'];

		if (!empty ($categoria) && !empty ($nombre_articulo) && !empty($descripcion) && !empty($codigo_barras) && !empty($disponibilidad) && !empty($estado)){
			$insert_articulo= $con-> prepare ('INSERT INTO articulos(categoria,nombre_articulo,descripcion,codigo_barras,disponibilidad,estado) VALUES (:categoria,:nombre_articulo,:descripcion,:codigo_barras,:disponibilidad,:estado)');
			$insert_articulo-> execute(array(			
				':categoria'=>$categoria,
				':nombre_articulo'=>$nombre_articulo,
				':descripcion'=>$descripcion,
				':codigo_barras'=>$codigo_barras,
				':disponibilidad'=>$disponibilidad,
				':estado'=>$estado
			));

			header('location: inventario.php');

		}else {
			echo '<script language="javascript">alert("Debes seleccionar una categoria");</script>';
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
		
		<title>Inventario Sloan</title>
		<link rel="shortcut icon" href="../img/LogoS.png">

		<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="../js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/alertas.js"></script>
	</head>
	
	<body style="font-family: 'Noto Sans JP', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
		
		<!-- BARRA NAVEGACION -->
        <?php include_once "../plantillas/navegacion.plantilla.php" ?>

        <!-- Contenedor -->
		<div class="container mt-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="card shadow mt-4">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="h2 text-success" style="font-family: 'Noto Sans JP', sans-serif;">Agregar Artículo</h2>
							</div>
						</div>
						<div class="card-body">

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
									<label for="inputState" class="form-label p-2">Artículo:</label>
									<input class="form-control" type="text" name="nombre_articulo" placeholder="Ingrese el nombre del artículo" onkeypress="return soloLetras(event)" required>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Descripción:</label>
									<input class="form-control" type="text" name="descripcion" placeholder="Ingrese la marca o descripción del articulo" required>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label p-2">Codigo de barras:</label>
									<input class="form-control" type="text" name="codigo_barras" placeholder="Codigo de barras" required>
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
						<div class="card-footer text-muted text-center pt-3">

							<!-- Botones atras y refrescar -->
							<div class="row align-items-center">
								<div class="col-6 mb-2">
									<a href="inventario.php" class="rounded-circle p-2 bg-success border border-3 border-white text-decoration-none mt-2">
										<i class="fas fa-chevron-left fa-lg text-white" title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="insert_articulo.php" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
								</div>
							</div>

						</div>
					</div>
				</div>
				<!-- Columna vacia esta ahí para el correcto funcionamiento del diseño responsive -->
				<div class="col-2"></div>
			</div>
		</div>

	</body>
</html>