<?php
    include ('../inc/config.php'); 

	$code = request('code','');

	//------------------------------------------------------------------------
	//                     Obtiene los datos del Certificado y del Inscripto
	//------------------------------------------------------------------------
	$sql = "SELECT ci.*, i.nombre, i.apellido, i.tipo_doc, i.nro_doc, i.email, 
		c.titulo, c.cuerpo, c.imagen, c.orientacion, c.firma_x, c.firma_y, c.firma_color
		FROM certificados_inscriptos AS ci
		LEFT JOIN inscripciones AS i ON ci.inscripto_id = i.id
		LEFT JOIN certificados AS c ON ci.certificado_id = c.id
		WHERE ci.code='$code' ";

	$rs = $db->Execute($sql);
	$Certificado = $rs->FetchRow();

	if( empty($Certificado) ){

		$Mensaje["mensaje"] = "ERROR! No se encuentran los datos del Certificado. Por favor vuelva a intentarlo más tarde. Gracias!";
        $Mensaje["tipo"]    = 'error';
        $Mensaje["autoclose"] = true;
        $_SESSION['Mensaje'] = $Mensaje;                

	} else {

		//------------------------------------------------------------------------
		//                                                             Arma el PDF
		//------------------------------------------------------------------------

		//----------------------------------- Imagen de Fondo
		$background_image = '';
		if(!empty($Certificado['imagen'])){
			$background_image = VER_CERTIFICADOS.'/'.$Certificado['imagen'];	
		}


		$titulo = utf8_decode( $Certificado['titulo'] );
		$cuerpo = utf8_decode( $Certificado['cuerpo'] );

		$repNombre   = utf8_decode( strtoupper( trim( $Certificado['nombre'] ) ) ) ;
		$repApellido = utf8_decode( strtoupper( trim( $Certificado['apellido'] ) ) ) ;
		$repDocumento = utf8_decode( strtoupper( trim( $Certificado['tipo_doc'] ) ) ). ': ' . number_format($Certificado['nro_doc'],0,'.',',') ;

		$cuerpo = str_replace('#NOMBRE#', $repNombre , $cuerpo ) ;
		$cuerpo = str_replace('#APELLIDO#', $repApellido , $cuerpo);
		$cuerpo = str_replace('#DOCUMENTO#', $repDocumento, $cuerpo);

		require(ROOT.'/modules/fpdf/fpdf.php');

		//$pdf = new FPDF("{$Certificado['orientacion']}",'mm','A4'); // L: Apaisado || P:Vertical
		$pdf = new FPDF("L",'mm','A4'); // L: Apaisado || P:Vertical
		$pdf->AddPage();

		if(!empty($background_image)){
			$pdf->Image("$background_image",5,8,287);	
		}

		$pdf->SetFont('Arial','I',20);	
		$pdf->Sety(63);
		$pdf->Setx(40);
		$pdf->MultiCell(220,10,$titulo,0,'C');

		$pdf->SetFont('Arial','I',15);	
		$pdf->Ln();
	//	$pdf->Sety(115);
		$pdf->Setx(40);
		$pdf->MultiCell(220,10,$cuerpo,0,'C');

		//------------------------------- Footer CJ
		#Establecemos el margen inferior: 
		$pdf->SetFont('Arial','I',8);	
		$pdf->SetTextColor( $Certificado['firma_color'] );	
		$pdf->SetAutoPageBreak(false,20);
		$pdf->Sety( $Certificado['firma_y'] );
		$pdf->Setx( $Certificado['firma_x'] );
		$pdf->Cell(60,9,'http://www.CongresosyJornadas.Net',0,1,'C');

		//$pdf->Cell(40,10,$texto,0);
		//$pdf->Cell(60,30,'Hecho con FPDF.',1,1,'C');

		$pdf->Output();


	}

	


?>