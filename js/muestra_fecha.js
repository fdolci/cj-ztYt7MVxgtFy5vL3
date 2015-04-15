
function actualizaReloj(){ 
	/* Capturamos la Hora, los minutos y los segundos */
	marcacion = new Date() 
	/* Capturamos la Hora */
	Hora = marcacion.getHours() 
	/* Capturamos los Minutos */
	Minutos = marcacion.getMinutes() 
	/* Capturamos los Segundos */
	Segundos = marcacion.getSeconds() 
	/* Si la Hora, los Minutos o los Segundos son Menores o igual a 9, le añadimos un 0 */
	if (Hora<=9) Hora = "0" + Hora
	if (Minutos<=9)  Minutos = "0" + Minutos
	if (Segundos<=9) Segundos = "0" + Segundos
	/* Creamos 4 variables para darle formato a nuestro Script */
	var Inicio, Script, Final, Total
	/* En Reloj le indicamos la Hora, los Minutos y los Segundos */
	Total = Hora + ":" + Minutos + ":" + Segundos + " Hs."
	/* Capturamos una celda para mostrar el Reloj */
	document.getElementById('Fecha_Reloj').innerHTML = Total
	setTimeout("actualizaReloj()",1000) 
}


function muestra_fecha(){
	var mydate=new Date() 
	var year=mydate.getYear() 
	if (year < 1000) year+=1900 
	var day=mydate.getDay() 
	var month=mydate.getMonth() 
	var daym=mydate.getDate() 
	if (daym<10) 
	daym="0"+daym 
	var dayarray=new Array("Domingo,","Lunes,","Martes,","Miércoles,","Jueves,","Viernes,","Sábado,")
	var montharray=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
	setTimeout("actualizaReloj()",1000) 
	document.write(dayarray[day]+" "+daym+" de "+montharray[month]+" de "+year) 
}