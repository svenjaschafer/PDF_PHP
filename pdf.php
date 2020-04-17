<?php
// ------------------- CONTROLLER -------------------
session_start();
//Site-relevante Werte aus config.php
require_once('system/config.php');
//DB-Abfragen aus data.php
require_once('system/data.php');

// ------------------- Variabeln definieren -------------------
$id = $_SESSION['userid'];
$user = get_user_by_id($id);

// ------------------- Allgemeine Angaben des PDFs -------------------
$ausstelldatum = date("d.m.Y");
$pdfAuthor = "Svenja Schafer";
$header = '
Fachhochschule Graubünden
Pulvermühlestrasse 57
7000 Chur
Tel. +41 81 286 24 24
info@fhgr.ch

Minor WebTech
';
  //Empfängers
$empfaenger = $user['lastname']. ' ' .$user['firstname'];
  //Footer Text
$footer = "Hiermit bestätigen wir, dass " .$user['title']. " " .$user['firstname']. " " .$user['lastname']. " das Minor WebTech im Frühlingssemester 2020 erfolgreich abgeschlossen hat.";
  //Name des PDFs, wenn es heruntergeladen wird
$pdfName = "Diplom_".$user['lastname']."_".$user['firstname'].".pdf";

// ------------------- PDF Inhalt als HTML -------------------
$html = '
<!-- Tabelle mit Header, Angaben und Text -->
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
  <!-- Zeile 1 -->
  <tr>
    <!-- Zeile 1 | Spalte 1 (FHGR Angaben) -->
    <td>'.nl2br(trim($header)).'</td>
    <!-- Zeile 1 | Spalte 2 (Diplomangaben) -->
    <td style="text-align: right">
      Ausstelldatum: '.$ausstelldatum.'<br>
    </td>
  </tr>

  <!-- Zeile 2 -->
  <tr>
    <!-- Zeile 2 | Spalte 1 (Text Diplom) -->
    <td style="font-size:5em; font-weight: bold;">
      <br>
      <br>
DIPLOM
    </td>
  </tr>

  <!-- Zeile 3 -->
  <tr>
    <!-- Zeile 3 | Spalte 1 (Text Empfänger) -->
    <td colspan="2" style="font-size:3em; font-weight: regular;">'.nl2br(trim($empfaenger)).'</td>
  </tr>
</table>

<br><br><br><br><br><br><br>

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

<br><br><br><br><br><br>';

$html .= nl2br($footer);

// ------------------- PDF erzeugen -------------------
require_once('create_pdf.php');
?>
