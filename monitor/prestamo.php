<?php

	include_once"../conexion.php";
    include_once "../confirmarInicio.php";

	$sentencia_select=$con->prepare('SELECT * FROM prestamos ORDER BY id_prestamo DESC');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();
	
    // Metodo buscar 
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$con->prepare('SELECT * FROM prestamos WHERE id_prestamo LIKE :campo OR id_usuario LIKE :campo OR id_articulo LIKE :campo;');
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
		
        <title>Préstamos Sloan</title>
		<link rel="shortcut icon" href="../img/LogoS.png">

        <!-- Scripts de Bootstrap -->
        <script type="text/javascript" src="../js/jquery-3.5.1.slim.min.js"></script>
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
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
                    <h1 class="h1 text-white mb-5 d-none d-md-block">Préstamos</h1>
					<form class="row text-center justify-content-center align-items-center" method="post">
	                    <div class="col-12 input-group mb-3">
                            <span class="input-group-text mb-5" id="basic-addon1"><i class="fas fa-search"></i></span>
							<input type="text" class="form-control mb-5" name="buscar" placeholder="Buscar préstamo" value="<?php if(isset($buscar_text)) echo $buscar_text; ?>">
                            <input type="submit" class="btn btn-warning text-white mb-5 d-inline-flex" name="btn_buscar" value="Buscar">
	                    </div>
                        <div class="col-12">
                            <a href="insert_prestamos.php" class="btn btn-success text-white mb-5 shadow">Generar Préstamo</a>							
                        </div>
					</form>
                </div>
            </div>
        </div>

		<!-- Contenedor -->
		<div class="container">
           
            <!-- TABLA -->
            <div class="row pt-5">
                <div class="col-12">
                    <table class="table table-striped table-hover shadow p-3 mb-5 bg-white rounded">
                        <thead>
                            <tr class="text-center">
                                <th class="fw-bold" scope="col">Nº Préstamo</th>
                                <th class="fw-bold" scope="col">Artículo</th>
                                <th class="fw-bold" scope="col">Codigo Artículo</th>
                                <th class="fw-bold" scope="col">Nombre</th>
                                <th class="fw-bold" scope="col">Apellido</th>
                                <th class="fw-bold" scope="col">Carnet</th>
                                <th class="fw-bold" scope="col">Fecha</th>
                                <th class="fw-bold" scope="col">Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($resultado as $f_dev):?>
                                <tr class="text-center">
                                    <?php
                                        $sentencia_select=$con->prepare('call p_nombre(?,?)');
                                        $sentencia_select->bindParam(1, $f_dev['id_usuario'], PDO::PARAM_INT);
                                        $sentencia_select->bindParam(2, $f_dev['id_articulo'], PDO::PARAM_INT);
                                        $sentencia_select->execute();
                                        $articulo = $sentencia_select->fetchAll();
                                        foreach ($articulo as $f_art){}
                                        $sentencia_select = $con->prepare('SELECT * FROM articulos ORDER BY id_articulo DESC');
                                        $sentencia_select->execute();
                                        $disponibilidad = $sentencia_select->fetchAll();
                                        $sentencia_select = $con->prepare('SELECT * FROM usuarios ORDER BY id_usuario DESC');
                                        $sentencia_select->execute();
                                        $est_usuario = $sentencia_select->fetchAll();
                                        //verifica que artículos estan prestados                                   
                                        foreach ($disponibilidad as $f_disp) {
                                            foreach ($est_usuario as $f_us) {
                                                if ($f_disp['id_articulo'] == $f_dev['id_articulo'] && $f_us['id_usuario']== $f_dev['id_usuario']) {                                                
                                                    if($f_disp['disponibilidad'] == 2 && $f_us['estado_usuario']==2) {                                                                                                
                                                        $estado = "class = \"h6 fw-bold text-danger\"";
                                                    }else {
                                                        $estado ="class = \"h6\"";
                                                    }
                                                }
                                            }
                                        }
                                        $sentencia_select=$con->prepare('CALL select_detprest(?)');
                                        $sentencia_select->bindParam(1, $f_dev['id_prestamo'], PDO::PARAM_INT);
                                        $sentencia_select->execute();
                                        $detalle = $sentencia_select->fetchAll();
                                        foreach ($detalle as $f_det){}
                                        date_default_timezone_set("America/Bogota");
                                        $fechaPrestamo = $f_det['fecha_Prestamo'];
                                        $fechaActual = date("Y-m-d");
                                        if ($fechaPrestamo == $fechaActual || isset($_POST['btn_buscar'])):
                                        
                                    ?>
                                    <th class="fw-bold" scope="row">
                                        <?php echo $f_dev['id_prestamo']; ?> 
                                    </th>
                                    <td  <?php echo $estado; ?> >
                                        <?php echo $f_art['nombre_articulo']; ?>
                                    </td>
                                    <td>
                                        <?php echo $f_art['codigo_barras']; ?>
                                    </td>
                                    <td>
                                        <?php echo $f_art['nombre']; ?>
                                    </td>
                                    <td>
                                        <?php echo $f_art['apellido']; ?>
                                    </td>
                                    <td>
                                        <?php echo $f_art['numero_carnet']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $f_det['fecha_Prestamo']; ?>
                                    </td>
                                    <td>
                                        <?php echo $f_det['hora_prestamo']; ?>
                                    </td>
                                </tr>
                                <?php endif?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- OPCIONES -->
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