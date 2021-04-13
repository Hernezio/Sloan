<div class="container-fluid position-absolute top-100 end-0 mt-5 pt-5" id="contenedor">

	<div class="row bg-dark text-warning pb-1 pt-1 ">        

		<div class="co-12 text-center bg-dark text-white pb-2 pt-2">

			<span><p class="h6"> &#169; 2021 Realizado por Camilo Sánchez y Sergio Montoya</p></span>

			<span><p class="h6">Centro de Diseño y Manufactura del Cuero</p></span>

			<span class="pb-2"><img src="../img/LogoSloan.png" alt="Logo SLOAN" width="40"></span>

		</div>

	</div>

</div>

<script>

	$(document).ready(function () {

		$('.sidebar-menu').tree();

	})

	$(function () { 


		$('#dataTable').DataTable({


			"language": {
				"decimal":        ".",

				"emptyTable":     "No tenemos datos para mostrar",

				"info":           "Desde _START_ Hasta _END_ (_TOTAL_ en total)",

				"infoEmpty":      "Desde 0 Hasta 0 (0 en total)",

				"infoFiltered":   "Filtrado de todas las _MAX_ entradas",

				"infoPostFix":    "",

				"thousands":      "'",

				"lengthMenu":     "",

				"loadingRecords": "Cargando...",

				"processing":     "Procesando...",

				"search":         "Buscar:",

				"zeroRecords":    "No hay resultados",

				"paginate": {

					"first":      "Primero",

					"last":       "Último",

					"next":       "Siguiente",

					"previous":   "Anterior"

				},

				"aria": {

					"sortAscending":  ": ordenar de manera Ascendente",
					"sortDescending": ": ordenar de manera Descendente ",

				}
			}

		});

	});

</script>
