<?php

list($ciudad,$estado) = explode('-',$usuario['datos']['ciudad']);
/*
if (!empty($usuario['datos']['campo_logo'])) {
	$foto = URL.'/archivos/usuarios/'.$usuario['id'].'/'.$usuario['datos']['campo_logo'];
} else {
	$foto = '';
	//PHOTO;VALUE=URL;TYPE=GIF:http://www.example.com/dir_photos/my_photo.gif
}
*/
$ciudad = $Localidades[$Producto['localidad']];
$pcia   = $Producto['provincia'];
$pais   = $Producto['pais'];
$cp     = $Producto['codigo_postal'];
$vcard = "BEGIN:VCARD
VERSION:3.0
N:{$Producto['titulo']}
FN:{$Producto['titulo']}
ORG: {$Producto['titulo']}
TEL;TYPE=cell,voice:+{$Producto['telefono1']}
TEL;TYPE=work,voice:+{$Producto['telefono2']}
TEL;TYPE=work,fax:+{$Producto['fax']}
ADR;TYPE=WORK:;;{$Producto['direccion']} ;$ciudad;$pcia;$cp;$pais
EMAIL;TYPE=internet,pref:{$Producto['email']}
URL;TYPE=work:{$Producto['web']}
NOTE:{$Producto['web']}
END:VCARD";


$var = urlencode($vcard);

echo "<center><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$var' style='width:200px;'></center>";

/* 
ADR;TYPE=WORK:;;100 Waters Edge;Baytown;LA;30314;United States of America
ADR;TYPE=work:;;{$usuario['datos']['direccion']}, {$usuario['datos']['piso_dto']};$ciudad;$estado;{$usuario['datos']['cp']};".PAIS."
ADR;WORK;POSTAL;PARCEL;DOM;PREF:;;{$usuario['datos']['direccion']} {$usuario['datos']['piso_dto']};$ciudad;$estado;
*/

?>