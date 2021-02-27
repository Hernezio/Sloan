<?php
	$con = new mysqli('localhost', 'root', '', 'proyectosloan');
	if($con ->connect_error){
		die('Error en la conexion' . $con ->connect_error);
	}
?>