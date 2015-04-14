<?php
    $item_menu[0] = 2; 
    $item_menu[1] = 4;  
    $title = $titulo = 'Comentarios';
	include('header.php');

	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) {
		echo '<center><div style="width:800px;height:30px;background-color:lightblue;border:2px solid blue;font-size:16px;font-weight;bold;text-align:center;margin-top:5px;padding-top:5px;color:blue;">';
		echo $_SESSION['Msg']."</div></center>";
		$_SESSION['Msg']='';
	}
    
	$accion    = request('accion','listar');
	$fecha_consulta	   = request('fecha_consulta',date('Y-m'));
	$id        = request('id',0);

	if ($accion=='eliminar' and $id>0) {
		$sql = "delete from comentarios where id='$id'";
		$rs = $db->Execute($sql);

	} elseif($accion=='estado'){
			$rs = $db->SelectLimit("select * from comentarios where id='$id'", 1);
			$x	= $rs->FetchRow();

			if ($x['publicado']==1) {$x['publicado']=0;} else {$x['publicado']=1;}

			$ok		= $db->Execute("update comentarios set publicado={$x['publicado']} where id='$id'");
			$accion = 'listar';

	}

	$fecha_desde = mk

?>
<link href="<?php echo ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
<table width='100%'>
<tr>
	<td><h2>Comentarios en las publicaciones</h2></td>
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

	$sql = "select comentarios.*, publicaciones.titulo1, usuarios.username, usuarios.email
			from comentarios
			left join publicaciones on comentarios.publicacion_id = publicaciones.id
			left join usuarios on comentarios.user_id = usuarios.id			
			order by comentarios.fecha DESC";

	$rs  = $db->Execute($sql);
	$data = $rs->GetRows();

?>	
	<form action='comentarios.php' method='post'>
		Fecha a Consultar: <?php echo $select_fecha;?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='submit' vale='Consultar'>
	</form>

	<table width='1000' border='0' cellpadding='8' cellspacing='0'>
		<tr>

			<th width='70'  class='th'>Fecha</th>
    		<th width='20'  class='th'>Email</th>
			<th width='20'  class='th'>Comentario</th>    		
    		<th width='20'  class='th'>Publicacion</th>
		</tr>
<?php 
	foreach($data as $c) { 
		if ($c['lista']==1) {$color="#FEFFCC"; } else {$color="#FFFFFF";}
?>
		
		<tr bgcolor="<?php echo $color;?>">
			<td nowrap>
				<a href='comentarios.php?accion=eliminar&id=<?php echo $c['id'];?>&fecha_consulta=<?php echo $fecha_consulta;?>' title='Eliminar este Registro'
					onclick="return confirm('Est&aacute; seguro de eliminar este Registro?');">
					<img src='img/del.gif' border='0' ></a>
				<?php echo $c['fecha'];?>&nbsp;
				<?php if ($c['publicado']==1) { $imagen="img/activo.gif"; } else {$imagen='img/inactivo.gif';} ?>
				<a href='comentarios.php?accion=estado&id=<?php echo $c['id'];?>&fecha_consulta=<?php echo $fecha_consulta;?>'
				title='Activar/Desactivar esta publicaci&oacute;n'> <img src='<?php echo ADMIN.$imagen;?>' border='0'/></a>


			</td>
<?php /*			
			<td align='center' nowrap='nowrap'>
			</td>
*/?>			
			<td ><?php echo $c['email'];?>&nbsp;</td>
			<td ><?php echo $c['comentario'];?></td>
			<td ><?php echo $c['titulo1']; ?>	</td>
		</tr>

<?php } ?>
	</table>



</body></html>