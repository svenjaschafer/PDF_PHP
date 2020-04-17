<?php
// ------------------- CONTROLLER -------------------
session_start();
//Site-relevante Werte aus config.php
require_once('system/config.php');
//DB-Abfragen aus data.php
require_once('system/data.php');

// ------------------- Variabeln definieren -------------------
$id = $_SESSION['userid'];
  //Nur wenn nötig (+ Funktion in data.php)
$user = get_user_by_id($id);

// ------------------- Allgemeine Angaben des PDFs -------------------
  //Ausstelldatum optional
$ausstelldatum = date("d.m.Y");
$pdfAuthor = "";
  //Header Text optional (bspw. Adresse)
$header = '';
  //Empfängers optional (mit Funktion von $user abgleichen)
$empfaenger = $user['lastname']. ' ' .$user['firstname'];
  //Footer Text optional
$footer = "";
  //Name des PDFs, wenn es heruntergeladen wird
$pdfName = "";

// ------------------- PDF Inhalt als HTML -------------------
  //Allgemeiner HTML Inhalt
$html = '';
  //Footer einbinden
$html .= nl2br($footer);

// ------------------- PDF erzeugen -------------------
  //create_pdf.php einbinden
require_once('create_pdf.php');
?>
