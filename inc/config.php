<?php
//include('detecta_navegador.php');
//$es_movil = mobile();

ob_start("ob_gzhandler");

if (!isset($_SESSION)) {
	if(@session_start() == false){session_destroy();session_start();}
}


date_default_timezone_set('America/Buenos_Aires');


define('SESION_TIME', 3600); 						//--------------Cantidad de Segundos que dura la session del usuario

/* 
error_reporting(0); // Desactivar toda notificación de error
error_reporting(E_ERROR | E_WARNING | E_PARSE); // Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); // Notificar E_NOTICE también puede ser bueno (para informar de variables no inicializadas o capturar errores en nombres de variables ...)
error_reporting(E_ALL ^ E_NOTICE); // Notificar todos los errores excepto E_NOTICE
error_reporting(E_ALL); // Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(-1); // Notificar todos los errores de PHP
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE ); // Desactivar toda notificación de error
//-------------------------------------------------------------------------------------Acceso a la BD
if (preg_match('/xampp/', $_SERVER['DOCUMENT_ROOT'])) {
	//-------------------------------------------------------------------------------------Configuracion Local
	define('HOST'		, 'http://www.irosario.x');
	define('INST_DIR'	, '/cj');
	$server 	= 'localhost';
	$user 		= 'nando';
	$password 	= '62636';
	$database 	= 'congresos';
	$driver		= 'mysqli';

} else {
	define('HOST'		, 'http://www.congresosyjornadas.net');
	define('INST_DIR'	, '');
	$server 	= 'localhost';
	$user 		= 'congrejo_nando';
	$password 	= 'Dolci62636';
	$database 	= 'congrejo_congresos';
	$driver		= 'mysqli';

}


// ------------------------------------------------------------------ Rutas
define('RUTA'	, HOST.INST_DIR);

if (substr ($_SERVER['DOCUMENT_ROOT'], -1) == '/') {
	$root = substr($_SERVER['DOCUMENT_ROOT'],0,(strlen($_SERVER['DOCUMENT_ROOT'])-1));
} else { $root = $_SERVER['DOCUMENT_ROOT']; }

$NombreCatalogo = 'Catalogo';

define('ROOT',		$root.INST_DIR			    );
define('IMG', 		HOST.INST_DIR.'/img/'       );
define('IMG_ADMIN', HOST.INST_DIR.'/admin/img/' );
define('CSS', 		HOST.INST_DIR.'/html/'      );
define('URL', 		HOST.INST_DIR               );
define('mURL', 		HOST.INST_DIR.'/m'         );
define('ADMIN', 	HOST.INST_DIR."/admin/"     );
//define('CATALOGO', 	HOST.INST_DIR."/".strtolower($NombreCatalogo)."/" );
define('CATALOGO', 	HOST.INST_DIR."/" );

$_SESSION['archivos'] = URL.'/archivos/';

define('SUBIR_FOTOS', 	ROOT."/archivos/images/anuncios/" );
define('VER_FOTOS', 	URL."/archivos/images/anuncios" );

define('SUBIR_PUBLICIDAD', 	ROOT."/archivos/images/publicidad" );
define('VER_PUBLICIDAD', 	URL."/archivos/images/publicidad" );

define('SUBIR_ARCHIVOS', 	ROOT."/archivos/files" );
define('VER_ARCHIVOS', 	    URL."/archivos/files" );

define('SUBIR_ALOJAMIENTOS', 	ROOT."/archivos/alojamientos" );
define('VER_ALOJAMIENTOS', 	    URL."/archivos/alojamientos" );

define('SUBIR_CERTIFICADOS', 	ROOT."/archivos/certificados" );
define('VER_CERTIFICADOS', 	    URL."/archivos/certificados" );

$ruta_iconos = URL.'/archivos/images/iconos/';

define('IMAGENES_POR_ANUNCIO', 	5 );
define('CANTIDAD_DE_RUBROS', 	1 );
define('CIUDAD',64651 );
define('PROVINCIA',80 );
define('PAIS', 	'Argentina' );
define('LATITUD', 	'-32.9507' );
define('LONGITUD', 	'-60.666' );

//--------------------------------------------------------------------Conexion BD
include(ROOT.'/adodb/adodb-time.inc.php');
include(ROOT.'/adodb/adodb.inc.php');
$db = &ADONewConnection($driver); 
$db->PConnect($server,$user,$password,$database);
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->debug = false;




$url = explode('/',$_SERVER["REQUEST_URI"]);
$url_actual = end($url);
//echo $url_actual; die();
/*
if($url_actual=='index.php') {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: '.URL );
}
*/

$idioma_elegido = 1; //$_SESSION['idioma'];
include_once('funciones.php');
include_once('inc_idiomas.php');
include_once('inc_settings.php');
include_once('inc_meta_tags.php');
include_once('inc_redes_sociales.php');
include_once('inc_provincias.php');


//---------------------------- Está logueado ? 
//$login = esta_login();
?>