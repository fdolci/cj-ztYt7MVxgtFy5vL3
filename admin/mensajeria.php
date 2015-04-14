<?php
    $item_menu[0] = 5; 
    $item_menu[1] = 7;  
    $title = $titulo = 'Mensajeria';
	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) {
		echo '<center><div style="width:800px;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
		echo $_SESSION['Msg']."</div></center>";
		$_SESSION['Msg']='';
	}
    
    $producto_id = request('producto_id',0);
	$accion    = request('accion','listar');
	$fecha_consulta	   = request('fecha_consulta',date('Y-m'));
	$id        = request('id',0);

	if ($accion=='eliminar' and $id>0) {
		$sql = "delete from base_mailing where id='$id'";
		$rs = $db->Execute($sql);

	}

?>
<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
<table width='100%'>
<tr>
	<td><h2>Mensajes enviados a los Alojamientos</h2></td>
	<td align='right'>
	</td>
</tr>
</table>

<?php

    $ano_desde = '2012';
    $mes_desde = '12';
    $dia_desde = '10';
    $fecha = mktime(0,0,0,$mes_desde,$mes_dia,$ano_desde);
    $hasta = time();

    $select_fecha = "<select name='fecha_consulta'>";
    $valor = date('Y-m',$fecha);
    $select_fecha.= "<option value='$valor'>$valor</option>";
    while ($fecha<$hasta) {
    	$fecha = $fecha + 2678400;//mktime(0,0,0,$mes_desde+1,$mes_dia,$ano_desde);
	    $valor = date('Y-m',$fecha);
	    if ($valor == $fecha_consulta) {$sel = 'selected=selected';} else { $sel='';}
	    $select_fecha.= "<option value='$valor' $sel>$valor</option>";
    }
	$select_fecha.= "</select>";

	$sql = "select titulo,id from productos order by titulo ASC";
	$rs  = $db->Execute($sql);
	$Productos = $rs->GetRows();

    $select_prod = "<select name='producto_id'>";
    $select_prod.= "<option value='0'>Sin especificar</option>";
    foreach($Productos as $p){
	    if ($p['id'] == $producto_id) {$sel = 'selected=selected';} else { $sel='';}
	    $select_prod.= "<option value='{$p['id']}' $sel>{$p['titulo']}</option>";
    }
	$select_prod.= "</select>";

	if($producto_id>0){
		$option = " and producto_id='$producto_id' ";
	} else {
		$option = '';
	}

	$sql = "select base_mailing.*, productos.titulo, publicaciones.titulo1 
			from base_mailing 
			left join productos on base_mailing.producto_id = productos.id
			left join publicaciones on base_mailing.publicacion_id = publicaciones.id
			where LEFT(base_mailing.fecha,7)='$fecha_consulta' $option order by base_mailing.fecha DESC";

	$rs  = $db->Execute($sql);
	$data = $rs->GetRows();

?>	
	<form action='mensajeria.php' method='post'>
		Fecha a Consultar: <?php echo $select_fecha;?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Filtrar por Alojamiento:  <?php echo $select_prod;?>
		&nbsp;&nbsp;&nbsp;
		<input type='submit' vale='Consultar'>
	</form>

	<table width='1000' border='0' cellpadding='8' cellspacing='0'>
		<tr>

			<th width='70'  class='th'>Fecha</th>
			<th width='20'  class='th'>Asunto</th>
    		<th width='20'  class='th'>Email</th>
    		<th width='20'  class='th'>Alojamiento</th>
		</tr>
<?php 
	foreach($data as $c) { 
		if ($c['lista']==1) {$color="#FEFFCC"; } else {$color="#FFFFFF";}
		$asunto = str_replace('[Rosario Alojamientos]', '', $c['subject']); 
		$asunto = str_replace('[RosarioAlojamientos.com]', '', $asunto);
?>
		
		<tr bgcolor="<?php echo $color;?>">
			<td nowrap>
				<a href='mensajeria.php?accion=eliminar&id=<?php echo $c['id'];?>&fecha_consulta=<?php echo $fecha_consulta;?>&producto_id=<?php echo $producto_id;?>' title='Eliminar este Registro'
					onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
					<img src='img/del.gif' border='0' ></a>

				<?php echo $c['fecha'];?>&nbsp;
			</td>
<?php /*			
			<td align='center' nowrap='nowrap'>
			</td>
*/?>			
			<td nowrap><span title='<?php echo $c['comentario'];?>'><?php echo $asunto;?></span>&nbsp;</td>
			<td ><?php echo $c['email'];?>&nbsp;</td>
			<td >
				<?php if ($c['producto_id']>0){
						echo $c['titulo'];
					  } elseif ($c['publicacion_id']>0){
					  	echo $c['titulo1'];
					  }
				?>
			</td>
		</tr>

<?php } ?>
	</table>



</body></html>