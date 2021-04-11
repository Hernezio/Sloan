<?php
  include_once "../conexion.php";
  include_once "../confirmarInicio.php";
  confirmar(1);

  $sentencia_select=$con->prepare('SELECT * FROM usuarios ORDER BY tipo_usuario ASC');
  $sentencia_select->execute();
  $resultado=$sentencia_select->fetchAll();

  if(isset($_POST['btn_buscar'])){
    $buscar_text=$_POST['buscar'];
    $select_buscar=$con->prepare('SELECT * FROM usuarios WHERE nombre LIKE :campo OR apellido LIKE :campo OR numero_carnet LIKE :campo ORDER BY id_usuario DESC;');
    $select_buscar->execute(array(':campo' =>"%".$buscar_text."%"));
    $resultado=$select_buscar->fetchAll();
  }
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <?php 
      $title="Usuario";
      include_once "../plantillas/head.php";
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <?php
      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php";

      // CARRUSEL CON BOTON DE BUSQUEDA
      $tituloCarrusel    = "Usuarios"; 
      $boton             = true;
      $hrefBoton         = "../admin/insert_usuario.php";
      $tituloBoton       = "Crear Usuario";
      $myModal           = "#usuario";
      include_once "../plantillas/carruselCrud.plantilla.php";              
      include_once "insert_usuario.php";
    ?>
    <!-- TABLLA  USUARIOS -->
    <div class="container mb-5">
      <div class="row pt-5 mb-5">
        <div class="col-12">
          <table id ="dataTable" class="table table-striped table-hover shadow bg-white rounded ">
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
                    <?php echo $fila['id_usuario'];?>                                         
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
                  <!-- BOTONES -->
                  <td <?php echo $class; ?> ><a href="update_usuario.php?id_usuario= <?php echo $fila['id_usuario']; ?>" class="h6 text-warning" ><i class="fas fa-edit"></i></a></td>
                  <td <?php echo $class; ?> ><a href="delete_usuario.php?id_usuario= <?php echo $fila['id_usuario']; ?>" class="h6 text-danger"  onclick="return confirmarEliminar()"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row d-none d-sm-none d-md-none d-lg-none d-xl-block">
        <!-- FOOTER -->
        <?php include_once "../plantillas/footer.php" ?> 
      </div>
    </div>
  </body>
</html>