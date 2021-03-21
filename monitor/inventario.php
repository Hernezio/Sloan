<?php
	
    include_once"../conexion.php";
    include_once "../confirmarInicio.php";
	
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
    
    $confirmar = new Confirmar();
    if ($confirmar -> verificar() == true):

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
    
	<body style="font-family: 'Noto Sans JP', sans-serif;">
        
        <!-- BARRA NAVEGACION -->
        <?php include_once "../plantillas/navegacion.plantilla.php" ?>  

        <!-- CARRUSEL CON BOTON DE BUSQUEDA -->
        <div class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../img/Fondo.jpeg" class="d-block w-100 h-100" alt="Logo Carrusel">
                </div>
                <div class="carousel-caption d-sm-block mt-sm-5 d-md-block">
                    <h1 class="h1 text-white mb-5 d-none d-md-block">Inventario</h1>
					<form class="row text-center justify-content-center align-items-center" method="post">
	                    <div class="input-group mb-3">
                            <span class="input-group-text mb-5" id="basic-addon1"><i class="fas fa-search"></i></span>
							<input type="text" class="form-control mb-5" name="buscar" placeholder="Buscar artículo" value="<?php if(isset($buscar_text)) echo $buscar_text; ?>">
                            <input type="submit" class="btn btn-warning text-white mb-5" name="btn_buscar" value="Buscar">
	                    </div>
					</form>
                </div>
            </div>
        </div>

		<!-- Contenedor -->
		<div class="container">
            
            <!-- TABLA -->
			<div class="row pt-5">
				<div class="col-12 table-responsive">
        			<table class="table table-striped table-hover shadow p-3 mb-5 bg-white rounded">
        				<thead>
        					<tr class="text-center">
        						<th class="fw-bold" scope="col">Nº Artículo</th>
        						<th class="fw-bold" scope="col">Nombre</th>
        						<th class="fw-bold" scope="col">Descripción</th>
        						<th class="fw-bold" scope="col">Código</th>
        						<th class="fw-bold" scope="col">Categoría</th>
								<th class="fw-bold" scope="col">Disponibilidad</th>
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
            					</tr>
        					<?php endforeach ?>                                                             
        				</tbody>
        			</table>                
				</div>
            </div> 

            <!-- CONTENIDO -->
            <?php include_once "../plantillas/contenido.plantilla.php" ?>

		</div>

	</body>
</html>

<?php 
    
    endif;
    if ($confirmar -> verificar() == false){
        header('location: ../index.php');
    }

?>