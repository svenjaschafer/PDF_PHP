<?php
// ------------------- CONTROLLER -------------------
session_start();
// Alle Site-relevanten Werte (base-url, DB-Einstellungen) sind in config.php zentral gespeichert.
require_once('system/config.php');
// DB-Abfragen in data.php zusammengefasst
require_once('system/data.php');

// ------------------- Variabeln definieren -------------------
$id = 1;
$user = get_user_by_id($id);

// ------------------- Allgemeine Angaben des PDFs -------------------
$diplom_nummer = "1";
$ausstelldatum = date("d.m.Y");
$pdfAuthor = "Svenja Schafer";

$diplom_header = '
Fachhochschule Graubünden
Pulvermühlestrasse 57
7000 Chur
Tel. +41 81 286 24 24
info@fhgr.ch

Minor WebTech
';

//Name des Empfängers
$diplom_empfaenger = $user['lastname']. ' ' .$user['firstname'];

//Footer Text
$diplom_footer = "Hiermit bestätigen wir, dass " .$user['title']. " " .$user['firstname']. " " .$user['lastname']. " das Minor WebTech im Frühlingssemester 2020 erfolgreich abgeschlossen hat.";


//Name des PDFs, wenn es heruntergeladen wird
$pdfName = "Diplom_".$diplom_nummer.".pdf";


// ------------------- PDF Inhalt als HTML -------------------
$html = '
<!-- Tabelle mit Header, Angaben und Text -->
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
  <!-- Zeile 1 -->
  <tr>
    <!-- Zeile 1 | Spalte 1 (FHGR Angaben) -->
    <td>'.nl2br(trim($diplom_header)).'</td>
    <!-- Zeile 1 | Spalte 2 (Diplomangaben) -->
    <td style="text-align: right">
      Diplomnummer: '.$diplom_nummer.'<br>
      Ausstelldatum: '.$ausstelldatum.'<br>
    </td>
  </tr>

  <!-- Zeile 2 -->
  <tr>
    <!-- Zeile 2 | Spalte 1 (Text Diplom) -->
    <td style="font-size:5em; font-weight: bold;">
      <br>
      <br>
Diplom
    </td>
  </tr>

  <!-- Zeile 3 -->
  <tr>
    <!-- Zeile 3 | Spalte 1 (Text Empfänger) -->
    <td colspan="2" style="font-size:3em; font-weight: regular;">'.nl2br(trim($diplom_empfaenger)).'</td>
  </tr>
</table>

<br>
<br>
<br>
<br>
<br>

<!-- Tabelle Projekt -->
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
  <!-- Zeile 1 -->
  <tr style="background-color: #cccccc; padding:5px;">
    <td><b>Projekt</b></td>
    <td><b>Zeitaufwand</b></td>
    <td><b>Abgabedatum</b></td>
  </tr>
  <!-- Zeile 2 -->
  <tr>
    <td>'.$user['project'].'</td>
    <td>2 Tage</td>
    <td>17.04.2020</td>
  </tr>
</table>

<br>
<br>
<br>';

$html .= nl2br($diplom_footer);


// ------------------- PDF erzeugen -------------------
// TCPDF Library laden
require_once('tcpdf/tcpdf.php');

// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumentinformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
$pdf->SetTitle('Diplom '.$diplom_empfaenger);
$pdf->SetSubject('Diplom '.$diplom_nummer);

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
