<?php

//list($ciudad,$estado) = explode('-',$usuario['datos']['ciudad']);
/*
if (!empty($usuario['datos']['campo_logo'])) {
	$foto = URL.'/archivos/usuarios/'.$usuario['id'].'/'.$usuario['datos']['campo_logo'];
} else {
	$foto = '';
	//PHOTO;VALUE=URL;TYPE=GIF:http://www.example.com/dir_photos/my_photo.gif
}
*/
$vcard = "BEGIN:VCARD
VERSION:3.0
N:{$DatosEmpresa['nombre_empresa']}
FN:{$DatosEmpresa['nombre_empresa']}
ORG: {$DatosEmpresa['nombre_empresa']}
TEL;TYPE=cell,voice:+{$DatosEmpresa['telefono']}
TEL;TYPE=work,fax:+{$DatosEmpresa['fax']}
ADR;TYPE=WORK:;;{$DatosEmpresa['address']} ;{$DatosEmpresa['localidad']};{$DatosEmpresa['provincia']};{$DatosEmpresa['cp']};{$DatosEmpresa['pais']}
EMAIL;TYPE=internet,pref:{$DatosEmpresa['email']}
URL;TYPE=work:".URL."
NOTE:".URL."
END:VCARD";


$var = urlencode($vcard);

echo "<center><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$var' style='width:200px;'></center>";

/* 
ADR;TYPE=WORK:;;100 Waters Edge;Baytown;LA;30314;United States of America
ADR;TYPE=work:;;{$usuario['datos']['direccion']}, {$usuario['datos']['piso_dto']};$ciudad;$estado;{$usuario['datos']['cp']};".PAIS."
ADR;WORK;POSTAL;PARCEL;DOM;PREF:;;{$usuario['datos']['direccion']} {$usuario['datos']['piso_dto']};$ciudad;$estado;
*/

?>