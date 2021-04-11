<!-- CARRUSEL CON BOTON DE BUSQUEDA -->
<div class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <!-- Imagenes del carrusel -->
    <div class="carousel-item active">
      <img src="../img/reunion.jpg" class="d-block w-100 h-100" alt="Logo Carrusel">
    </div>       
    <div class="carousel-caption d-block d-absolute top-50 ">
      <h1 class="display-4 text-white mb-3">Bienvenido</h1>            
      <h4 class="h1 text-white mb-5"><?php echo $_SESSION['nombre']," ",$_SESSION['apellido'];?></h4>       
    </div>
  </div>
</div>