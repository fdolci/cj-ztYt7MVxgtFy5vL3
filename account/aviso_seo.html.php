<h3>SEO, Optimización para los buscadores (Google, Yahoo, Bing, etc.)</h3>


<div class='grid_2 ctitulo' >Meta-Titulo:</div>
<div class='grid_8'>
    <input type='text'  name='metatitle' id="metatitle" value="<?php echo $data['metatitle'];?>" size='90' maxlength='70' />
</div>
<div class='clear'></div>
<div class='grid_2 ctitulo' >Meta-Keywords:</div>
<div class='grid_8'>
    <input type='text' name='keywords' id='keywords' value='<?php echo $data['keywords'];?>' size='90' maxlength='255'  />
</div>
<div class='clear'></div>
<div class='grid_2 ctitulo' >Meta-Descripcion:<br><small>Max.155caract</small></div>
<div class='grid_8'>
    <textarea name='metadescripcion' id='metadescripcion' style='width:575px; height:40px;' ><?php echo $data['metadescripcion'];?></textarea>
    <br><small>Disponible: <span id='disponible_metadescripcion'></span> de 155.</small>
</div>
<div class='clear'></div>

