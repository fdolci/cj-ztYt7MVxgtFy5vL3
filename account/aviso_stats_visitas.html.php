<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<div class='grid_8'>
		<h3 style='text-align:left;margin-bottom:20px;'>Visualizaciones totales de anuncio: <?php echo $total_visitas;?></h3>		
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['Semana', 'Visitas'],
		          <?php foreach($Visitas as $v){ ?>
		          		['<?php echo $v["semana"];?>',  <?php echo $v["cuantos"];?>],
		        	<?php } ?>
		        ]);


			 new google.visualization.LineChart(document.getElementById('chart_div')).
		      draw(data, {curveType: "function",
		      				title: 'Visitas por Semana',
		                  width: 900, height: 500}
		          );

		      }
		</script>
		<div id="chart_div" style="width: 900px; height: 500px;"></div>
	</div>






	<div class='grid_8'>
		<h3 style='text-align:left;margin-bottom:20px;'>Visualizaciones totales de su Micrositio: <?php echo $total_clicks;?></h3>		
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['Semana', 'Visitas'],
		          <?php foreach($Click as $v){ ?>
		          		['<?php echo $v["semana"];?>',  <?php echo $v["cuantos"];?>],
		        	<?php } ?>
		        ]);


			 new google.visualization.LineChart(document.getElementById('chart_click')).
		      draw(data, {curveType: "function",
		      				title: 'Visitas por Semana',
		                  width: 900, height: 500}
		          );

		      }
		</script>
		<div id="chart_click" style="width: 900px; height: 500px;"></div>
	</div>


	<div class='grid_8'>
		<h3 style='text-align:left;margin-bottom:20px;'>Usuarios enviados a su Web: <?php echo $total_enlaces;?></h3>				
		<?php if(!empty($Enlaces)) {?>		
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['Semana', 'Enlaces'],
		          <?php foreach($Enlaces as $v){ ?>
		          		['<?php echo $v["semana"];?>',  <?php echo $v["cuantos"];?>],
		        	<?php } ?>
		        ]);


			 new google.visualization.LineChart(document.getElementById('chart_enlaces')).
		      draw(data, {curveType: "function",
		      				title: 'Enlaces enviados por Semana',
		                  width: 900, height: 500}
		          );

		      }
			</script>
			<div id="chart_enlaces" style="width: 900px; height: 500px;"></div>
		<?php } ?>		
	</div>


	<div class='grid_8'>
		<h3 style='text-align:left;margin-bottom:20px;'>Consultas generadas desde <?php echo $DatosEmpresa['nombre_empresa'];?>: <?php echo $total_formularios;?></h3>				
		<?php if(!empty($Formularios)) {?>
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['Semana', 'Enlaces'],
		          <?php foreach($Formularios as $v){ ?>
		          		['<?php echo $v["semana"];?>',  <?php echo $v["cuantos"];?>],
		        	<?php } ?>
		        ]);


			 new google.visualization.LineChart(document.getElementById('chart_form')).
		      draw(data, {curveType: "function",
		      				title: 'Enlaces enviados por Semana',
		                  width: 900, height: 500}
		          );

		      }
			</script>
			<div id="chart_form" style="width: 900px; height: 500px;"></div>
		<?php } ?>
	</div>



<?php //pr($Visitas);?>