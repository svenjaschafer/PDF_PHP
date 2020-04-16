<?php
// ------------------- CONTROLLER -------------------
session_start();
require_once('system/config.php');
require_once('system/data.php');
require_once('templates/session_handler.php');

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PDF mit PHP</title>

    <!-- Header -->
    <?php
      $page_head_title = "PDF PHP"; // Inhalt des <title>-Elements
      require_once('templates/page_head.php'); // Inhalt des <head>-Elements aus externer PHP-Datei
    ?>
  </head>
  <body>
    <h1>PDF PHP</h1>
    <button href= "https://827899-18.web1.fh-htwchur.ch/pdf_erstellen.php" type="submit" name="test_pdf_submit" class="btn btn-primary" value="pdf_test">Test PDF erstellen</button>

    <!-- Footer -->
    <?php include_once('templates/footer.php') ?>
  </body>
</html>
