<!-- CARRUSEL CON BOTON DE BUSQUEDA CRUDS -->
<div class="container mt-5">
  <div class="row">
    <div class="col-10 col-sm-10 col-md-10 col-lg-10 mt-5">
      <h1 class="h1 fw-bold text-success"><?php echo $tituloCarrusel?></h1>
    </div>
    <div  class="col-2 col-sm-2 col-md-2 col-lg-2 mt-5">
      <?php if ($boton == true):?>
        <button   type="button" class="btn btn-success text-light btn-lg fs-6" data-toggle="modal" data-target="<?php echo $myModal; ?>"><?php echo $tituloBoton; ?></button>    
      <?php endif?>
    </div>
  </div>
</div>