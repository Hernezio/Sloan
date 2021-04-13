<?php
  include_once "../conexion.php";
  include_once "../confirmarInicio.php";
  confirmar(1);

  $sentencia_select=$con->prepare('SELECT * FROM prestamos ORDER BY id_prestamo DESC');
  $sentencia_select->execute();
  $resultado=$sentencia_select->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <?php 
      $title="Préstamos";
      include_once "../plantillas/head.php";
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <!--  -->
    <?php 

      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php";

      // CARRUSEL CON BOTON DE BUSQUEDA
      if(isset($_POST['btn_buscar'])){
        //buscar por carnet y articulo
        $sqlUser = "call selectUsuario(?)";
        $sqlArt = "call spBuscarArticulo(?)";
        $sqlPrestamo = "call spBuscarPrestamo(?)";
        $parametro = $_POST['buscar'];
        
        try {
          $stmt = $con -> prepare($sqlArt);
          $stmt -> bindParam(1, $parametro, PDO::PARAM_STR);
          $stmt -> execute();
          $resultSetArt = $stmt -> fetch(); 

          if (!empty($resultSetArt['id_articulo'])){
            $id = $resultSetArt['id_articulo'];
          }
        } catch (PDOException $e) {
          echo "error en btn buscar préstamo spBuscarArticulo ".$e -> getMessage();
        }

        try {
          $stmt = $con -> prepare($sqlUser);
          $stmt -> bindParam(1, $parametro, PDO::PARAM_STR);
          $stmt -> execute();
          $resultSetUser = $stmt -> fetch();

          if (!empty($resultSetUser['id_articulo'])){
            $id = $resultSetUser['id_articulo'];
          }                 
        } catch (PDOException $e) {
          echo "error en btn buscar préstamo selectUsuario ".$e -> getMessage();
        }

        try {            
          $stmt = $con -> prepare($sqlPrestamo);
          $stmt -> bindParam(1, $id, PDO::PARAM_INT);            

          $stmt -> execute();
          $resultado = $stmt -> fetchAll();
        } catch (PDOException $e) {
          echo "error en btn buscar préstamo spBuscarPrestamo".$e -> getMessage();
        }

        if (empty($resultado) && empty($resultSetArt) && empty($resultSetUser)){
          echo "<script>alertError('Prestamo no existe');</script>";
        }
      }

      $tipoBusqueda    = "préstamo por carnet o codigo de barras";
      $tituloCarrusel   = "Préstamos"; 
      $boton            = false;
      $hrefBoton        = NULL;
      $tituloBoton      = NULL;
      include_once "../plantillas/carruselCrud.plantilla.php";
    ?>    

    <!-- TABLA PRÉSTAMO -->
    <div class="container mb-5">
      <div class="row pt-5">
        <div class="col-12">
          <table id ="dataTable" class="table table-striped table-hover shadow bg-white rounded">
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