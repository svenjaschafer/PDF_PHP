<?php
  // ------------------- Anpassungen -------------------
  /*
  Varabeln im verwendeten Dokument (pdf_vorlage.php) definieren (sonst unten abändern)
    $pdfName
    $pdfAuthor
    $empfaenger

  Dokumentinformationen
    SetTitle und SetSubject abändern
  */


  // ------------------- PDF erzeugen -------------------
  // TCPDF Library laden
  require_once('tcpdf/tcpdf.php');

  // Erstellung des PDF Dokuments
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // Dokumentinformationen
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor($pdfAuthor);
  $pdf->SetTitle('Diplom '.$empfaenger);
  $pdf->SetSubject('Diplom '.$empfaenger);

  // Header und Footer Informationen
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // Auswahl der Schrift
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // Auswahl der Margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // Automatisches Autobreak der Seiten
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // Image Scale
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // Schriftart setzen
  $pdf->SetFont('dejavusans', '', 10);

  // Neue Seite hinzufügen
  $pdf->AddPage();

  // HTML Code ins PDF einfügen
  $pdf->writeHTML($html, true, false, true, false, '');

  //Ausgabe des PDFs
    //Variante 1: PDF direkt an den Benutzer senden:
    $pdf->Output($pdfName, 'I');

    //Variante 2: PDF im Verzeichnis abspeichern:
    //$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
    //echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
 ?>
