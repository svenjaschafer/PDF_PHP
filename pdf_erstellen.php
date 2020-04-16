<?php
//Allgemeine Angaben
$diplom_nummer = "1";
$ausstelldatum = date("d.m.Y");
$pdfAuthor = "Svenja Schafer";

$diplom_header = 'Svenja Schafer';

$diplom_empfaenger = 'Hier kommt der Name des Empfängers';

$diplom_footer = "Hiermit bestätigen wir, dass <b>Anrede</b> <b>Vorname</b> <b>Nachname</b> das Minor WebTech im Frühlingssemester 2020 erfolgreich abgeschlossen hat.";

//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnung, Menge, Einzelpreis]
$diplom_posten = array(
 array("Projekt", 1, 42.50),
 array("Produkt 2", 5, 5.20),
 array("Produkt 3", 3, 10.00));

//Höhe eurer Umsatzsteuer. 0.19 für 19% Umsatzsteuer
$umsatzsteuer = 0.0;

//Name des PDFs, wenn es heruntergeladen wird
$pdfName = "Diplom_".$diplom_nummer.".pdf";


//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.

$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
  <tr>
    <td>'.nl2br(trim($diplom_header)).'</td>
    <td style="text-align: right">
      Diplomnummer: '.$diplom_nummer.'<br>
      Ausstelldatum: '.$ausstelldatum.'<br>
    </td>
  </tr>

  <tr>
    <td style="font-size:1.3em; font-weight: bold;">
      <br><br>
Diplom
      <br>
    </td>
  </tr>


  <tr>
    <td colspan="2">'.nl2br(trim($diplom_empfaenger)).'</td>
  </tr>
</table>
<br><br><br>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
 <tr style="background-color: #cccccc; padding:5px;">
 <td style="padding:5px;"><b>Projekt</b></td>
 <td style="text-align: center;"><b>Zeitaufwand</b></td>
 <td style="text-align: center;"><b>Abgabedatum</b></td>
 </tr>';


$gesamtpreis = 0;

foreach($diplom_posten as $posten) {
 $menge = $posten[1];
 $einzelpreis = $posten[2];
 $preis = $menge*$einzelpreis;
 $gesamtpreis += $preis;
 $html .= '<tr>
                <td>'.$posten[0].'</td>
 <td style="text-align: center;">'.$posten[1].'</td>
 <td style="text-align: center;">'.number_format($posten[2], 2, ',', '').' Euro</td>
                <td style="text-align: center;">'.number_format($preis, 2, ',', '').' Euro</td>
              </tr>';
}
$html .="</table>";



$html .= '
<hr>
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">';
if($umsatzsteuer > 0) {
 $netto = $gesamtpreis / (1+$umsatzsteuer);
 $umsatzsteuer_betrag = $gesamtpreis - $netto;

 $html .= '
 <tr>
 <td colspan="3">Zwischensumme (Netto)</td>
 <td style="text-align: center;">'.number_format($netto , 2, ',', '').' Euro</td>
 </tr>
 <tr>
 <td colspan="3">Umsatzsteuer ('.intval($umsatzsteuer*100).'%)</td>
 <td style="text-align: center;">'.number_format($umsatzsteuer_betrag, 2, ',', '').' Euro</td>
 </tr>';
}

$html .='
  <tr>
    <td colspan="3"><b>Gesamtsumme: </b></td>
    <td style="text-align: center;"><b>'.number_format($gesamtpreis, 2, ',', '').' Euro</b></td>
  </tr>
</table>
<br><br><br>';

if($umsatzsteuer == 0) {
 $html .= 'Nach § 19 Abs. 1 UStG wird keine Umsatzsteuer berechnet.<br><br>';
}

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
