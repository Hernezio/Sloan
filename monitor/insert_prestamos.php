<?php 
  if (isset($_POST['btn_crearPrestamo'])) {
    // busca un usuario con el carnet ingresado en el input y toma su id de usuario
    $sentencia_select=$con->prepare('call carnet_id(?)');
    $sentencia_select->bindParam(1, $_POST['carnetPrestamo'], PDO::PARAM_INT);
    $sentencia_select->execute();											
    $carnet=$sentencia_select->fetch();
    $sentencia_select=$con->prepare('call codigo_barras(?)');
    $sentencia_select->bindParam(1, $_POST['codigoBArticulo'], PDO::PARAM_INT);
    $sentencia_select->execute();											
    $codigo=$sentencia_select->fetch();

    // lleva los input a dos variables para lluego llevarlas a el procedimiento almacenado
    if (isset($codigo['id_articulo']) && isset($carnet['id_usuario'])){
        $id_articulo=$codigo['id_articulo'];
        $id_usuario=$carnet['id_usuario'];
    }
    
    if (!empty ($id_usuario) && !empty ($id_articulo)) {
      // traer tabla articulo para comparar
      $sentencia_select = $con->prepare('SELECT * FROM articulos ORDER BY id_articulo DESC');
      $sentencia_select->execute();
      $estado=$sentencia_select->fetchAll();
     
        //comparar articulo con metodo post para saber si esta diponible
        // este if confirma que el articulo se pueda prestar
        $disponibilidad = $codigo['disponibilidad'];
        $estadoArticulo = $codigo['estado'];

        if ($disponibilidad == 1 && $estadoArticulo == 1) {
          //este if confirma que el usuario pueda prestar
          if ($carnet['tipo_usuario']== 3 || $carnet['tipo_usuario']== 4 ){
            try {
              // inserta el id de usuario y el de articulo en la tabla de prestamos
              $sentencia_insert=$con->prepare('CALL spCrearPrestamos(?,?)');
              $sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
              $sentencia_insert->bindParam(2, $id_articulo, PDO::PARAM_INT);
              $sentencia_insert->execute();

              // cambia de estado el articulo
              $sentencia_insert=$con->prepare('CALL estado_prestamo(2,?)');
              $sentencia_insert->bindParam(1, $id_articulo, PDO::PARAM_INT);
              $sentencia_insert->execute();

              // cambia de estado el usuario
              $sentencia_insert=$con->prepare('CALL estado_usuario(2,?)');
              $sentencia_insert->bindParam(1, $id_usuario, PDO::PARAM_INT);
              $sentencia_insert->execute();

              $sentencia_select=$con->prepare('SELECT MAX(prestamos.id_prestamo) FROM prestamos;');
              $sentencia_select->execute();
              $resultado=$sentencia_select->fetch(); 
              
              
              //LLENAR DETALLE PRESTAMO
              $sentencia_insert=$con->prepare('CALL spCrearDetallePrestamo(?)');
              $sentencia_insert->bindParam(1,$resultado['MAX(prestamos.id_prestamo)'], PDO::PARAM_INT);
              $sentencia_insert->execute();

              echo '<script language="javascript">alertOk("Se ha registrado el préstamo");</script>';
              echo '<script> window.location="prestamo.php";</script>';

              
            } catch (PDOException $e) {
              echo "error ",$e->getMessage();
            }
          } else {
            echo '<script language="javascript">alertError("El usuario no tiene los permisos para acceder al servicio");</script>';
          }
        } else {
          echo '<script language="javascript">alertError("El artículo no se puede prestar");</script>';
        }
    }else {
      echo '<script language="javascript">alertError("Ingresa los datos correctamente");</script>';
    }
  }
?>

<!-- MODAL PARA AGREGAR PRESTAMOS -->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- TITLE MODAL -->
      <div class="modal-header bg-success text-center">
        <h4 class="modal-title text-light ">Crear préstamo</h4>
      </div>
      <!-- BODY MODAL -->
      <div class="modal-body">
        <form class="row g-3 p-3" action="" method="POST">
          <div class="col-md-6">
            <label for="inputState" class="form-label p-2">Numero carnet:</label>
            <input type ="text" name ="carnetPrestamo" class="form-control" placeholder="Carnet" required>
          </div>
          <div class="col-md-6">
            <label for="inputState" class="form-label p-2">Artículo:</label>
            <input type ="text" name ="codigoBArticulo" class="form-control" placeholder="codigo de barras" required>
          </div>
          <div class="col-12 text-center">
            <input type="submit" name="btn_crearPrestamo" value="Guardar" class="btn btn-success text-white mt-2 shadow">
          </div>
        </form>			
      </div>
      <!-- FOOTER MODAL -->
      <div class="modal-footer">
        <div class="row align-items-center">					
          <div class="col-6 mb-2">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>							
          </div>				
        </div>					
      </div>
    </div>
  </div>
</div>