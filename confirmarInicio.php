<?php

  session_start();

  function confirmar($tipo){

    if ($_SESSION['tipo'] != $tipo){

      if ($_SESSION['tipo'] == 1){

        header('location: ../admin/home.php');

      }


      if ($_SESSION['tipo'] == 2){

        header('location: ../monitor/home.php');

      }

      

      if(!isset($_SESSION['tipo'])){

        echo "<script>alertError('No hay sesiones iniciadas');<script>";

        header('location: ../index.php');

      }

    }

  }

?>