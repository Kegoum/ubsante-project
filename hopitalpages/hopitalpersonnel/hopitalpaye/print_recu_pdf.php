<?php
// get the HTML
    ob_start(); //démarrage du pdf
  
    include('print_recu.php');
    $content = ob_get_clean(); //récupération du contenu de facture.pdf

    // convert in PDF
    require_once('../../../hopitalpdf/html2pdf.class.php'); //inclusion de la class pdf
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        #$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('paye_personnel.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
