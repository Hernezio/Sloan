<?php 
include_once "../confirmarInicio.php";
confirmar(2);
?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <?php 
      $title="Devoluciones";
      include_once "../plantillas/head.php";
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <?php
      // BACKEND PARA BUSCAR INFORMACION
      include_once "../conexion.php";
      
      $sentencia_select = $con->prepare('SELECT * FROM devoluciones ORDER BY id_devolucion DESC');
      $sentencia_select -> execute();
      $tb_dev=$sentencia_select -> fetchAll();

      if(isset($_POST['btn_buscar'])) {
        $buscar_text = $_POST['buscar'];
        $select_buscar = $con->prepare('SELECT * FROM devoluciones WHERE id_devolucion LIKE :campo;');
        $select_buscar -> execute(array(':campo' =>"%".$buscar_text."%"));
        $tb_dev = $select_buscar -> fetchAll();

        if (empty($tb_dev)){
          echo "<script> alertError('Id de devolucion no existe')</script>";
        }
      } 

      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php";

      // CARRUSEL CON BOTON DE BUSQUEDA
      $tipoBusqueda      = "devolución por el id de devolución";
      $tituloCarrusel    = "Devoluciones" ;
      $boton             = true;
      $hrefBoton         = "../monitor/insert_devoluciones.php";
      $tituloBoton       = "Crear devolución";
      $myModal           = "#devolucion";

      include_once "../plantillas/carruselCrud.plantilla.php";
      include_once "insert_devoluciones.php";
    ?>
    <!-- TABLA DEVOLUCIONES -->
    <div class="container mt-1 mb-5">
      <div class="row pt-5">
        <div class="col-12">
          <table id ="dataTable"  class="table table-striped table-hover shadow bg-white rounded">
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