<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap4/bootstrap.min.css">

	<title>Capturar una seccion de  mi web</title>
</head>
<body style="background-color: gray">
	<div class="container">
		<br>
		<br>
		<div class="row" style="background-color: white">
			<div class="col-sm-6" style="background-color: #CEF6EC">
				<div id="graficoBarras">Como!!!</div>
			</div>
			<div class="col-sm-6">
				<div id="graficoPastel">Hola como estas</div>
			</div>
		</div>
		<div class="row" style="background-color: #FBFBEF">
			<div class="col-sm-4">
				
				<button class="btn btn-success" id="btnimgGraficaBarras">
					Guardar img grafica barras
				</button>
				<button class="btn btn-primary" id="btnImgGraficaPastel">
					Guardar img grafica pastel
				</button>
			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="librerias/jquery-3.4.1.min.js"></script>
	<script src="librerias/bootstrap4/popper.min.js"></script>
	<script src="librerias/bootstrap4/bootstrap.min.js"></script>
	<script src="librerias/plotly-latest.min.js" charset="utf-8"></script>
	<script src="librerias/htmlToCanvas.js"></script>
	<script src="js/funciones.js"></script>


	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnimgGraficaBarras').click(function(){
				tomarImagenPorSeccion('graficoBarras','graficoBarras');
			});

			$('#btnImgGraficaPastel').click(function(){
				tomarImagenPorSeccion('graficoPastel','graficoPastel');
			});
		});
	</script>
</body>
</html>