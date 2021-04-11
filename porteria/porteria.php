<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
      $title="Confirmar";
      include_once "../plantillas/head.php";
    ?>
  </head>
  <body style="font-family: 'Noto Sans JP', sans-serif; " class=" bg-dark">
    <?php         
      include_once "../conexion.php";

      if(isset($_POST['salir'])){
        header ('location: ../index.php');
      }

      if (isset($_POST['guardar'])){
        $sql= "call spBuscarUsuarioCarnet(?)";
        try {
          $stmt = $con -> prepare($sql);
          $stmt ->  bindParam(1, $_POST['carnet'], PDO::PARAM_STR);
          $stmt -> execute();
          $resulSet = $stmt -> fetch();          

          if(!empty($resulSet)){                    
            if ($resulSet['estado_usuario']==2){
              echo "<script>alertError('Este usuario tiene un articulo en prestamo')</script>";
            }

            if ($resulSet['estado_usuario']==1){
              echo "<script>alertOk('Este usuario no tiene un articulo en prestamo')</script>";
            }
          } else{
            echo "<script>alertError('Este usuario no existe en la base de datos')</script>";
          }           
        } catch (PDOException $e) {
          echo "error en porteria".$e -> getMessage();
        }
      }
    ?>
    <div class="container ">  
      <div class="text-center m-5">
        <img src="../img/LogoSloanBlanco.png" alt="auto" width="200" class="logo img-fluid ">
      </div>      
      <div class="row align-items-center">
        <form class="col-12 text-center justify-content-center align-items-center" method="post">
          <input class="form-control" name="carnet"  id="carnet" type="text" placeholder="Introduzca numero de carnet" aria-label="default input example"  >
          <button class="  btn btn-block btn-outline-light  login-btn  m-3" id="guardar" name="guardar">Confirmar</button>
          <a href="../index.php" class="  btn btn-block btn-outline-light  login-btn  m-3" id="salir" name="salir">Salir</a>
        </form>
      </div>            
    </div>
    <div  class="container-fluid position-absolute bottom-0 end-0 ">
      <div class="row p-3 bg-dark text-warning pt-3">        
        <div class="co-12 text-center bg-dark text-white pt-5">
          <h6 class="h6"> &#169; 2021 Realizado por Camilo Sánchez y Sergio Montoya</h6>
          <h6 class="h6">Centro de Diseño y Manufactura del Cuero</h6>
          <span><img src="../img/LogoSena.png" alt="Logo SENA" width="50"></span>
        </div>
      </div>
    </div>
  </body>
</html>