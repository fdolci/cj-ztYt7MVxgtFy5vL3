<?php
    if( $xurl['provincia']['id']==0 ){
      	$condicion_provincia = '';

    } else {
      	$condicion_provincia = " and p.provincia_id='{$xurl['provincia']['id']}'";
    }    

    if( $xurl['familia']['id']==0 ) {
		$condicion_familia = '';
    } else {
		$condicion_familia = " and pf.familia_id='{$xurl['familia']['id']}'";
    }
        
    // Top 20 de anuncios home
    $sql = "select p.id, p.titulo, p.urlamigable,pf.familia_id,pf.subfamilia_id, 
        				f.urlamigable1 as url_familia, sf.urlamigable1 as url_subfamilia
        		from productos as p
	        		left join productos_familias as pf on p.id=pf.producto_id
	        		left join familias as f on pf.familia_id = f.id
	        		left join familias as sf on pf.subfamilia_id = sf.id
        		where p.activo = '1' $condicion_provincia  $condicion_familia 
        		order by click DESC";
    $rs  = $db->SelectLimit($sql,10);
    $MasVisitados = $rs->GetRows();
?>

	<h1>Empresas m&aacute;s visitadas</h1>
	<ul>
	<?php 
		$contador=1;
		foreach($MasVisitados as $mv){
			echo "<li><div class='contador'>$contador</div><a href='".URL."/{$mv['url_familia']}/{$mv['url_subfamilia']}/{$mv['urlamigable']}_{$mv['id']}.html' title='{$mv['titulo']}'>{$mv['titulo']}</a></li>";
			$contador++;
		} 
	?>
	</ul>
