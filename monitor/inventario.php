<?php
  include_once "../conexion.php";
  include_once "../confirmarInicio.php";
  confirmar(2);

  $sentencia_select=$con->prepare('SELECT * FROM articulos ORDER BY disponibilidad ASC');
  $sentencia_select->execute();
  $resultado=$sentencia_select->fetchAll();

  // metodo buscar 
  if(isset($_POST['btn_buscar'])){
    $buscar_text=$_POST['buscar'];
    $select_buscar=$con->prepare('SELECT * FROM articulos WHERE id_articulo LIKE :campo OR nombre_articulo LIKE :campo OR descripcion LIKE :campo ORDER BY disponibilidad ASC;');
    $select_buscar->execute(array(':campo' =>"%".$buscar_text."%"));
    $resultado=$select_buscar->fetchAll();
  }
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
      $tipoBusqueda      = "artículo por el id del artículo o nombre del artículo";         
      $tituloCarrusel    = "Inventario"; 
      $boton             = false;
      $hrefBoton         = NULL;
      $tituloBoton       = NULL;
      include_once "../plantillas/carruselCrud.plantilla.php";
    ?>       
    <!-- TABLA INVENTARIO -->
    <div class="container mt-1 mb-5">
      <div class="row pt-5">
        <div class="col-12 table-responsive">
          <table id ="dataTable" class="table table-striped table-hover text-white shadow mb-5 bg-white rounded">
            <thead>
              <tr class="text-center text-dark">
                <th class="fw-bold" scope="col">Nº Artículo</th>
                <th class="fw-bold" scope="col">Nombre</th>
                <th class="fw-bold" scope="col">Descripción</th>
                <th class="fw-bold" scope="col">Código</th>
                <th class="fw-bold" scope="col">Categoría</th>
                <th class="fw-bold" scope="col">Disponibilidad</th>
              </tr>
            </thead>
            <tbody class="text-dark">
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