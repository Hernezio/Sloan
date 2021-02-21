<?php
   $database="sloan";
   $usuario="root";
   $password="";
   try{
      $con=new PDO('mysql:host=localhost;dbname='.$database,$usuario,$password);
   }catch (PDOexception $e) {
      echo "Conexion Erronea".$e -> getMessage ();
   }
?>