<?php 

    include_once "../confirmarInicio.php";

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
        
        <title>Sloan</title>
        <link rel="shortcut icon" href="../img/LogoS.png">

        <!-- Scripts de Bootstrap -->
        <script type="text/javascript" src="../js/jquery-3.5.1.slim.min.js"></script>
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    </head>
    
    <body style="font-family: 'Noto Sans JP', sans-serif;">
       
        <!-- BARRA NAVEGACION -->
        <?php include_once "../plantillas/navegacion.plantilla.php" ?>

        <!-- CARRUSEL -->
        <?php include_once "../plantillas/carrusel.plantilla.php" ?>

        <!-- Contenedor -->
        <div class="container-fluid">
            
            <!-- CONTENIDO -->
            <?php include_once "../plantillas/contenido.plantilla.php" ?>

            <!-- TUTORIALES -->
            <?php include_once "../plantillas/tutoriales.plantilla.php" ?>
            
        </div>
    </body>
</html>
<?php 
    
    endif;
    if ($confirmar -> verificar() == false){
        header('location: ../index.php');
    }

?>