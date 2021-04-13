<?php
	include_once "../confirmarInicio.php";
	include_once "../conexion.php";
	confirmar(1);

	if (isset ($_GET['id_incidencia'])){
		$id_incidencia = (int)$_GET['id_incidencia'];
		$delete_incidencia = $con -> prepare('DELETE FROM incidencias WHERE id_incidencia=:id_incidencia');
		$delete_incidencia -> execute(array(':id_incidencia'=>$id_incidencia));
		echo '<script> alert("Se elimino la incidencia")</script>';
		echo '<script> window.location="incidencia.php";</script>';
	} else {
		echo '<script> alert("No se pudo eliminar la incidencia")</script>';
		echo '<script> window.location="incidencia.php";</script>';
	}
?>