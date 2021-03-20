<?php
	
	require ('fpdf/fpdf.php');	
		
	class IncidenciaPdf {

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
				$pdf -> Addpage();

				//Header
				// Logo
				$pdf -> Image('../img/logoSloan.png',82,3,40);
				$pdf->	SetTextColor(240, 103, 12);
				
				// Arial bold 15
				$pdf -> SetFont('Arial','B',14);
				
				// Movernos a la derecha
				$pdf -> Cell(80);
				
				// Título
				$pdf -> Write(59,'Incidencia');
				
				// Salto de línea
				$pdf -> Ln(90);

				//Body							
				//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
				$pdf->	SetTextColor(0, 0, 0);
				$pdf->	SetFillColor(232,232,232);
				$pdf->	SetFont('Arial','B',10);
				$pdf-> 	Cell(2);				
				$pdf->	Cell(92,6,'Id incidencia: '.utf8_decode($incidenciaTable['id_incidencia']),1,0,'L',60);	
				$pdf->	Cell(92,6,'Tipo incidenacidencia: '.utf8_decode($tipo),1,0,'L',60);					
				$pdf -> Ln(6);

				$pdf->	SetFillColor(255, 255, 255);
				$pdf->	SetFont('Arial','B',10);
				$pdf-> 	Cell(2);				
				$pdf->	Cell(184,6,'Observaciones: '.utf8_decode($incidenciaTable['observaciones']),1,0,'L',60);
				$pdf -> Ln(6);
	
				$pdf->	SetFillColor(232,232,232);
				$pdf->	SetFont('Arial','B',10);
				$pdf-> 	Cell(2);				
				$pdf->	Cell(92,6,'Nombre Aprendiz: '.utf8_decode($datosUsuarioDevoluciones['nombre']),1,0,'L',60);	
				$pdf->	Cell(92,6,'Apellido Aprendiz: '.utf8_decode($datosUsuarioDevoluciones['apellido']),1,0,'L',60);	
				$pdf -> Ln(6);
				
				$pdf->	SetFillColor(255, 255, 255);
				$pdf->	SetFont('Arial','B',10);
				$pdf-> 	Cell(2);				
				$pdf->	Cell(92,6,'Nombe Articulo: '. utf8_decode($datosUsuarioDevoluciones['nombre_articulo']),1,0,'L',60);
				$pdf->	Cell(92,6,'Id Articulo: '. utf8_decode($datosUsuarioDevoluciones['codigo_barras']),1,0,'L',60);
				$pdf -> Ln(20);

				$pdf->	SetFont('Arial','',10);				
				$pdf -> Write(16,utf8_decode('Mediante la siguiente se informa que el estudiante '.$datosUsuarioDevoluciones['nombre'].' '.$datosUsuarioDevoluciones['apellido'].' con numero de carnet '.$datosUsuarioDevoluciones['numero_carnet']));
				$pdf -> Ln(8);
				$pdf -> Write(9,utf8_decode(' tubo una incidencia de tipo '.$tipo.' en la fecha '.$detalleDevTable['fecha_devolucion'].' con el dispositivo '.$datosUsuarioDevoluciones['nombre_articulo']. ' se informa a todos los encargados para tomar las medidas respectivas.'));

				$pdf -> Output('I', 'Informe Sloan.pdf');

			} catch (PDOException $e) {
				echo "error en el pdf". $e -> getMessage();
			}
		}

	}

	if (isset($_GET['id_incidencia'])){
		$objPDF = new IncidenciaPdf($_GET['id_incidencia']);
		$objPDF -> crearPDF();
	}
	
?>