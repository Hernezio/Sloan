<?php
  include_once "../conexion.php";
  include_once "../confirmarInicio.php";
  confirmar(1);
?>

<!DOCTYPE html> 
<html lang="es">
  <head>
    <?php 
      $title="Incidencias";
      include_once "../plantillas/head.php"; 
    ?> 
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <?php
      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php";

      // CARRUSEL CON BOTON DE BUSQUEDA
      $sentencia_select = $con -> prepare('SELECT * FROM incidencias ORDER BY id_incidencia DESC');
      $sentencia_select -> execute();
      $resultado = $sentencia_select -> fetchAll();
    
      if(isset($_POST['btn_buscar'])){
        $buscar_text = $_POST['buscar'];
        $select_buscar = $con->prepare('SELECT * FROM incidencias WHERE id_incidencia LIKE :campo');
        $select_buscar -> execute(array(':campo' =>"%".$buscar_text."%"));
        $resultado = $select_buscar -> fetchAll();

        if (empty($resultado)){
          echo "<script>alertError('No existen registros');</script>";
        }
      }

      $tituloCarrusel    = "Incidencias"; 
      $boton             = false;
      $hrefBoton         = NULL;
      $tituloBoton       = NULL;
      include_once "../plantillas/carruselCrud.plantilla.php";
    ?>  
    <!-- TABLA INCIDENCIAS -->
    <div class="container mb-5">
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
                <th class="fw-bold" scope="col">Borrar</th>
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
                  <td><a href="delete_incidencia.php?id_incidencia= <?php echo $fila['id_incidencia']; ?>" class="text-danger" onclick="return confirmarEliminar()"><i class="fas fa-trash-alt"></i></a></td>
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