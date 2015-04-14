function nuevoAjax()
{
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp;
}

function cargaContenido(opcionSeleccionada)
{
	// Obtengo el elemento del select que debo cargar
	var idSelectDestino= 'pub_id' //listadoSelects[posicionSelectDestino];
	var selectDestino=document.getElementById(idSelectDestino);
	// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
	var ajax=nuevoAjax();
	ajax.open("GET", "menues_busca_publicacion.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==1)
		{
			// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
			selectDestino.length=0;
			var nuevaOpcion=document.createElement("option"); nuevaOpcion.value=0; nuevaOpcion.innerHTML="Cargando...";
			selectDestino.appendChild(nuevaOpcion); selectDestino.disabled=true;
		}
		if (ajax.readyState==4)
		{
			selectDestino.parentNode.innerHTML=ajax.responseText;
		}
	}
	ajax.send(null);

}