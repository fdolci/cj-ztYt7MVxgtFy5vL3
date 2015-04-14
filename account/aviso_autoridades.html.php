<?php
    include ('../inc/config.php'); 
	
    $producto_id = request('producto_id',0);
    $accion      = request('accion','');
    $id          = request('id',0);


	if(isset($_GET['listItem'])){ 
		$accion = 'ordenar';
	}

	
	$paises_autoridades = PaisesAutoridades();
	
    if( !esta_login() ) { 
        $Mensaje["mensaje"]   = $Traducciones['login_requerido'];
        $Mensaje["tipo"]      = 'error';
        $Mensaje["autoclose"] = false;
        $_SESSION['Mensaje']  = $Mensaje;
        $_SESSION['user_id']  = '';
        redirect(URL);   die();  
    }

    $rs      = $db->SelectLimit( "select user_id from productos where id='$producto_id'" ,1);
    $x       = $rs->FetchRow();
    $user_id = $x['user_id'];

	$tab_activa = 'lista';
	switch ($accion) {
	    case 'guardar':
		    if($_POST){
		    	$data = $_POST;

				if ($_FILES['archivo']['size'] != 0){
					$z             = explode('.',$_FILES['archivo']['name']);
					$extension     = strtolower( end($z) );
					$NombreArchivo = $user_id.'-'.$producto_id.'-'.time().'.'.$extension;

					if (! move_uploaded_file ($_FILES['archivo']['tmp_name'], SUBIR_ARCHIVOS."/".$NombreArchivo)) {
						echo "<hr>ERROR al subir el archivo<HR>";
					} else {
						$data['archivo'] = $NombreArchivo;
					}

				} else {
					if($data['eliminar_foto']=='on'){
						$data['archivo'] = '';
					}
				}

				$data['user_id'] = $user_id;
				
				$sql = "select max(orden) as ultimo from productos_autoridades where producto_id='{$data['producto_id']}'";
				$rs  = $db->SelectLimit($sql,1);
				$xx  = $rs->FetchRow();
				$ultimo = $xx['ultimo'];
				$data['orden'] = $ultimo+1;
				
				unset($data['eliminar_foto']);
				unset($data['subir_foto']);
				unset($data['accion']);
				unset($data['cargo']);
//				$db->debug = true;
		        $ok = $db->Replace('productos_autoridades', $data,'id', $autoquote = true); 
//				die();
		        unset($data);

		    }
		    $id = 0;
	        break;

		case 'guardar_titulo':
		    if($_POST){
		    	$data = $_POST;
				$data['user_id'] = $user_id;

				unset($data['submit']);
				unset($data['accion']);

				$sql = "select max(orden) as ultimo from productos_autoridades where producto_id='{$data['producto_id']}'";
				$rs  = $db->SelectLimit($sql,1);
				$xx  = $rs->FetchRow();
				$ultimo = $xx['ultimo'];
				$data['orden'] = $ultimo+1;
				
				$db->debug = false;
		        $ok = $db->Replace('productos_autoridades', $data,'id', $autoquote = true); 

		        unset($data);

		    }
		    $id = 0;
	        break;

	    case 'estado':
	    	$rs = $db->SelectLimit("select activo from productos_autoridades where id='$id'",1);
	    	$x  = $rs->FetchRow();
	    	$estado = iif($x['activo']==1,0,1);

	    	$ok = $db->Execute("update productos_autoridades set activo='$estado' where id='$id'");
			$id = 0;	        
	        break;

	    case 'editar':
	    	$rs = $db->SelectLimit("select * from productos_autoridades where id='$id'",1);
	    	$data  = $rs->FetchRow();
			
			if(!empty($data['estilo'])){
				$tab_activa = 'carga_titulos';
			} else {
				$tab_activa = 'carga_autoridades';
			}
			
	        break;

	    case 'eliminar':
	    	$rs = $db->SelectLimit("select archivo from productos_autoridades where id='$id'",1);
	    	$x  = $rs->FetchRow();
	    	$archivo = $x['archivo'];

	    	$ok = $db->Execute("delete from productos_autoridades where id='$id'");

	    	if (file_exists ( SUBIR_ARCHIVOS.'/'.$archivo) ) {
	    		unlink(SUBIR_ARCHIVOS.'/'.$archivo);
	    	}

			$id = 0;	        
	        break;

	    case 'ordenar':

	    	foreach($_GET['listItem'] as $clave=>$valor){
				$ok = $db->Execute("update productos_autoridades set orden='$clave' where id='$valor'");	    		
	    	}
	    	die();
			$id = 0;	        
	        break;

	}

	$sql = "select * from productos_autoridades where producto_id='$producto_id' and user_id='$user_id' order by orden ASC";
	$rs  = $db->Execute($sql);
    $ax = $rs->GetRows();

?>

<script type="text/javascript" src="<?php echo URL;?>/js/jquery-1.9.1.min.js"></script>
<link href="<?php echo URL;?>/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"  >
<script src="<?php echo URL;?>/js/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo URL;?>/css/muestra_producto.css" type="text/css" media="screen" />


<ul class="nav nav-tabs" id="myTab">
  <li><a href="#lista" data-toggle="tab">Listado de Autoridades</a></li>
  <li><a href="#carga_titulos" data-toggle="tab">Definición de Cargos</a></li>
  <li><a href="#carga_autoridades" data-toggle="tab">Carga de Autoridades</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane <?php if($tab_activa=='lista'){ echo 'active';}?>" id="lista">
	<?php include('aviso_autoridades_lista.html.php');?>
  </div>
  <div class="tab-pane <?php if($tab_activa=='carga_titulos'){ echo 'active';}?>" id="carga_titulos">
	<?php include('aviso_autoridades_carga_titulos.html.php');?>
  </div>
  <div class="tab-pane <?php if($tab_activa=='carga_autoridades'){ echo 'active';}?>" id="carga_autoridades">
	<?php include('aviso_autoridades_carga_personas.html.php');?>
  </div>

</div>
