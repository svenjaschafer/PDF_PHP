<?php
// ------------------- CONTROLLER -------------------
session_start();
// Alle Site-relevanten Werte (base-url, DB-Einstellungen) sind in config.php zentral gespeichert.
require_once('system/config.php');
// DB-Abfragen in data.php zusammengefasst
require_once('system/data.php');


 // Wir prüfen, ob es eine Session-Variable $_SESSION['userid'] gibt.
 if(isset($_SESSION['userid'])) {
   // Falls es eine solche Variable gibt, zerstören wir sie...
   unset($_SESSION['userid']);
   // Session beenden - User ist ausgeloggt.
   session_destroy();
 }
 // Die in templates/menu.php benötigten Variablen müssen wir im Controller setzen.
 // (Diese Variablen werden sonst in templates/session_handler.php vergeben.)
 $logged_in = false;
 $log_in_out_text = "Anmelden";


 if(isset($_POST['login_submit'])){
   // User kann nur eingeloggt werden, wenn Variable true ist
   $login_submit_valid = true;
   // $msg = Variable für Fehlermeldung
   $msg = "";

   // E-Mail darf nicht leer sein
   if(!empty($_POST['email'])){
     // Eingabe wird in Variable $email gespeichert
     $email = $_POST['email'];
   }else{
     // wenn Email Feld leer ist wird Fehlermeldung in $msg gespeichert
     // und $login_submit_valid = false gesetzt.
     $msg .= "Bitte gib deine E-Mailadresse  ein.<br>";
     $login_submit_valid = false;
   }

   // Passwort darf nicht leer sein
   if(!empty($_POST['password'])){
     // Eingabe wird in Variable $password gespeichert
     $password = $_POST['password'];
   }else{
     // wenn Passwort Feld leer ist wird Fehlermeldung in $msg gespeichert
     // und $login_submit_valid = false gesetzt.
     $msg .= "Bitte gib dein Passwort ein.<br>";
     $login_submit_valid = false;
   }

   // Wenn $login_submit_valid = true, können wir versuchen den User einzuloggen
   if($login_submit_valid){
     // Daten mit DB vergleichen - entweder kommt Array mit Daten zurück oder false
     // Ergebnis in $result speichern
     $result = login($email , $password);
     //Wird nur durchgeführt, wenn $result nicht false ist
     if($result){
       //Werte aus $result wird in $user gespeichert
       $user = $result;

       // ID vom User wird in userid gespeichert - User ist eingeloggt
       $_SESSION['userid'] = $user['id'];

       // Weiterleitung auf index.php
       header('Location: index.php');
       exit;
    // Wenn $login_submit_valid = false, kann der User nicht eingeloggt werden
     }else{
       // Fehlermeldung in $msg speichern
       $msg = "Die Benutzerdaten sind nicht in unserer Datenbank vorhanden.";
     }
   }
 }
  // ---------------------- VIEW ----------------------
 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PDF mit PHP</title>
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

      <br><br><br>

      <!-- Grid mit 3 Spalten -->
      <div class="row">
        <!-- Spalte 1 (ohne Inhalt) -->
        <div class="col-sm"></div>
        <!-- Spalte 2 (Anmeldeformular) -->
        <div class="col-5">
          <section class="content">
            <br><br><br>
            <h1>Anmelden</h1>
            <p>Bitte melde dich an.</p>
            <br><br>
            <!-- Anmeldeformular -->
            <form action="<?php echo $_SERVER['PHP_SELF']; // $_SERVER['PHP_SELF'] gibt die Adresse der aktuellen Datei aus ?>" method="post">
              <!-- E-Mail -->
              <div class="form-group">
                <label for="id_email">E-Mail: </label>
                <input type="email" name="email" class="form-control" id="id_email">
              </div>
              <!-- Passwort -->
              <div class="form-group">
                <label for="id_password">Passwort: </label>
                <input type="password" name="password" class="form-control" id="id_password">
              </div>
              <br><br>
              <!-- Anmelde-Button -->
              <button type="submit" name="login_submit" class="btn btn-secondary" value="einloggen">Anmelden</button>
            </form>

            <!-- optionale Nachricht -->
      <?php if(!empty($msg)){ ?>
            <div class="alert alert-info msg" role="alert">
              <p><?php echo $msg ?></p>
            </div>
      <?php } ?>
          </section>
        </div>
        <!-- Spalte 3 (ohne Inhalt) -->
        <div class="col-sm"></div>
      </div>






      <!-- Footer -->
      <?php include_once('templates/footer.php') ?>
    </div>
  </body>
</html>
