<?php
	include_once "../confirmarInicio.php";
	include_once "../conexion.php";
	confirmar(1);

	try {
		if (isset ($_GET['id_usuario'])){
			$id_usuario =(int)$_GET['id_usuario'];
			$delete_usuario = $con -> prepare('DELETE FROM usuarios WHERE id_usuario=:id_usuario');
			$delete_usuario -> execute(array(':id_usuario'=>$id_usuario));
			echo '<script> alert("Se elimino el usuario")</script>';
			echo '<script> window.location="usuarios.php";</script>';
		} else {
			echo '<script> alert("No se pudo eliminar el usuario")</script>';
			echo '<script> window.location="usuarios.php";</script>';
		}
	} catch (PDOException $e) {
		echo '<script> alert("No es posible eliminar este usuario, usuario relacionado con un préstamo devolución o incidenca")</script>';
		echo '<script> window.location="usuarios.php";</script>';
	}
?>