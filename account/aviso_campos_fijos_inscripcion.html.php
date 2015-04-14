<?php


		//----------------------------------------------------------------------------
		//		Es la primera vez que se ejecuta, entonces creo los campos por defecto
		// Apellido, Nombre, Email, Plan/Tarifa, Ciudad, Provincia, Pais, Telefono
		//----------------------------------------------------------------------------
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 0;
		$xpfi['etiqueta']    = 'Datos Personales';
		$xpfi['nombre']      = '';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 0;
		$CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Apellido';
		$xpfi['nombre']      = 'apellido';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 1;
        $CamposPredefinidos[] = $xpfi;
	
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Nombre';
		$xpfi['nombre']      = 'nombre';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 2;
		$CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 3;
		$xpfi['etiqueta']    = 'Tipo de Documento';
		$xpfi['nombre']      = 'tipo_doc';
		$xpfi['valores']     = 'DNI
								LC
								LE
								CI
								PAS';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 3;
        $CamposPredefinidos[] = $xpfi;
		
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Nro.de Documento';
		$xpfi['nombre']      = 'nro_doc';
		$xpfi['placeholder'] = 'Ingrese solo el número, sin puntos';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 3;
        $CamposPredefinidos[] = $xpfi;
		
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Email';
		$xpfi['nombre']      = 'email';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 4;
        $CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Teléfono';
		$xpfi['nombre']      = 'telefono';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 5;
        $CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Domicilio';
		$xpfi['nombre']      = 'domicilio';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 6;
        $CamposPredefinidos[] = $xpfi;
		
		
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Ciudad';
		$xpfi['nombre']      = 'ciudad';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 7;
        $CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'Provincia';
		$xpfi['nombre']      = 'provincia';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 8;
        $CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 1;
		$xpfi['etiqueta']    = 'País';
		$xpfi['nombre']      = 'pais';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 9;
        $CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 3;
		$xpfi['etiqueta']    = '¿Cómo se enteró de esta actividad?';
		$xpfi['nombre']      = 'como_se_entero';
		$xpfi['valores']     = 'Mailing
								Por un colega
								Facebook
								Twitter
								Otras Redes Sociales
								Carteles
								Radios
								Televisión
								Diarios/Revistas
								Otros Portales Web
								Otros';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 10;
		$CamposPredefinidos[] = $xpfi;		
		
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 0;
		$xpfi['etiqueta']    = 'Posición Arancelaria';
		$xpfi['nombre']      = 'posicion_arancelaria';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 11;
        $CamposPredefinidos[] = $xpfi;
		
		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 3;
		$xpfi['etiqueta']    = 'Categoría de Aranceles';
		$xpfi['nombre']      = 'categoria_aranceles';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 12;
        $CamposPredefinidos[] = $xpfi;

		$xpfi = array();
		$xpfi['id']          = 0;  
		$xpfi['user_id']     = $user_id;
		$xpfi['producto_id'] = $producto_id;
		$xpfi['tipo_campo']  = 0;
		$xpfi['etiqueta']    = 'Datos Adicionales';
		$xpfi['nombre']      = '';
		$xpfi['valores']     = '';
		$xpfi['editable']    = 0;
		$xpfi['orden']       = 13;
        $CamposPredefinidos[] = $xpfi;
        
?>