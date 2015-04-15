<script>
	function actualiza(){
	
        var familia_id = $("#combo_familia").val();
        var registros  = $("#registros").val();		
        var ancho      = $("#ancho").val();
        var alto       = $("#alto").val();
        $.ajax({
            type:"GET", //tipo de formato de envio de información
            url: "<?php echo URL;?>/api/proximos_mini.php?familia_id="+familia_id+"&cantreg="+registros+"&ancho="+ancho+"&alto="+alto,
            success:function(respuesta){
                $("#muestra").html(respuesta);

				var script = "<iframe src='<?php echo URL;?>/api/proximos_mini.php?familia_id="+familia_id+"&cantreg="+registros+"&ancho="+ancho+"&alto="+alto+"' ";
				script = script + "style='width:"+ancho+"px;height:"+alto+"px;overflow:hidden;' scrolling='no'></iframe>";
				$('#getcode').val(script);	
            }
        });
	
	}
</script>

<?php
$familia_id = '0-0';
$ancho      = 240;
$alto       = 350;
$script = "<iframe src='".URL."/api/proximos_mini.php?familia_id=$familia_id&cantreg=$registros&ancho=$ancho&alto=$alto'";
$script.= " style='width:$ancho"."px;height:$alto"."px;overflow:hidden;' scrolling='no'></iframe>";
?>

<div class='grid_12'>
<h1>Widgets de CongresosyJornadas.net</h1>
<p>Cree los Widgets que le interesen seleccionando la categoría, realizando la configuración de estilos (opcional) 
y añadiendo el código a su web o blog, el contenido será actualizado automáticamente.</p>
</div>

<div class='grid_7' id='muestra'>
	<?php echo $script;?>
</div>
<div class='grid_5'>
	<p>Opciones de presonalización</p>

<?php 
    // -ARMA LOS SELECT DE LAS FAMILIAS
    $Familias = crearArbol(0);

    $parent_id = 0;
    $select_familia = '<select name="combo_familia" id="combo_familia" onchange="actualiza();">';
    $select_familia.= "<option value='0-0' >Todas las Categorías</option>";
    $familia_id = $subfamilia_id = 0;
    foreach($Familias as $dd){

            if( $dd['parent_id']==0 )
            { 
                $familia_id    = $dd['id']; 
                $subfamilia_id = 0; 
            } else { 
                $familia_id    = $dd['parent_id']; 
                $subfamilia_id = $dd['id'];
            }
            $identificador = $familia_id.'-'.$subfamilia_id;
            
            if ($data['familia_id'] == $familia_id and  $data['subfamilia_id'] == $subfamilia_id ) { $sel = "selected='selected'"; } else {$sel='';}

            $separador = "";
            if ($dd['nivel'] == 2 ) {
                $separador = "------";
            } elseif ($dd['nivel'] == 3 ) {
                $separador = "------------";
            } elseif ($dd['nivel'] == 4 ) {
                $separador = "------------------";
            }
            $select_familia.= "<option value='$identificador' $sel >$separador {$dd['nombre1']}</option>";
    }
    $select_familia.= "</select>";
?>
	
	<table>
		<tr>
			<td>Categoría para mostrar:</td>
			<td><?php	echo $select_familia;?></td>
		</tr>
		<tr>
			<td>Cantidad de Registros:</td>
			<td>
				<input type='text' name='registros' id='registros' value='0' style='width:60px;' onchange="actualiza();">
				<small>0 (cero) para todos</small>
			</td>
		</tr>
		<tr>
			<td>Ancho del Widget:</td>
			<td>
				<input type='text' name='ancho' id='ancho' value='220' style='width:60px;' onchange="actualiza();">
				<small>px Minimo:15px Maximo:500px </small>
			</td>
		</tr>
		<tr>
			<td>Alto del Widget:</td>
			<td>
				<input type='text' name='alto' id='alto' value='350' style='width:60px;' onchange="actualiza();">
				<small>px Minimo:200px</small>
			</td>
		</tr>
		<tr>
			<td colspan='2'>Copie este código y péguelo en su web o blog :<br>
				<textarea style='width:340px;height:150px;font-size:11px;' id='getcode' onclick="select();"><?php echo $script;?></textarea>
			</td>
		</tr>
		
	</table>

	
</div>
</div class='clear'></di>

