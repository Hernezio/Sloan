<?php 
  include_once "../confirmarInicio.php";
  confirmar(1);
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <?php 
      $title="Administrador";
      include_once "../plantillas/head.php" 
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif;">
    <?php

      // BARRA NAVEGACION
      include_once "../plantillas/navegacion.plantilla.php";

      // CARRUSEL
      include_once "../plantillas/carrusel.plantilla.php";
    ?>
    <div class="container-fluid">
      <?php 
        // CONTENIDO
        include_once "../plantillas/contenido.plantilla.php";

        // TUTORIALES
        include_once "../plantillas/tutoriales.plantilla.php";
      ?>
    </div>
  </body>
</html>