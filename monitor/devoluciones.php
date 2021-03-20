<?php

    include_once"../conexion.php";

    $sentencia_select = $con->prepare('SELECT * FROM devoluciones ORDER BY id_devolucion DESC');
    $sentencia_select -> execute();
    $tb_dev=$sentencia_select -> fetchAll();

    // metodo buscar 
    if(isset($_POST['btn_buscar'])) {
        $buscar_text = $_POST['buscar'];
        $select_buscar = $con->prepare('SELECT * FROM devoluciones WHERE id_devolucion LIKE :campo;');
        $select_buscar -> execute(array(':campo' =>"%".$buscar_text."%"));
        $tb_dev = $select_buscar -> fetchAll();
    }

    include_once "../confirmarInicio.php";
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
		
        <title>Devoluciones Sloan</title>
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
                    <h1 class="h1 text-white mb-5 d-none d-md-block">Devoluciones</h1>
					<form class="row text-center justify-content-center align-items-center" method="post">
	                    <div class="col-12 input-group mb-3">
                            <span class="input-group-text mb-5" id="basic-addon1"><i class="fas fa-search"></i></span>
							<input type="text" class="form-control mb-5" name="buscar" placeholder="Buscar devolución" value="<?php if(isset($buscar_text)) echo $buscar_text; ?>">
                            <input type="submit" class="btn btn-warning text-white mb-5" name="btn_buscar" value="Buscar">
	                    </div>
                        <div class="col-12">
                            <a href="insert_devoluciones.php" class="btn btn-success text-white mb-5 ml-3 shadow">Generar devolución</a>							
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
                                <th class="fw-bold" scope="col">Nº Devolución</th>
                                <th class="fw-bold" scope="col">Artículo</th>
                                <th class="fw-bold" scope="col">Codigo Artículo</th>
                                <th class="fw-bold" scope="col">Nombres</th>
                                <th class="fw-bold" scope="col">Apellidos</th>
                                <th class="fw-bold" scope="col">Carnet</th>
                                <th class="fw-bold" scope="col">Fecha</th> 
                                <th class="fw-bold" scope="col">Hora</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tb_dev as $f_dev):?>
                                <tr class="text-center">
                                    <?php
                                        $sentencia_select=$con->prepare('call D_nombre(?,?)');
                                        $sentencia_select->bindParam(1, $f_dev['id_usuario'], PDO::PARAM_INT);
                                        $sentencia_select->bindParam(2, $f_dev['id_articulo'], PDO::PARAM_INT);
                                        $sentencia_select->execute();
                                        $articulo = $sentencia_select->fetchAll();
                                        foreach ($articulo as $f_art){}
                                        $sentencia_select=$con->prepare('CALL select_detdev(?)');
                                        $sentencia_select->bindParam(1, $f_dev['id_devolucion'], PDO::PARAM_INT);
                                        $sentencia_select->execute();
                                        $detalle = $sentencia_select->fetchAll();
                                        foreach ($detalle as $f_det){}
                                        date_default_timezone_set("America/Bogota");
                                        $fechaPrestamo = $f_det['fecha_devolucion'];
                                        $fechaActual = date("Y-m-d");
                                        if ($fechaPrestamo == $fechaActual || isset($_POST['btn_buscar'])):
                                    ?>
                                    <td class="fw-bold" scope="row">
                                        <?php echo $f_dev['id_devolucion']; ?> 
                                    </td>
                                    <td>
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
                                        <?php echo $f_det['fecha_devolucion']; ?>
                                    </td>
                                    <td>
                                        <?php echo $f_det['hora_devolucion']; ?>
                                    </td>
                                </tr>
                                <?php  endif ?>
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