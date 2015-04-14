<?php

    $item_menu[0] = 3;
    $item_menu[1] = 2 ;
    $title = 'M&oacute;dulos';    
	include('header.php');
	if (!isset($_SESSION["admin"])) {redirect("login.php");	exit(); }

	if(!empty($_SESSION['Msg'])) {
	   echo mensaje_ok($_SESSION['Msg']);
		$_SESSION['Msg']='';
	}

    $accion = request('accion','');
    $id = request('id',0);
    		
	if ($accion=='estado')	{
	    $sql = "select * from modulos where id='$id'";
        $rs = $db->SelectLimit($sql,1);
        $x = $rs->FetchRow();
        if ($x['activo']==1){$estado=0;} else {$estado=1;}   
		$ok = $db->Execute("update modulos set activo='$estado' where id='$id'");
        
	} elseif ($accion=='orden')	{
	    $sube = request('sube','no');
        $cond 	= "select * from modulos where id='$id'";
    	$rs 	= $db->SelectLimit($cond, 1);
    	$x		= $rs->FetchRow();
    	$orden_actual = $x['orden'];
        $ubicacion = $x['ubicacion'];
    	if ($sube=='si') {$nuevo_orden = ($orden_actual - 1.5); } else { $nuevo_orden = ($orden_actual +1.5); }
        $cond 	= "update modulos set orden=$nuevo_orden where id='$id'";
		$ok		= $db->Execute($cond);

        $sql = "select * from modulos where ubicacion='$ubicacion' order by orden ASC";
        $rs 	= $db->Execute($sql);
		$x	= $rs->GetRows();
		$orden = 1;
		foreach ($x as $r){
		  $cond 	= "update modulos set orden=$orden where id='".$r['id']."'";
		  $ok		= $db->Execute($cond);
		  $orden++;
        }


	} elseif ($accion=='eliminar')	{ 
		$ok = $db->Execute("delete from modulos where id=$id");
	}
    
    if (!$ok) { $msg="msg_operacion_no"; } else { $msg="msg_operacion_ok";	}				
	


	//-----------------------------------------Listado de Publicaciones de la categoria seleccionada
	$cond 	= "select modulos.*, categorias.titulo1 from modulos left join categorias on modulos.categorias=categorias.id order by ubicacion ASC, orden ASC";
	$rs 	= $db->Execute($cond); 	
	$Publicidades = $rs->GetRows();


	$titulo='';
	foreach($Publicidades as $clave=>$valor){
		if ($valor['categorias']==0   ) { $Publicidades[$clave]['titulo1'] = 'Todas las Categorias'  ;}
        if ($valor['categorias']==(-1)) { $Publicidades[$clave]['titulo1'] = 'Formulario de Contacto';}
	}

    include('modulos_listar.html.php');
?>