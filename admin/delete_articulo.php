<?php
	include_once "../confirmarInicio.php";
	include_once "../conexion.php";
	confirmar(1);

	try {
		if (isset ($_GET['id_articulo'])){
			$id_articulo = (int)$_GET['id_articulo'];
			$delete_articulo = $con -> prepare('DELETE FROM articulos WHERE id_articulo=:id_articulo');
			$delete_articulo -> execute(array(':id_articulo'=>$id_articulo));			
			echo '<script> alert("Se elimino el artículo")</script>';
			echo '<script> window.location="inventario.php";</script>';
		} else {
			header ('location: inventario.php');
		}
	} catch (PDOException $e) {
		echo '<script> alert("No es posible eliminar este artículo, artículo relacionado con un préstamo devolución o incidenca")</script>';
		echo '<script> window.location="inventario.php";</script>';
	}
?>