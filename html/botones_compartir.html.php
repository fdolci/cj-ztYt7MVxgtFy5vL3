    <script language="javascript">
      function abrir(direccion, xancho, xalto){

         var xancho = xancho;
         var xalto = xalto;

           var opciones = "fullscreen=" + 0 +
                       ",toolbar=" + 0 +
                       ",location=" + 0 +
                       ",status=" + 0 +
                       ",menubar=" + 0 +
                       ",scrollbars=" + 1 +
                       ",resizable=" + 0 +
                       ",width=" + xancho +
                       ",height=" + xalto +
                       ",left=" + (screen.availWidth-xancho)/2 +
                       ",top=" + (screen.availHeight-xalto)/2;
           var ventana = window.open(direccion,"sharer",opciones);
      }
    </script>

    <div class="share">
      <h3 style='margin-top:30px;'>Compartir</h3>
      <?php if (!empty($RedesSociales['twitter']['username'])) {
        $tw_username = '@'.$RedesSociales['twitter']['username'];
      } else {
        $tw_username = '';
      } ?>
      <div class="twitter">
        <a href="#" title='Compartir en Twitter'
        onclick="javascript:abrir('https://twitter.com/intent/tweet?text=&quot;<?php echo $MetaTags['title'];?>&quot; en <?php echo $tw_username;?> <?php echo $url_actual;?>',720,525);">Twitter</a>
      </div>
      <div class="facebook">
        <a href="#" title='Compartir en Facebook'
        onclick="javascript:abrir('https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_actual;?>',720,450);">Facebook</a>
      </div>
      <div class="google">
        <a href="#"  title='Compartir en Google+'
        onclick="javascript:abrir('https://plus.google.com/share?url=<?php echo $url_actual;?>',720,550);">Google +</a>
      </div>
      <div class="pinterest">
        <a href="#" title='Compartir en Pinterest'
        onclick="javascript:abrir('https://pinterest.com/pin/create/button/?url=<?php echo $url_actual;?>&amp;media=<?php echo $mImagen;?>?<?php echo time();?>&amp;description=<?php echo $MetaTags['description'];?>',720,600);"
        >Pinterest</a>
      </div>
      <div class="linkedin">
        <a href="#" title='Compartir en LinkedIn'
        onclick="javascript:abrir('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url_actual;?>&title=<?php echo $MetaTags['title'];?>&summary=<?php echo $MetaTags['description'];?>&source=<?php echo $url_actual;?>',800,500);"
        >Linked In</a>
      </div>
    </div>  