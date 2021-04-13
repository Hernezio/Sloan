<?php
  include_once "../conexion.php";
  include_once "../confirmarInicio.php";
  confirmar(1);   
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <?php 
      $title="Inventario";
      include_once "../plantillas/head.php";
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <?php 
      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php";

      // CARRUSEL CON BOTON DE BUSQUEDA
      $sentencia_select=$con->prepare('SELECT * FROM articulos ORDER BY disponibilidad ASC');
      $sentencia_select->execute();
      $resultado=$sentencia_select->fetchAll();

      // Metodo buscar 
      if(isset($_POST['btn_buscar'])){
        $buscar_text=$_POST['buscar'];
        $select_buscar=$con->prepare('SELECT * FROM articulos WHERE id_articulo LIKE :campo OR nombre_articulo LIKE :campo ORDER BY disponibilidad ASC;');
        $select_buscar->execute(array(':campo' =>"%".$buscar_text."%"));
        $resultado=$select_buscar->fetchAll();

        if (empty($resultado)) {
          echo "<script>alertError('No existen registros');</script>";
        }
      }

      $tituloCarrusel    = "Inventario"; 
      $boton             = true;
      $hrefBoton         = "../admin/insert_articulo.php";
      $tituloBoton       = "Crear artículo";
      $myModal           = "#articulo";
      include_once "../plantillas/carruselCrud.plantilla.php";
      include_once "insert_articulo.php";
    ?>         
    <!-- TABLA INVENTARIO -->
    <div class="container mb-5">
      <div class="row pt-5">
        <div class="col-12 table-responsive">
          <table id ="dataTable"  class="table table-striped table-hover shadow bg-white rounded">
            <thead>
              <tr class="text-center">
                <th class="fw-bold" scope="col">Nº Artículo</th>
                <th class="fw-bold" scope="col">Nombre</th>
                <th class="fw-bold" scope="col">Descripción</th>
                <th class="fw-bold" scope="col">Código</th>
                <th class="fw-bold" scope="col">Categoría</th>
                <th class="fw-bold" scope="col">Disponibilidad</th>
                <th class="fw-bold" scope="col">Editar</th>
                <th class="fw-bold" scope="col">Borrar</th>
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
                  } else {
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
                  <!-- BOTONES -->
                  <td <?php echo $estado2; ?> ><a href="update_articulo.php?id_articulo= <?php echo $fila['id_articulo']; ?>" class="h6 text-warning"><i class="fas fa-edit"></i></a></td>
                  <td <?php echo $estado2; ?> ><a href="delete_articulo.php?id_articulo= <?php echo $fila['id_articulo']; ?>" onclick="return confirmarEliminar()" class="h6 text-danger"><i class="fas fa-trash-alt"></i></a></td>
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