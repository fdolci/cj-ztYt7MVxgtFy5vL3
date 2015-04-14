<style type="text/css">
ul{
   margin:0px;
   padding:0px;
   list-style:none;
}
ul li{
	padding:0 0 0 10px;
}

#fdnavi ul{
	list-style:none;
	margin:0px;
	padding:0px;
}

#fdnavi li{
    width:178px;
    height:30px;
    line-height:30px;
	background:none;
	margin:2px;
	padding:2px 2px 2px 6px;
	border:1px solid#CCCCCC; 
    background-color:#FFF;
}

#fdnavi li a {
	display:block;
	text-decoration:none;
	text-align:left;
	font-size:12px;
	color:#000;
    line-height:30px;
}

#fdnavi li:hover {
	background-color:#c0c0c0;
}

.td_titulo {
	display:block;
	text-decoration:none;
	text-align:left;
	font-size:12px;
	color:#FFF;
	background-color:#000;
    line-height:30px;
	margin:2px;
    margin-bottom:0px;
	padding:2px 2px 2px 6px;
	border:1px solid#CCCCCC; 
    
}

#menu_conf_general {display:none;}
#menu_usuarios {display:none;}
#importar {display:none;}
#menu_contenido {display:none;}
#menu_modulos {display:none;}
#menu_productos {display:none;}
#menu_boletines {display:none;}
</style>

<script>
function mostrar(cual){
    if (document.getElementById(cual).style.display == 'block') {
        document.getElementById(cual).style.display = 'none';    
    } else {
        document.getElementById(cual).style.display = 'block';
    }
}

</script>
<table width="180">
    <tr><td class="td_titulo" onclick="mostrar('menu_conf_general');" style="cursor: pointer;">Configuración General</td></tr>
    <tr>
        <td>
            <div id="menu_conf_general" <?php if($item_menu[0]==1){echo 'style="display:block;"';}?> >
                <ul id="fdnavi" >
                	<li <?php if($item_menu[0]==1 and $item_menu[1]==1){echo 'style="background-color:#c0c0c0;"';}?> ><a href="administradores.php">Administradores</a></li>
                	<li <?php if($item_menu[0]==1 and $item_menu[1]==2){echo 'style="background-color:#c0c0c0;"';}?> ><a href="configurar.php?panel=1">Datos de la Empresa</a></li>
                	<li <?php if($item_menu[0]==1 and $item_menu[1]==4){echo 'style="background-color:#c0c0c0;"';}?> ><a href="meta_tags.php">Meta Tags</a></li>
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==5){echo 'style="background-color:#c0c0c0;"';}?> ><a href="configurar.php?panel=3">Google Apps</a></li>                                        
                <?php if($_SESSION['god'] == 1 ) { ?>                    
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==11){echo 'style="background-color:#c0c0c0;"';}?> ><a href="config_phpmailer.php">PHP Mailer</a></li>
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==3){echo 'style="background-color:#c0c0c0;"';}?> ><a href="redes_sociales.php">Redes Sociales</a></li>                
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==7){echo 'style="background-color:#c0c0c0;"';}?> ><a href="idiomas.php">Traducciones</a></li>
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==8){echo 'style="background-color:#c0c0c0;"';}?> ><a href="corregir_url.php">Corregir URL</a></li>
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==9){echo 'style="background-color:#c0c0c0;"';}?> ><a href="configurar.php?panel=6">Config.General</a></li>
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==10){echo 'style="background-color:#c0c0c0;"';}?> ><a href="redirigir.php">Redireccion URL</a></li>                    
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==12){echo 'style="background-color:#c0c0c0;"';}?> ><a href="habilitar_provincias.php">Habilitar Provincias</a></li>
                    <li <?php if($item_menu[0]==1 and $item_menu[1]==13){echo 'style="background-color:#c0c0c0;"';}?> ><a href="habilitar_ciudades.php">Habilitar Ciudades</a></li>                    
                <?php } ?>                                        


                </ul>
            </div>
        </td>
    </tr>
<?php if($_SESSION['god'] == 1 or $Config['admin_usuarios'] == 'S') { ?>
    <tr><td class="td_titulo" onclick="mostrar('menu_usuarios');" style="cursor: pointer;">Administrar Usuarios</td></tr>
    <tr>
        <td>
            <div id="menu_usuarios" <?php if($item_menu[0]==4){echo 'style="display:block;"';}?> >
                <ul id="fdnavi" >
                    <li <?php if($item_menu[0]==4 and $item_menu[1]==1){echo 'style="background-color:#c0c0c0;"';}?> ><a href="grupos.php">Grupos de Usuarios</a></li>
                    <li <?php if($item_menu[0]==4 and $item_menu[1]==2){echo 'style="background-color:#c0c0c0;"';}?> ><a href="usuarios.php?mostrar=1">Usuarios</a></li>
                </ul>
            </div>
        </td>
    </tr>
<?php } ?>


    <tr><td class="td_titulo" onclick="mostrar('menu_contenido');" style="cursor: pointer;">Contenido de la Web</td></tr>
    <tr>
        <td>
            <div id="menu_contenido" <?php if($item_menu[0]==2){echo 'style="display:block;"';}?>>
                <ul id="fdnavi">
                    <li <?php if($item_menu[0]==2 and $item_menu[1]==2){echo 'style="background-color:#c0c0c0;"';}?> ><a href="categorias.php">Secciones</a></li>
