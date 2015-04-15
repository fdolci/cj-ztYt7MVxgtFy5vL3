<?php
    // Crea el menu de Familias de Productos para la agencia
    $Familias = MenuFamilias( 0 );
    // $Familias = MenuFamilias( $familia_id );
?>


<div id='menu_familias' class='c1' style='background:#FFF;'>
    <a href='<?php echo URL;?>' ><h3 >Alojamientos</h3></a>

    <?php foreach($Familias as $clave=>$valor){ ?>
        <?php if (!empty($valor['child'])){ ?>
            <h1>
                <?php if (!empty($valor['thumbs1'])) { ?>
                    <img src='<?php echo $valor['thumbs1'];?>' alt='<?php echo $valor['nombre'];?>' style='height:16px; width:16px; margin-right:2px;' >
                <?php }?>
                <?php echo $valor['nombre'];?>
            </h1>
                <?php foreach($valor['child'] as $clave2=>$valor2){ ?>
                    <a href='<?php echo $valor2['href'];?>' style='z-index:0;' title='<?php echo $valor2['nombre'];?>'>
                        <h2>
                            <?php if (!empty($valor2['thumbs1'])) { ?>
                                <img src='<?php echo $valor2['thumbs1'];?>' alt='<?php echo $valor2['nombre'];?>' style='height:16px; width:16px; margin-right:2px;' >
                            <?php }?>
                            <?php echo $valor2['nombre'];?>
                        </h2>
                    </a>
                <?php } // end foreach $Familias ?>
        <?php } else {?>
            <a href='<?php echo $valor['href'];?>' style='z-index:0;' title='<?php echo $valor['nombre'];?>'>
                <h1>
                    <?php if (!empty($valor['thumbs1'])) { ?>
                        <img src='<?php echo $valor['thumbs1'];?>' alt='<?php echo $valor['nombre'];?>' style='height:16px; width:16px; margin-right:2px;' >
                    <?php }?>
                    <?php echo $valor['nombre'];?>
                </h1>
            </a>
        <?php } ?>

    <?php } // end foreach $Familias ?>
</div>
<div class="cl-sombra"></div>
<div class='clear'></div>


<?php include('inc_publicidades_izq.php'); ?>

<div class='clear'></div>