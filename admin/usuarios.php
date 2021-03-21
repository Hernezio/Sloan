<?php

	include_once"../conexion.php";
    include_once "../confirmarInicio.php";

	$sentencia_select=$con->prepare('SELECT * FROM usuarios ORDER BY tipo_usuario ASC');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$con->prepare('SELECT * FROM usuarios WHERE id_usuario LIKE :campo OR nombre LIKE :campo OR apellido LIKE :campo ORDER BY id_usuario DESC;');
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
		
        <title>Usuarios Sloan</title>
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
                    <h1 class="h1 text-white mb-5 d-none d-md-block">Usuarios</h1>
                    <form class="row text-center justify-content-center align-items-center" method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text mb-5" id="basic-addon1"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control mb-5" name="buscar" placeholder="Buscar usuario" value="<?php if(isset($buscar_text)) echo $buscar_text; ?>">
                            <input type="submit" class="btn btn-warning text-white mb-5" name="btn_buscar" value="Buscar">
                        </div>
                        <div class="col-12">
                            <a href="insert_usuario.php" class="btn btn-success text-white mb-5 ml-3 shadow">Agregar Usuario</a>                         
                        </div>
                    </form>
                </div>
            </div>
        </div>

		<!-- Contenedor #2 -->
		<div class="container">
           
            <!-- TABLA -->
			<div class="row pt-5">
				<div class="col-12">
        			<table class="table table-striped table-hover shadow p-3 mb-5 bg-white rounded">
        				<thead>
        					<tr class="text-center">
								<th class="fw-bold" scope="col">Nº Usuario</th>
								<th class="fw-bold" scope="col">Nombres</th>
								<th class="fw-bold" scope="col">Apellidos</th>
								<th class="fw-bold" scope="col">Nº Carnet</th>
								<th class="fw-bold" scope="col">Tipo</th>
								<th class="fw-bold" scope="col">Estado Usuario</th>
 		           				<th class="fw-bold" scope="col">Editar</th>
                                <th class="fw-bold" scope="col">Borrar</th>
        					</tr>
        				</thead>
        				<tbody>
							<?php foreach($resultado as $fila):?>
                                <?php 
                                    $sentencia_select=$con->prepare('CALL select_perfiles(?)');
                                    $sentencia_select->bindParam(1,$fila['tipo_usuario'], PDO::PARAM_INT);
                                    $sentencia_select->execute();
                                    $perfiles=$sentencia_select->fetchAll();
                                    foreach ($perfiles as $p_fila) {}
                                    if($fila['estado_usuario']==1){
                                        $estado = "Disponible";
                                        $class = "class=\"h6\"";
                                        $classt = "class=\"h6\"";
                                    }else {
                                        $estado = "No disponible";
                                        $class = "class=\"table-warning fw-bold text-danger\"";
                                        $classt = "class=\"h6 table-warning\"";
                                    }
                                ?>
            					<tr class="text-center">
    								<td <?php echo $classt; ?> scope="row">
                                        <?php echo $fila['id_usuario']; ?> 
                                    </td>
    								<td <?php echo $classt; ?> >
                                        <?php echo $fila['nombre']; ?> 
                                    </td>
    								<td <?php echo $classt; ?> >
                                        <?php echo $fila['apellido']; ?> 
                                    </td>
    								<td <?php echo $classt; ?> >
                                        <?php echo $fila['numero_carnet'];?>
                                    </td>
    								<td <?php echo $classt; ?> >
                                        <?php echo $p_fila['nombre_perfil']; ?> 
                                    </td>
    								<td <?php echo $class; ?> >
                                        <?php echo $estado; ?>
                                    </td>

    								<!-- <td <?php echo $classt; ?> >
                                        <?php echo $fila['contrasenia']; ?>
                                    </td> -->

    								<!-- BOTONES -->
    								<td <?php echo $class; ?> ><a href="update_usuario.php?id_usuario= <?php echo $fila['id_usuario']; ?>" class="h6 text-warning" ><i class="fas fa-edit"></i></a></td>
    								<td <?php echo $class; ?> ><a href="delete_usuario.php?id_usuario= <?php echo $fila['id_usuario']; ?>" class="h6 text-danger"  onclick="return confirmarEliminar()"><i class="fas fa-trash-alt"></i></a></td>
            					</tr>
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