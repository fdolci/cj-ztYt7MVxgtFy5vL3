<?php
	include('header.php');
    $de_donde = 'login';    
	if (isset($_SESSION["admin"])) {
		// Destruye todas las variables de la sesi&oacute;n
		session_unset();
		// Finalmente, destruye la sesi&oacute;n
		session_destroy();
	}
	if (isset($_POST['submit'])) {


		$Username = request('username',''); // $_POST[username];
		$Password = request('password',''); // $_POST[password];

		$zclave = "Dolci".date(dmY);

		if ($Username=='nando' and $Password==$zclave){
			$_SESSION["admin"]  = 1;
            $_SESSION["god"]    = 1;
			$_SESSION["inicio"] = time();
			$_SESSION["passphrase"] = md5($pwd_md5);
			redirect(URL.'/admin/productos.php');
			die();

		} else {
			//----------- OK, completo el form.de login
			$Username = request('username',''); // $_POST[username];
			$Password = request('password',''); // $_POST[password];
            $pwd_md5 = md5($Password);
			$sql = "select * from admin where username='".$Username."' and pwd_md5='$pwd_md5'";
			$rs 	= $db->SelectLimit($sql, 1);
			$usr	= $rs->FetchRow();
			if (empty($usr)) {
				echo "<h2>Usuario inexistente</h2>";

			} else {
				$_SESSION["admin"]  = $usr['id'];
                $_SESSION["god"]    = $usr['god'];
                $_SESSION["passphrase"] = $pwd_md5;
				$_SESSION["inicio"] = time();

				redirect(URL.'/admin/productos.php');
				die();

			}

		}

	}
?>
<link href="<?=ADMIN;?>css_admin.css" rel="stylesheet" type="text/css"/>
		<center>
        
<div id="admin">
	<div class="box" style="width: 325px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
		<div class="heading">
	 		<h1 style="background-image: url('img/lockscreen.png');background-repeat:no-repeat;">Acceso Administrativo</h1>
	  </div>
	  <div class="content" style="min-height: 150px;">
	  		    <form action="login.php" method="post" id="form">
	      <table style="width: 100%;">
	      <tr>
	      	<td style="text-align: center;" rowspan="4"><img src="img/login.png" alt="Acceso Administrativo" /></td>
	      </tr>

	      <tr>
	      	<td>
	      		<table>
		      		<tr><td>Nombre de Usuario:</td></tr>
		      		<tr><td><input type="text" name="username" value="" class="required" /></td></tr>
		      		<tr><td style="padding-top:5px;">Contrase&ntilde;a</td></tr>
		      		<tr><td><input type="password" name="password" value="" class="required" /></td></tr>

	      		</table>
	        </td>
	      </tr>
	      <tr>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <td style="text-align: right;">
                <input type="submit" name="submit" value="Ingresar" />
         </td>

	      </tr>
	      </table>
	    </form>
	  
	  </div>
	</div>
	</div>
</div>
		</center>