<?php
					//--Arma el select de las categorias
					$cond 	= "select * from categorias where activo=1 order by titulo1 ASC";
					$rs 	= $db->Execute($cond);
					$Cate	= $rs->GetRows();
					foreach($Cate as $c){ ?>
						<?php if($c['id']>=10 and $c['id']!=$Config['blog']) { ?>
						<li <?php if($item_menu[0]==2 and $item_menu[1]==3){echo 'style="background-color:#c0c0c0;"';}?> >
							<a href="contenidos.php?categoria_id=<?php echo $c['id'];?>" title="<?php echo $c['titulo1'];?>"><?php echo substr($c['titulo1'],0,30);?></a>
						</li>
						<?php } ?>
					<?php } ?>

                    <?php if($Config['blog'] > 0) { ?>
                        <li <?php if($item_menu[0]==2 and $item_menu[1]==3){ echo 'style="background-color:#c0c0c0;"';}?> >
                            <a href="contenidos.php?categoria_id=<?php echo $Config['blog'] ;?>" title="Blog">Blog </a></li>
                    <?php } ?>        
                    <li <?php if($item_menu[0]==2 and $item_menu[1]==3){ echo 'style="background-color:#c0c0c0;"';}?> >
                        <a href="destacados.php" title="Listar las publicaciones Destacadas">--> Mostrar Destacados</a></li>

					<?php foreach($Cate as $c){ ?>
						<?php if($c['id']<10 and $c['id']!=$Config['blog']) { ?>
						<li <?php if($item_menu[0]==2 and $item_menu[1]==3){echo 'style="background-color:#c0c0c0;"';}?> >
							<a href="contenidos.php?categoria_id=<?php echo $c['id'];?>" title="<?php echo $c['titulo1'];?>">--> <?php echo substr($c['titulo1'],0,30);?></a>
						</li>
						<?php } ?>
					<?php } ?>

                    <li <?php if($item_menu[0]==2 and $item_menu[1]==4){echo 'style="background-color:#c0c0c0;"';}?> ><a href="comentarios.php">Comentarios</a></li>
					
                </ul>
            </div>
        </td>
    </tr>


<?php if($_SESSION['god'] == 1 or $Config['categoria_boletin'] > 0) { ?>
    <tr><td class="td_titulo" onclick="mostrar('menu_boletines');" style="cursor: pointer;">Boletines</td></tr>
    <tr>
        <td>
            <div id="menu_boletines" <?php if($item_menu[0]==6){echo 'style="display:block;"';}?>>
                <ul id="fdnavi">
                    
                    <li <?php if($item_menu[0]==6 and $item_menu[1]==1){echo 'style="background-color:#c0c0c0;"';}?> ><a href="suscriptores.php">Suscriptores</a></li>
                    <li <?php if($item_menu[0]==6 and $item_menu[1]==2){echo 'style="background-color:#c0c0c0;"';}?> ><a href="contenidos.php?categoria_id=<?php echo $Config['categoria_boletin'];?>">Boletines</a></li>

                </ul>
            </div>
        </td>
    </tr>
<?php } ?>                           

<?php if($_SESSION['god'] == 1 or $Config['admin_productos'] == 'S') { ?>
    <tr><td class="td_titulo" onclick="mostrar('menu_productos');" style="cursor: pointer;">Anuncios</td></tr>
    <tr>
        <td>
            <div id="menu_productos" <?php if($item_menu[0]==5){echo 'style="display:block;"';}?> >
                <ul id="fdnavi" >
<?php /*
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==3){echo 'style="background-color:#c0c0c0;"';}?> ><a href="servicios.php">Servicios</a></li>
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==4){echo 'style="background-color:#c0c0c0;"';}?> ><a href="actividades.php">Actividades</a></li>
*/?>                    
                    
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==1){echo 'style="background-color:#c0c0c0;"';}?> ><a href="familias.php">Familias</a></li>
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==2){echo 'style="background-color:#c0c0c0;"';}?> ><a href="productos.php">Anuncios</a></li>
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==6){echo 'style="background-color:#c0c0c0;"';}?> ><a href="productos_ultimos_ingresos.php">Ultimos Ingresos</a></li>                    
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==7){echo 'style="background-color:#c0c0c0;"';}?> ><a href="mensajeria.php">Mensajeria</a></li>                    
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==5){echo 'style="background-color:#c0c0c0;"';}?> ><a href="publicidades.php">Publicidades</a></li>                    
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==8){echo 'style="background-color:#c0c0c0;"';}?> ><a href="productos_top_10.php">Top 10</a></li>                                        
                    <li <?php if($item_menu[0]==5 and $item_menu[1]==9){echo 'style="background-color:#c0c0c0;"';}?> ><a href="planes_de_anuncios.php">Planes de Anuncios</a></li>
                </ul>
            </div>
        </td>
    </tr>
<?php } ?>

    <tr><td class="td_titulo" onclick="mostrar('menu_modulos');" style="cursor: pointer;">Módulos</td></tr>
    <tr>
        <td>
            <div id="menu_modulos" <?php if($item_menu[0]==3){echo 'style="display:block;"';}?>>
                <ul id="fdnavi">
                    <li <?php if($item_menu[0]==3 and $item_menu[1]==1){echo 'style="background-color:#c0c0c0;"';}?> ><a href="banner.php">Banners (Slide)</a></li>
					<li <?php if($item_menu[0]==3 and $item_menu[1]==3){echo 'style="background-color:#c0c0c0;"';}?> ><a href="menues_bloques.php">Botonera de Menúes</a></li>
<?php if($_SESSION['god'] == 1 ) { ?>    
                    <li <?php if($item_menu[0]==3 and $item_menu[1]==2){echo 'style="background-color:#c0c0c0;"';}?> >
                        <a href="modulos_contenido.php">Contenido Modulos</a>
                        <?php if($item_menu[0]==3 and $item_menu[1]==2){ include('_diagrama_modulos.html'); }?>
                    </li>
<?php } ?>                    
                </ul>
            </div>
        </td>
    </tr>


</table>
