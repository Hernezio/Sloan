<?php
  require_once "../conexion.php";
  include_once "../confirmarInicio.php";
  confirmar(2);

  $sentencia_select = $con -> prepare('CALL selectIncidencias()');
  $sentencia_select -> execute();	
  $resultado = $sentencia_select -> fetchAll();
  $sentencia_select -> closeCursor();

  // metodo buscar 
  if(isset($_POST['btn_buscar'])){
    $buscar_text = $_POST['buscar'];
    $select_buscar = $con->prepare('CALL buscarIncidencia(?)');
    $select_buscar -> bindParam (1, $buscar_text, PDO::PARAM_INT);
    $select_buscar -> execute();
    $resultado = $select_buscar -> fetchAll();
  }
?>

<!DOCTYPE html> 
<html lang="es">
  <head>
    <?php 
      $title="Incidencia";
      include_once "../plantillas/head.php";
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <?php 
      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php"; 

      // CARRUSEL CON BOTON DE BUSQUEDA
      $tipoBusqueda      = "incidencia por el id de incidencia";
      $tituloCarrusel    = "Incidencias";
      $boton             = true;
      $hrefBoton         = "../monitor/insert_incidencia.php";
      $tituloBoton       = "Crear incidencia";
      $myModal           = "#incidencias"; 
      include_once "../plantillas/carruselCrud.plantilla.php";

      // MODAL
      include_once "insert_incidencia.php";
    ?>
    <!-- TABLA INCIDENCIAS -->
    <div class="container mt-1 mb-5">
      <div class="row pt-5">
        <div class="col-12">
          <table id ="dataTable"  class="table table-striped table-hover shadow bg-white rounded">
            <thead>
              <tr class="text-center">
                <th class="fw-bold" scope="col">Nº Incidencia</th>
                <th class="fw-bold" scope="col">Nº Devolución</th>
                <th class="fw-bold" scope="col">Tipo de Incidencia</th>
                <th class="fw-bold" scope="col">Observaciones</th>
                <th class="fw-bold" scope="col">Informe</th>
                <th class="fw-bold" scope="col">Editar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($resultado as $fila):?>
                <?php if($fila ['tipo_incidencia'] == 1){ $tipoIncidencia = "Daño"; } else { $tipoIncidencia = "Perdida"; } ?>
                <tr class="text-center">
                  <th class="fw-bold" scope="row">
                    <?php echo $fila['id_incidencia']; ?> 
                  </th>
                  <td>
                    <?php echo $fila['id_det_devolucion']; ?> 
                  </td>
                  <td>
                    <?php echo $tipoIncidencia; ?>
                  </td>
                  <td>
                    <?php echo $fila['observaciones']; ?>
                  </td>
                  <!-- BOTONES -->
                  <td><a href="../pdf/index.php?id_incidencia= <?php echo $fila['id_incidencia']; ?>" target="_blank" class="text-success" title="Generar Informe"><i class="fas fa-file-pdf"></i></a></td>
                  <td><a href="update_incidencia.php?id_incidencia= <?php echo $fila['id_incidencia']; ?>" class="text-warning"><i class="fas fa-edit"></i></a></td>
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