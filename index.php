<?php
// ------------------- CONTROLLER -------------------
session_start();
//Site-relevante Werte aus config.php
require_once('system/config.php');
//DB-Abfragen aus data.php
require_once('system/data.php');
//Sessionhandler
require_once('templates/session_handler.php');

// ------------------- Variabeln definieren -------------------
$id = $_SESSION['userid'];
$user = get_user_by_id($id);
$user_id = $user['id'];
$vorbereitung = $user['vorbereitung'];
$umsetzung = $user['umsetzung'];
$praesentation = $user['praesentation'];

$logged_in = true;

// ------------------- Fortschritt updaten -------------------
//Wenn Button "Speichern" geklickt
if(isset($_POST['checkbox_submit'])){
  $msg = "";
  //Wenn Switchbox "Vorbereitung" ein, $vorbereitung = 1
  if(isset($_POST['fortschritt_vorbereitung'])){
      $vorbereitung = $_POST['fortschritt_vorbereitung'];
      //$vorbereitung = 1;
  //sonst $vorbereitung = 0
  }else{
    $vorbereitung = 0;
  }
  //Wenn Switchbox "Umsetzung" ein, $umsetzung = 1
  if(isset($_POST['fortschritt_umsetzung'])){
      $umsetzung = $_POST['fortschritt_umsetzung'];
      //$umsetzung = 1;
  //sonst $umsetzung = 0
  }else{
    $umsetzung = 0;
  }
  //Wenn Switchbox "Präsentation" ein, $praesentation = 1
  if(isset($_POST['fortschritt_praesentation'])){
      $praesentation = $_POST['fortschritt_praesentation'];
      //$praesentation = 1;
  //sonst $praesentation = 0
  }else{
    $praesentation = 0;
  }

  //Fortschritt in Datenbank speichern
  update_fortschritt($vorbereitung, $umsetzung, $praesentation, $id);
  $msg .= "Dein Fortschritt wurde gespeichert.";
}

// ------------------- VIEW -------------------
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Minor WebTech</title>
     <!-- Header -->
     <?php
       $page_head_title = "Minor WebTech"; // Inhalt des <title>-Elements
       require_once('templates/page_head.php'); // Inhalt des <head>-Elements einbinden
     ?>
   </head>
   <body>
     <div align="center">
      <!-- Navigation -->
      <?php require_once('templates/menu.php'); //Navigation einbinden ?>
      <!-- Inhalt -->
      <section>
        <br><br><br><br>
        <h1>Hallo <?php echo $user['firstname'] ?> </h1>
        <p>Schön, dass du das Minor WebTech gewählt hast.</p>
        <br>

        <!-- Fortschritt -->
        <div style="background: lightgrey">
          <br>
          <h2>Fortschritt</h2>
          <p>Gib deinen Fortschritt an und klicke anschliessend auf speichern.</p>
          <br>

          <!-- Fortschritt Checkbox-->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="custom-control custom-switch">
              <input type="checkbox" name="fortschritt_vorbereitung" class="custom-control-input"
              id="customSwitchVorbereitung" value="1" <?php if($vorbereitung) echo "checked" ?>>
              <label class="custom-control-label" for="customSwitchVorbereitung">Vorbereitung</label>
            </div>
            <div class="custom-control custom-switch">
              <input type="checkbox" name="fortschritt_umsetzung" class="custom-control-input"
              id="customSwitchUmsetzung" value="1" <?php if($umsetzung) echo "checked" ?>>
              <label class="custom-control-label" for="customSwitchUmsetzung">Umsetzung</label>
            </div>
            <div class="custom-control custom-switch">
              <input type="checkbox" name="fortschritt_praesentation" class="custom-control-input"
              id="customSwitchPraesentation" value="1" <?php if($praesentation) echo "checked" ?>>
              <label class="custom-control-label" for="customSwitchPraesentation">Präsentation</label>
            </div>
            <br>
            <button type="submit" name="checkbox_submit" class="btn btn-secondary" value="speichern" align="center">Speichern</button>
          </form>
          <br>

          <!-- Text wenn gespeichert -->
          <?php if(!empty($msg)){ ?>
            <div class="alert alert-info msg" role="alert">
              <p><?php echo $msg ?></p>
            </div>
          <?php } ?>
          <br>
        </div>

        <!-- Diplom -->
        <?php if($vorbereitung && $umsetzung && $praesentation){ ?>
          <br>
          <h2>Diplom</h2>
          <p>Gratuliere, du hast alle Aufgaben für das Minor Webtech erfüllt.</p>
          <p>Klick auf den Button um dein Diplom zu generieren.</p>
          <a class="btn btn-secondary btn-lg" href="<?php echo $base_url ?>pdf.php" role="button" target="_blank">Diplom</a>
        <?php } ?>
      </section>
     </div>

     <!-- Footer -->
     <?php include_once('templates/footer.php') ?>
   </body>
 </html>
