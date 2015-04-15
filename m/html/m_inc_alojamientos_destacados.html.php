<?php if(!empty($destacados)) { ?>

		<h3 class='h3_titulo_listado_destacado'>Alojamientos Destacados</h3>  
        <table width='100%'>
      
		<?php $i=1;?>
		<?php foreach ($destacados as $d){ ?>
            <tr>
                <td class='lista_alojamientos_imagen' >
                   <a href='ver.php?id=<?php echo $d['id'];?>' title='<?php echo $d['titulo'];?>'>
                        <?php if (!empty($d['thumbs'])){ ?>
                           <img src='<?php echo $d['thumbs'];?>'>
                        <?php }  ?>
                    </a>
                    <h2><a href='ver.php?id=<?php echo $d['id'];?>'><?php echo $d['titulo'];?></a></h2>
                    <p><?php echo strip_tags($d['resumen']);?></p>
                </td>
            </tr>
            <tr><td><hr></td></tr>

	    <?php } // endforeach  ?>
        </table>

<?php }  ?>
