<?php




include ( 'PdfToText.phpclass' ) ;

$pdf = new PdfToText ( 'fff.pdf' ) ;
echo $pdf -> Text ; 		// or you could also write : echo ( string ) $pdf ;



?>