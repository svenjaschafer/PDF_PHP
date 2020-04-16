<?php
// ------------------- CONTROLLER -------------------
session_start();
// Alle Site-relevanten Werte (base-url, DB-Einstellungen) sind in config.php zentral gespeichert.
require_once('system/config.php');
// DB-Abfragen in data.php zusammengefasst
require_once('system/data.php');

// ------------------- Variabeln definieren -------------------
$id = $_SESSION['userid'];
$user = get_user_by_id($id);
$fortschritt_vorbereitung = $user['fortschritt_vorbereitung'];
$fortschritt_umsetzung = $user['fortschritt_umsetzung'];
$fortschritt_praesentation = $user['fortschritt_praesentation'];

$logged_in = true;

// ------------------- Fortschritt updaten -------------------
//funtioniert noch nicht
if(isset($_POST['checkbox_submit'])){
  // $msg = Variable für Nachricht
  $msg = "Fortschritt wurde gespeichert";
  update_fortschritt($fortschritt_vorbereitung, $fortschritt_umsetzung, $fortschritt_praesentation, $id);

  }

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Minor WebTech</title>
     <!-- Header -->
     <?php
       $page_head_title = "Minor WebTech"; // Inhalt des <title>-Elements
       require_once('templates/page_head.php'); // Inhalt des <head>-Elements aus externer PHP-Datei
     ?>
   </head>
   <body>
     <div class="container" align="center">
      <!-- Navigation -->
      <?php require_once('templates/menu.php'); // Navigation aus externer PHP-Datei ?>

      <section>
        <br><br><br>
        <h1>Hallo <?php echo $user['firstname'] ?> </h1>
        <p>Schön, dass du das Minor WebTech gewählt hast.</p>
        <br>

        <h2>Fortschritt</h2>
        <p>Gib deinen Fortschritt an und klicke anschliessend auf speichern.</p>
        <br>
        <!-- Fortschritt Checkbox-->
        <div class="row" align="left">
          <!-- Spalte 1 (ohne Inhalt) -->
          <div class="col-sm">
            <p>Vorbereitung: <?php echo $fortschritt_vorbereitung ?></p>
            <p>Umsetzung: <?php echo $fortschritt_umsetzung ?></p>
            <p>Präsentation: <?php echo $fortschritt_praesentation ?></p>
          </div>
          <!-- Spalte 2 (Checkbox) -->
          <div class="col-3">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitchVorbereitung" value="">
              <label class="custom-control-label" for="customSwitchVorbereitung">Vorbereitung</label>
            </div>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitchUmsetzung" value="">
              <label class="custom-control-label" for="customSwitchUmsetzung">Umsetzung</label>
            </div>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitchPraesentation" value="">
              <label class="custom-control-label" for="customSwitchPraesentation">Präsentation</label>
            </div>
            <br>
            <button type="submit" name="checkbox_submit" class="btn btn-secondary" value="speichern" align="center">Speichern</button>
          </div>
          <!-- optionale Nachricht -->
    <?php if(!empty($msg)){ ?>
          <div class="alert alert-info msg" role="alert">
            <p><?php echo $msg ?></p>
          </div>
    <?php } ?>
          <!-- Spalte 3 (ohne Inhalt) -->
          <div class="col-sm"></div>
        </div>

        <!-- Diplom Button -->
        <br><br><br>
        <p>Gratuliere, du hast alle Aufgaben für das Minor Webtech erfüllt.</p>
        <p>Klick auf den Button um dein Diplom zu generieren.</p>
        <a class="btn btn-secondary btn-lg" href="<?php echo $base_url ?>pdf_erstellen2.php" role="button" target="_blank">Diplom</a>


      </section>
     </div>

   </body>
 </html>
