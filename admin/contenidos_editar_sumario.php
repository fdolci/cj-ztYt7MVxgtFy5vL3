<span style="color:#000000; font-weight:bold; font-size:12px;">Sumario<br />
<small>Se mostrará cuando se está listando una categoría</small></span>

<textarea name='data[copete<?php echo $i;?>]' id='copete<?php echo $i;?>' style="width:800px; height:250px;"  class="ckeditor"><?php echo $Pub[copete.$i];?></textarea>
<script type="text/javascript">
    var editor = CKEDITOR.replace( 'copete<?php echo $i;?>',{ height: '250px'} );
    CKFinder.setupCKEditor( editor, '<?php echo URL;?>/js/ckfinder/' ) ;
</script>
