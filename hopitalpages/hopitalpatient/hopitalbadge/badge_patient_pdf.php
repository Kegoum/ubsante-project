<?php

ob_start();
@include('badge_patient.php');
$content = ob_get_clean();

// convert in PDF
require_once('../../../hopitalpdf/html2pdf.class.php');
try {
    $width_in_mm = 100;
    $height_in_mm = 150;
    $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'fr', true, 'UTF-8', 0);
//    $html2pdf = new HTML2PDF('L', array($width_in_mm, $height_in_mm), 'fr', false, 'ISO-8859-15', 0);
    //$html2pdf = new HTML2PDF('L', 'A5', 'fr');
    //$html2pdf->pdf->IncludeJS("print(true);");
    //$html2pdf->pdf->SetProtection(array('print'), 'badge');
    //$html2pdf->pdf->AddFont('times','','_tcpdf_5.0.002/fonts/times.php');
    //$html2pdf->pdf->SetFont("times "); 
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Badge '.$row->nomhopital.' '.$row->prenomhopital.'.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>	