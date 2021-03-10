<?php
	include_once "../conexion.php";
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
		//busco las filas de prestamos que contengan el id de usuario y el id de articulo
		$sentencia_select=$con->prepare('call confirmar_dev(?,?)');
		$sentencia_select->bindParam(1, $carnet['id_usuario'], PDO::PARAM_INT);
		$sentencia_select->bindParam(2, $codigo['id_articulo'], PDO::PARAM_INT);
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
			$sentencia_select = $con->prepare('SELECT * FROM articulos WHERE id_articulo LIKE :campo ORDER BY id_articulo ASC');
			$sentencia_select->execute(array(':campo'=>"%".$id_articulo."%"));
			$estado=$sentencia_select->fetchAll();
			/// NO ENTRA A ELFOR
			foreach ($estado as $f_art) {
				//compara id articulo con methodo post
				if ($id_articulo == $f_art['id_articulo']) {
					if ($f_art['disponibilidad']==2) {
						//agrega loas datos de metodo post a la tabla devoluciones
						$sentencia_insert=$con->prepare('CALL devolucion(?,?)');
						$sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
						$sentencia_insert->bindParam(2, $id_articulo, PDO::PARAM_INT);
						$sentencia_insert->execute();
						//Busca la tabla devoluciones para sacar el id y llenar el detallle de devolucion
						$sentencia_select=$con->prepare('SELECT * FROM devoluciones ORDER BY id_devolucion ASC');
						$sentencia_select->execute();
						$resultado=$sentencia_select->fetchAll();
						foreach ($resultado as $fila) {}
						//LLENAR DETALLE DEVOLUCION
						$sentencia_insert=$con->prepare('CALL det_devolucion(?)');
						$sentencia_insert->bindParam(1,$fila['id_devolucion'], PDO::PARAM_INT);
						$sentencia_insert->execute();
						//cambia de estado el usuario
						$sentencia_insert=$con->prepare('CALL estado_usuario(1,?)');
						$sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
						$sentencia_insert->execute();
						//cambia de estado el articulo
						$sentencia_insert=$con->prepare('CALL estado_prestamo(1,?)');
						$sentencia_insert->bindParam(1, $id_articulo, PDO::PARAM_INT);
						$sentencia_insert->execute();
						header('location: devoluciones.php');
					} else {
						echo '<script language="javascript">alert("Este artículo No ha sido préstado aun");</script>';
					}
				}
			}
		} else {
			echo '<script language="javascript">alert("Ingresa los datos correctamente");</script>';
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
		<title>Devoluciones Sloan</title>
		<link rel="shortcut icon" href="../img/LogoS.png">
	</head>
	<body style="font-family: 'Lato', sans-serif; background: -webkit-radial-gradient(top left, white, #fff4eb, white);  background-size:cover; height: 100%; background-attachment: fixed; ">
        <!-- Contenedor #1  NAVBAR -->
        <div class="container-fluid">
            <div class="row bg-warning">
                <div class="col-12">
                    <nav class="navbar navbar-dark align-items-center p-2">
                        <a class="navbar-brand justify-content-center align-items-center" href="../home2.php">
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
                                <li class="nav-item"><a class="nav-link text-success h5 fw-bold disabled" href="devoluciones.php">Devoluciones</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="prestamo.php">Préstamos</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="inciencia.php">Incidencias</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="inventario.php">Inventario</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="../home2.php#Tut">Tutoriales</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="usuarios.php">Usuarios</a></li>
                                <li><div class="dropdown-divider"></div></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="../index.php">Salir</a></li>
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
				<div class="col-8 mt-5">
					<div class="card shadow">
						<div class="card-header text-center">
							<div class="row text-center">
								<h2 class="display-4 text-success" style="font-family: 'Yusei Magic', sans-serif;">Generar Devolución</h2>
							</div>
						</div>
						<div class="card-body">
							<form class="row g-3" action="" method="POST">
								<div class="col-md-6">
									<label for="inputState" class="form-label h5 p-2">Numero carnet:</label>
									 <input type ="text" name ="carnet" class="form-control" placeholder="Carnet" required>
								</div>
								<div class="col-md-6">
									<label for="inputState" class="form-label h5 p-2">Artículo:</label>
									<input type ="text" name ="c_barras" class="form-control" placeholder="Codigo de barras" required>
								</div>
								<div class="col-12 text-center">
									<input type="submit" name="btn_guardar" value="Guardar" class="btn btn-success text-white btn-lg mb-3 mt-2 shadow">
								</div>
							</form>	
						</div>
						<div class="card-footer text-muted text-center pt-3">
							<div class="row align-items-center">
								<div class="col-6 mb-2">
									<a href="devoluciones.php" class="rounded-circle p-2 bg-success border border-3 border-white text-decoration-none mt-2">
										<i class="fas fa-chevron-left fa-lg text-white" title="Atras"></i>
									</a>							
								</div>
								<div class="col-6 mb-2">
									<a href="insert_devoluciones.php" name="btn_cancelar" class="btn btn-outline-success has-danger d-inline">Limpiar</a>
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