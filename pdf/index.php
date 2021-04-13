<?php
	session_start();
	require ('fpdf/fpdf.php');	

	class IncidenciaPdf extends FPDF {
		private $idIncidencia;

		function __construct($idIncidencia){
			$this -> idIncidencia = $idIncidencia;
		}

		function crearPDF(){
			include_once "../conexion.php";
			$query = "call spGenerarInforme(?)";

			try {

				$stmt = $con -> prepare($query);
				$stmt -> bindParam(1, $this -> idIncidencia, PDO::PARAM_INT);
				$stmt -> execute();
				$incidenciaTable = $stmt -> fetch();

				if($incidenciaTable['tipo_incidencia'] == 1){
					$tipo = "daño";
				}else {
					$tipo = "Perdida";
				}

				$stmt = $con -> prepare ('call buscarDetDevolucion(?)');
				$stmt -> bindParam(1, $incidenciaTable['id_det_devolucion'], PDO::PARAM_INT);
				$stmt -> execute();
				$detalleDevTable = $stmt -> fetch();

				$stmt = $con -> prepare ('call buscarDevolucion(?)');
				$stmt -> bindParam(1, $detalleDevTable['id_devolucion'], PDO::PARAM_INT);
				$stmt -> execute();
				$devolucionTable = $stmt -> fetch();

				$stmt = $con -> prepare ('call D_nombre(?,?)');
				$stmt -> bindParam(1, $devolucionTable['id_usuario'], PDO::PARAM_INT);
				$stmt -> bindParam(2, $devolucionTable['id_articulo'], PDO::PARAM_INT);

				$stmt -> execute();
				$datosUsuarioDevoluciones = $stmt -> fetch();

				$pdf = new FPDF();
				$pdf -> AddPage('potrait', 'Letter');

			//Header		
				$pdf -> SetFont('Arial', 'B', 14);
				$pdf -> Cell(0, 7, 'Informe de Incidencia', 0, 0, 'C');
				$pdf -> Ln();
				$pdf -> SetFont('Arial', 'B', 10);
				$pdf -> Cell(0, 6, utf8_decode('Centro de Diseño y Manufactura del Cuero'), 0, 0, 'C');
				$pdf -> Image('../img/LogoSloan.png', 175, 5, 30, 20, 'png');
				$pdf -> Ln(20);

			//Body	
				$pdf -> SetX(40);
				$pdf ->	SetFont('Arial','',10);				
				$pdf -> Write(16, utf8_decode('Mediante la presente se informa que el estudiante ' . $datosUsuarioDevoluciones['nombre'] . ' ' . $datosUsuarioDevoluciones['apellido'] . ','));
				$pdf -> Ln(5);
				$pdf -> SetX(40);

				$pdf -> Write(16, utf8_decode('con numero de carnet ' . $datosUsuarioDevoluciones['numero_carnet'] . ' ha sido reportado con una incidencia de tipo ' . $tipo . '.'));
				$pdf -> Ln(8);
				$pdf -> SetX(40);

				$pdf -> Write(16, utf8_decode('El artículo audiovisual relacionado con la incidencia es:' . $datosUsuarioDevoluciones['nombre_articulo'] . ' y la'));
				$pdf -> Ln(5);
				$pdf -> SetX(40);

				$pdf -> Write(16, utf8_decode('fecha en la que ocurrio la incidencia fue ' . $detalleDevTable['fecha_devolucion'] . '.'));
				$pdf -> Ln(8);
				$pdf -> SetX(40);

				$pdf -> Write(16, utf8_decode('Todos los encargados e interesados en el tema, porfavor tomar lo mas pronto '));
				$pdf -> Ln(5);
				$pdf -> SetX(40);

				$pdf -> Write(16, utf8_decode('posible las respectivas medidas en este caso.'));
				$pdf -> Ln(5);
				$pdf -> SetX(40);

				$pdf -> Ln(20);

				$pdf -> SetFont('Arial', 'B', 10);
				$pdf -> Cell(0, 6, utf8_decode('Detalles'), 0, 0, 'C');

			//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
				$pdf -> Ln(10);
				$pdf ->	SetFillColor(255, 246, 237);
				$pdf -> SetX(40);
				$pdf -> Cell(2);				
				$pdf ->	SetFont('Arial', 'B', 10);
				$pdf ->	Cell(65, 6, 'Id incidencia: ' . utf8_decode($incidenciaTable['id_incidencia']), 1, 0, 'L', 60);	
				$pdf ->	Cell(65, 6, 'Tipo incidenacidencia: ' . utf8_decode($tipo), 1, 0, 'L', 60);					
				$pdf -> Ln(6);

				$pdf ->	SetFillColor(255, 255, 255);
				$pdf ->	SetFont('Arial', '', 11);
				$pdf -> SetX(40);
				$pdf -> Cell(2);
				$pdf ->	MultiCell(130, 6, 'Observaciones: ' . utf8_decode($incidenciaTable['observaciones']),1 ,1, 'C', 20);

				$pdf ->	SetFillColor(255, 246, 237);
				$pdf ->	SetFont('Arial', 'B', 10);
				$pdf -> SetX(40);
				$pdf -> Cell(2);				
				$pdf ->	Cell(65, 6, 'Nombre Aprendiz: ' . utf8_decode($datosUsuarioDevoluciones['nombre']), 1 ,0, 'L',6 , 0);	
				$pdf ->	Cell(65, 6, 'Apellido Aprendiz: ' . utf8_decode($datosUsuarioDevoluciones['apellido']), 1, 0, 'L', 60);	
				$pdf -> Ln(6);

				$pdf ->	SetFillColor(255, 246, 237);
				$pdf ->	SetFont('Arial', 'B', 10);
				$pdf -> SetX(40);
				$pdf ->	Cell(2);				
				$pdf ->	Cell(65, 6, 'Nombe Articulo: ' . utf8_decode($datosUsuarioDevoluciones['nombre_articulo']), 1, 0, 'L', 60);
				$pdf ->	Cell(65, 6, 'Id Articulo: ' . utf8_decode($datosUsuarioDevoluciones['codigo_barras']), 1, 0, 'L', 60);
				$pdf -> Ln(10);

				$pdf -> SetX(75);
				$pdf ->	SetFont('Arial','',10);				
				$pdf -> Write(16, utf8_decode('Informe exportado por: ' . $_SESSION['nombre'] . '' . $_SESSION['apellido']));
				$pdf -> Ln(5);

				$pdf -> SetX(90);
				$pdf ->	SetFont('Arial','',10);				
				$pdf -> Write(16, utf8_decode('Fecha: 16/04/2021'));
				$pdf -> Ln(100);

				$pdf -> AliasNbPages();
				$pdf -> Cell(0,10, 'Pagina '.$pdf->PageNo() . '/{nb}', 0, 0, 'C');

				$pdf -> Output('I', 'Informe Sloan.pdf');

			} catch (PDOException $e) {
				echo "error en el pdf" . $e -> getMessage();
			}
		}

	}

	if (isset($_GET['id_incidencia'])){
		$objPDF = new IncidenciaPdf($_GET['id_incidencia']);
		$objPDF -> crearPDF();
	}

?>