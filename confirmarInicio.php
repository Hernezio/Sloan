<?php  
    
    class Confirmar {
        private $carnet;

        function __construct(){
            session_start();
			ob_start();

            if (isset($_SESSION['carnetUsuario'])){
                $this -> carnet = $_SESSION['carnetUsuario'];
            }           
            
        }

        function verificar(){  
            include "conexion.php";
                      
            $sql = "call confirmarInicioSesion(?)";

            try {      
                
                $stmt =  $con -> prepare($sql);
                $stmt -> bindParam(1, $this -> carnet, PDO::PARAM_STR);
                $stmt -> execute();

                $resultSet = $stmt -> fetch();

                if ($resultSet['sesion'] == "activo" ){
                    $resultSet = true;
                }else{
                    $resultSet = false;
                }
            } catch (PDOException $e) {
                echo "error en confirmar sesion".$e-> getMessage();
            }
            return $resultSet;
        }

        function cerrarSesion(){
            include "conexion.php";
            $sesion = "inactivo";
            try {
                $stmt = $con -> prepare('call inicioSesion(?,?)');
				$stmt -> bindParam(1, $sesion, PDO::PARAM_STR);
				$stmt -> bindParam(2, $this -> carnet, PDO::PARAM_STR);
                $stmt -> execute();

                header('location: index.php');

                
            } catch (PDOException $e) {
                echo "error en cerrar sesion".$e-> getMessage();
            }
        }
    }
?>