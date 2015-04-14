<?php
    include ('../inc/config.php'); 


	$user_id     = $_SESSION['user_id'];	
	$certificado_id = request('certificado_id',0);


	//------------------------------------------------------
	//                     Obtiene los datos del Certificado
	//------------------------------------------------------
	$sql = "SELECT * FROM certificados WHERE id='$certificado_id' ";
	$rs = $db->Execute($sql);
	$Certificado = $rs->FetchRow();

	//------------------------------------------------------
	//                         Obtiene los datos del evento
	//------------------------------------------------------
	$producto_id = $Certificado['producto_id'];
	$sql = "SELECT titulo, subtitulo FROM productos WHERE id='$producto_id' AND user_id='$user_id'";
	$rs = $db->Execute($sql);
	$Evento = $rs->FetchRow();
	if(empty($Evento)){
		redirect(URL.'/account/listar_anuncios.php');
		die();
	}

	$background_image = '';
	if(!empty($Certificado['imagen'])){
		$background_image = VER_CERTIFICADOS.'/'.$Certificado['imagen'];	
	}
	

	$titulo = $Certificado['titulo'];
	$cuerpo = $Certificado['cuerpo'];
	
	$titulo = utf8_decode($titulo);
	$cuerpo = utf8_decode($cuerpo);

	$cuerpo = str_replace('#NOMBRE#', 'FERNANDO', $cuerpo);
	$cuerpo = str_replace('#APELLIDO#', 'DOLCI', $cuerpo);
	$cuerpo = str_replace('#DOCUMENTO#', 'DNI: 21.497.593', $cuerpo);

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


	//$pdf->Cell(40,10,$texto,0);
	//$pdf->Cell(60,30,'Hecho con FPDF.',1,1,'C');

	$pdf->Output();
?>