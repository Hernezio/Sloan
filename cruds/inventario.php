<?php
	include_once"../conexion.php";
	$sentencia_select=$con->prepare('SELECT * FROM articulos ORDER BY disponibilidad ASC');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();
	// metodo buscar 
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$con->prepare('SELECT * FROM articulos WHERE id_articulo LIKE :campo OR nombre_articulo LIKE :campo OR descripcion LIKE :campo ORDER BY disponibilidad ASC;');
		$select_buscar->execute(array(':campo' =>"%".$buscar_text."%"));
		$resultado=$select_buscar->fetchAll();
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
		<title>Inventario Sloan</title>
		<link rel="shortcut icon" href="../img/LogoS.png">
	</head>
	<body style="font-family: 'Lato', sans-serif;">
        <!-- Contenedor #1 NAVBAR -->
        <div class="container-fluid">
            <div class="row bg-warning">
                <div class="col-12">
                    <nav class="navbar navbar-dark align-items-center p-3">
                        <a class="navbar-brand" href="../home1.php">
                            <span><i class="fas fa-home fa-2x"></i></span>
                            <h2 class="text-white h2 text-center d-inline">Administrador</h2>
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
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="inciencia.php">Incidencias</a></li>
                                <li class="nav-item"><a class="nav-link text-success h5 fw-bold disabled" href="inventario.php">Inventario</a></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="usuarios.php">Usuarios</a></li>
                                <li><div class="dropdown-divider"></div></li>
                                <li class="nav-item"><a class="nav-link text-white h5 fw-bold" href="../index.php">Salir</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>  
        <!-- CARRUSEL CON BOTON DE BUSQUEDA -->
        <div class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../img/Fondo.jpeg" class="d-block w-100 h-100" alt="Logo Carrusel">
                </div>
                <div class="carousel-caption d-sm-block mt-sm-5 d-md-block">
                    <h1 class="display-2 text-white mb-5 d-none d-md-block">Inventario</h1>
					<form class="row text-center justify-content-center align-items-center" method="post">
	                    <div class="input-group mb-3">
                            <span class="input-group-text mb-5" id="basic-addon1"><i class="fas fa-search"></i></span>
							<input type="text" class="form-control mb-5" name="buscar" placeholder="Buscar artículo" value="<?php if(isset($buscar_text)) echo $buscar_text; ?>">
                            <input type="submit" class="btn btn-warning text-white btn-lg mb-5" name="btn_buscar" value="Buscar">
	                    </div>
                        <div class="col-12">
                            <a href="insert_articulo.php" class="btn btn-success text-white btn-lg mb-5 ml-3 shadow">Agregar artículo</a>							
                        </div>
					</form>
                </div>
            </div>
        </div>
		<!-- Contenedor #2 -->
		<div class="container">
            <!-- TABLA -->
			<div class="row pt-5">
				<div class="col-12 table-responsive">
        			<table class="table table-striped table-hover shadow p-3 mb-5 bg-white rounded">
        				<thead>
        					<tr class="text-center">
        						<th class="h5 fw-bold" scope="col">Nº Artículo</th>
        						<th class="h5 fw-bold" scope="col">Nombre</th>
        						<th class="h5 fw-bold" scope="col">Descripción</th>
        						<th class="h5 fw-bold" scope="col">Código</th>
        						<th class="h5 fw-bold" scope="col">Categoría</th>
								<th class="h5 fw-bold" scope="col">Disponibilidad</th>
								<th class="h5 fw-bold" scope="col">Estado</th>
 		           				<th class="h5 fw-bold" scope="col">Editar</th>
                                <th class="h5 fw-bold" scope="col">Borrar</th>
        					</tr>
        				</thead>
        				<tbody>
                            <?php foreach($resultado as $fila):?>
                                <?php 
                                    if($fila ['categoria'] == 1) { 
                                        $categoria = "Computadoras"; 
                                    } else if ($fila ['categoria'] == 2) { 
                                        $categoria = "Video Beans"; 
                                    } else if ($fila ['categoria'] == 3) { 
                                        $categoria = "Accesorios"; 
                                    } 
                                    if ($fila['disponibilidad']==2 || $fila['estado'] == 2) {
                                        $disponibilidad = "Ocupado";
                                        $estados = "Inactivo";
                                        $estado = "class = \"h6 table-warning fw-bold text-danger\"";
                                        $estado2 = "class = \"h6 table-warning\"";
                                    }else {
                                        $disponibilidad = "Disponible";
                                        $estados = "Activo";
                                        $estado ="class = \"h6\"";
                                        $estado2 ="class = \"h6\"";
                                    }
                                ?>
            					<tr class="text-center">
    								<td <?php echo $estado2; ?> scope="row">
                                        <?php echo $fila['id_articulo']; ?> 
                                    </td>
    								<td <?php echo $estado2; ?> >
                                        <?php echo $fila['nombre_articulo']; ?> 
                                    </td>
    								<td <?php echo $estado2; ?> >
                                        <?php echo $fila['descripcion']; ?> 
                                    </td>
    								<td <?php echo $estado2; ?> >
                                        <?php echo $fila['codigo_barras'];?>
                                    </td>
    								<td <?php echo $estado2; ?> >
                                        <?php echo $categoria ?> 
                                    </td>
    								<td <?php echo $estado; ?> >
                                        <?php echo $disponibilidad; ?>
                                    </td>
    								<td <?php echo $estado2; ?> >
                                        <?php echo $estados; ?>
                                    </td>
    								<!-- BOTONES -->
    								<td <?php echo $estado2; ?> ><a href="update_articulo.php?id_articulo= <?php echo $fila['id_articulo']; ?>" class="h6 text-warning"><i class="fas fa-edit fa-lg"></i></a></td>
    								<td <?php echo $estado2; ?> ><a href="delete_articulo.php?id_articulo= <?php echo $fila['id_articulo']; ?>" onclick="return confirmarEliminar()" class="h6 text-danger"><i class="fas fa-trash-alt fa-lg"></i></a></td>
            					</tr>
        					<?php endforeach ?>                                                             
        				</tbody>
        			</table>                
				</div>
            </div>                 
            <!-- OPCIONES -->
            <div class="row mt-5" style="font-family: 'Yusei Magic', sans-serif;">
                <div class="col-12">
                    <div class="container bg-dark border shadow p-3 mb-5 rounded">
                        <div class="row text-center pt-4 pb-lg-4">
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="pb-2"><a href="devoluciones.php" class="text-info text-decoration-none">Devoluciones</a></h2>
                                <p class="text-secondary h6">Úsalo para tramitar</p>
                                <p class="text-secondary h6">devoluciones</p>
                                <p class="text-secondary h6">de artículos</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="pb-2"><a href="prestamo.php" class="text-primary text-decoration-none">Préstamos</a></h2>
                                <p class="text-secondary h6">Úsalo para tramitar</p>
                                <p class="text-secondary h6">préstamos</p>
                                <p class="text-secondary h6">de artículos</p>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <h2 class="pb-2"><a href="inciencia.php" class="text-success text-decoration-none">Incidencias </a></h2>
                                <p class="text-secondary h6">Úsalo para consultar</p>
                                <p class="text-secondary h6">reportes</p>
                                <p class="text-secondary h6">de incidencias</p>
                            </div>
                        </div> 
                        <div class="row text-center pt-sm-0 pb-4">
                            <div class="col-lg-6 col-md-6">
                                <h2 class="pb-2"><a href="inventario.php" class="text-secondary nav-link disabled text-decoration-none">Inventario</a></h2>
                                <p class="text-secondary h6">Úsalo para</p>
                                <p class="text-secondary h6">administrar</p>
                                <p class="text-secondary h6">tu inventario</p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <h2 class="pb-2"><a href="usuarios.php" class="text-danger text-decoration-none">Usuarios</a></h2>
                                <p class="text-secondary h6">Úsalo para tramitar</p>
                                <p class="text-secondary h6">administrar</p>
                                <p class="text-secondary h6">prestadores</p>
                            </div>
                        </div>           
                    </div> 
                </div>
            </div>
		</div>
		<!-- Scripts de Bootstrap -->
		<script type="text/javascript" src="../js/jquery-3.5.1.slim.min.js"></script>
		<script type="text/javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/alertas.js"></script>
	</body>
</html>