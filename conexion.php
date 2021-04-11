<?php

  //$database	    ="proyectosloan";

  //$usuario		="root";

  //$password	    ="";


  $database     ="id16522369_proyectosloan";

  $usuario    ="id16522369_root";

  $password     ="oKAMQ$^q|e_!v7Oz";


  // Creamos un try con la cadena de conexion a la base de datos y un catch con un mensaje de error

  try {

    $con = new PDO('mysql:host=localhost;dbname='.$database, $usuario, $password);

    $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $con -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  



  } catch (PDOexception $e) {

    echo "Conexion Erronea".$e -> getMessage ();

  }

?>