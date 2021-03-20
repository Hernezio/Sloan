<?php

	include_once "../conexion.php";
	
	if (isset($_GET['id_incidencia'])){
		$id_incidencia=(int)$_GET['id_incidencia'];
		$buscar_registro=$con->prepare('SELECT * FROM incidencias WHERE id_incidencia= :id_incidencia');
		$buscar_registro -> execute(array(':id_incidencia'=>$id_incidencia));
		$resultado= $buscar_registro -> fetch();
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

			header('location: inciencia.php');
			
		} else {
			echo '<script language="javascript">alert("Debe seleccionar detalle de devolución y el tipo de incidencia");</script>';
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
		<link href="https://fonts.googleapis.com/css2?family=Lato&family=Yusei+Magic&display=swap" rel="stylesheet">
        
        <!-- ICONO Font Awesome -->
        <script src="https://kit.fontawesome.com/9f429f9981.js" crossorigin="anonymous"></script>
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../sass/custom.css">
		
		<title>Préstamos Sloan</title>
		<link rel="shortcut icon" href="../img/LogoS.png">
	</head>
	
	<body style="font-family: 'Lato', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
        
        <!-- Contenedor #1 NAVBAR -->
        <div class="container-fluid">
            <div class="row bg-warning">
                <div class="col-12">
                    <nav class="navbar navbar-dark align-items-center p-2">
                        <a class="navbar-brand" href="homeMonitor.php">
                            <span><i class="fas fa-home fa-2x"></i></span>
                            <h2 class="text-white h2 text-center d-inline">Monitor</h2>
                        </a>
                        <button class="navbar-toggler border-white" 
                            type="button" 
                            data-toggle="collapse" 
                            data-target="#navbarSupportedContent" 
                            aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                            title="Menu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li><div class="dropdown-divider"></div></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="devoluciones.php">Devoluciones</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="prestamo.php">Préstamos</a></li>
                                <li class="nav-item"><a class="nav-link text-success h5 fw-bold disabled" href="inciencia.php">Incidencias</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="inventario.php">Inventario</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="homeMonitor.php#Tut">Tutoriales</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="usuarios.php">Usuarios</a></li>
                                <li><div class="dropdown-divider"></div></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="../cerrarSession.php">Salir</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>  

        <!-- Contenedor #2 -->
		<div class="container mt-5">
			<div class="row pt-3">
				<div class="col-2"></div>
				<div class="col-8 mt-3">
					<div class="card shadow">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="display-4 text-success" style="font-family: 'Yusei Magic', sans-serif;">Modificar Incidencia</h2>
								<label class="h4 fw-bold text-success">Nº <?php if($resultado) echo $resultado['id_incidencia']; ?></label>
							</div>
						</div>
						<div class="card-body">
							<form class="row g-3" action="" method="POST">
								<div class="col-md-6">
									<label for="inputState" class="form-label h5 p-2">Detalle de devolución:</label>
									<select id="inputState" class="form-select h6" name="id_det_devolucion">
										<option  value="0" selected class="h6">Seleccione detalle de devolución</option>
										<?php 
											$query = $con -> prepare("SELECT * FROM det_devolucion");
											$query -> execute();
											foreach ($query as $key ) {
												echo '<option value ="'.$key[id_det_devolucion].'">'.$key[id_devolucion].'</option>';					 	
											} 
										?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label h5 p-2">Daño o Perdida?</label>
									<select class="form-select h6" name="tipo_incidencia" id="inputState">
										<option value="0">Seleccione una opción</option>
										<option value="1">Daño</option>
										<option value="2">Perdida</option>
									</select>
								</div>
								<div class="col-12">
									<label for="inputState" class="form-label h5 p-2">Observaciones:</label>
									<textarea class="form-control" name="observaciones" placeholder=" <?php if($resultado) echo $resultado['observaciones']; ?>" required></textarea>		
								</div>
								<div class="col-12 text-center">
									<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white btn-lg mb-3 mt-2 shadow">
								</div>
							</form>	
						</div>
						<div class="card-footer text-muted text-center pt-3">
							<div class="row align-items-center">
								<div class="col-6 mb-2">
									<a href="inciencia.php" class="rounded-circle p-2 bg-success border border-3 border-white text-decoration-none mt-2">
										<i class="fas fa-chevron-left fa-lg text-white" title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="insert_incidencia.php" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-2"></div>
			</div>
		</div>

		<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="../js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	</body>
</html>