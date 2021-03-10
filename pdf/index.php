<?php
	require('fpdf/fpdf.php');
	require '../conexion.php';

	// Porcedimiento que muestra los datos del usuario vinculado a la incidencia
	// $query = "CALL spDatosInforme(9, 99)";
	$query = "
		SELECT 
			nombre AS Nombre, 
			apellido AS Apellido, 
			tipo_usuario AS TipoUsuario, 
			fecha_devolucion AS FechaIncidencia 
		FROM usuarios JOIN det_devolucion 
		WHERE id_usuario = 2 AND id_det_devolucion = 110
	";
	$resultado = $con -> query($query);

	// Procedimiento que muestra los datos de la incidencia
	$queryUno = "CALL spGenerarInforme(2, 2)";
	$resultadoUno = $con -> query($queryUno);

	// Definimos el PDF y su estilo
	$fpdf = new FPDF();
	$fpdf -> AddPage('potrait', 'Letter');

	// Clase para la Cabecera y Pie
	class pdf extends FPDF {
		public function header(){
			$this -> SetFont('Arial', 'B', 14);
			$this -> Cell(0, 7, 'Informe de Incidencia', 0, 0, 'C');
			$this ->  Ln();
			$this -> SetFont('Arial', 'B', 10);
			$this -> Cell(0, 6, 'Centro de Diseño y Manufactura del Cuero', 0, 0, 'C');
			$this -> Image('../img/LogoSloan.png', 175, 5, 30, 20, 'png');
		}
		public function footer(){
			$this -> SetFont('Arial', 'B', 10);
			$this -> SetY(-15);
			$this -> SetX(-30);
			$this -> AliasNbPages();
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}
	}

	// Contenido
	$fpdf = new pdf('P', 'mm', 'A5', true);
	$fpdf -> AddPage('potrait', 'letter');
	$fpdf -> SetFont('Arial', 'BU', 14);
	$fpdf -> SetY(40);
	$fpdf -> SetTextColor(0, 0, 0);
	$fpdf -> Cell(0, 5, 'Detalles del informe', 0, 0, 'C');
	$fpdf -> Ln(20);

	// Informacion Usuario
	$fpdf -> SetFontSize(10);
	while($row = $resultado -> fetch(PDO::FETCH_ASSOC)) {
		$fpdf -> SetX(40);
		$fpdf -> SetFont('Arial', 'B');	
		$fpdf -> Cell(5, 5, 'Nombre: ');
		$fpdf -> SetFont('Arial');
		$fpdf -> Cell(70, 5, $row['Nombre'], 0, 0, 'C');
		$fpdf -> SetX(110);
		$fpdf -> SetFont('Arial', 'B');	
		$fpdf -> Cell(5, 5, 'Apellido: ');
		$fpdf -> SetFont('Arial');
		$fpdf -> Cell(70, 5, $row['Apellido'], 0, 0, 'C');
		$fpdf -> Ln(10);
		$fpdf -> SetX(40);
		$fpdf -> SetFont('Arial', 'B');	
		$fpdf -> Cell(5, 5, 'Tipo de Usuario: ');
		$fpdf -> SetFont('Arial');
		$fpdf -> Cell(70, 5, $row['TipoUsuario'], 0, 0, 'C');
		$fpdf -> SetX(110);
		$fpdf -> SetFont('Arial', 'B');	
		$fpdf -> Cell(5, 5, 'Fecha Incidencia: ');
		$fpdf -> SetFont('Arial');
		$fpdf -> Cell(80, 5, $row['FechaIncidencia'], 0, 0, 'C');
	}
	$fpdf -> Ln(20);

	// Tabla
	$fpdf -> SetFont('Arial', 'B');	
	$fpdf -> SetFillColor(255, 246, 237);
	$fpdf -> Cell(30, 10, 'Incidencia Nº', 0, 0, 'C', 1);
	$fpdf -> Cell(30, 10, 'Articulo', 0, 0, 'C', 1);
	$fpdf -> Cell(30, 10, 'Descripción', 0, 0, 'C', 1);
	$fpdf -> Cell(30, 10, 'Categoria', 0, 0, 'C', 1);
	$fpdf -> Cell(30, 10, 'Tipo', 0, 0, 'C', 1);
	$fpdf -> Cell(45, 10, 'Observaciones', 0, 0, 'C', 1);
	$fpdf -> Line(10, 100, 205, 100);
	$fpdf -> Ln();

	// Registro
	$fpdf -> SetFont('Arial');	
	$fpdf -> SetFillColor(237, 237, 237);
	while($row = $resultadoUno -> fetch(PDO::FETCH_ASSOC)) {
		$fpdf -> Cell(30, 10, $row['IdIncidencia'], 0, 0, 'C', 1);
		$fpdf -> Cell(30, 10, $row['Articulo'], 0, 0, 'C', 1);
		$fpdf -> Cell(30, 10, $row['Descripcion'], 0, 0, 'C', 1);
		$fpdf -> Cell(30, 10, $row['TipoArticulo'], 0, 0, 'C', 1);
		$fpdf -> Cell(30, 10, $row['TipoIncidencia'], 0, 0, 'C', 1);
		$fpdf -> Cell(45, 10, $row['Observaciones'], 0, 0, 'C', 1);
	}
	$fpdf -> Output('I', 'Informe Sloan.pdf');
?>