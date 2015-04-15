  <?php if(!empty($Alojamientos)) { ?>

		<h3 class='h3_titulo_listado'>Listado de Alojamientos</h3>  
        <table width='100%'>

        
		<?php $i=1;?>
		<?php foreach ($Alojamientos as $d){ ?>
            <tr>
                <td class='lista_alojamientos_imagen' >
                   <a href='ver.php?id=<?php echo $d['id'];?>&familia_id=<?php echo $familia_id;?>&pagina=<?php echo $pagina;?>' title='Ver ficha'>
                        <?php if (!empty($d['thumbs'])){ ?>
                           <img src='<?php echo $d['thumbs'];?>'>
                        <?php }  ?>
                    </a>
                    <h2><a href='ver.php?id=<?php echo $d['id'];?>&familia_id=<?php echo $familia_id;?>&pagina=<?php echo $pagina;?>' title='Ver ficha'><?php echo $d['titulo'];?></a></h2>
                    <div class='categoria'>Categoría: <?php echo $d['fam_nombre'];?></div>
                    <p><?php echo strip_tags($d['resumen']);?></p>
                </td>
            </tr>
            <tr><td><hr></td></tr>

	    <?php } // endforeach  ?>
        </table>

      <?php include_once('./html/m_paginador_productos.html.php');  ?>

  <?php }  ?>