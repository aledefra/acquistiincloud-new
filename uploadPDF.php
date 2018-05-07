<!DOCTYPE html>
<html>

<style>
@import url(docs.css);
@import url(css/component.css);
@import url(css/demo.css);
@import url(css/normalize.css);
</style>

<head>

<meta charset="UTF-8">

  <title>
    Carica fatture
  </title>

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script scr="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="index.js"></script>
  <link rel="icon" type="image/png" href="/acquistiincloud/images/favicon.png">
  <link rel="stylesheet" type="text/css" href="css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="css/demo.css" />
  <link rel="stylesheet" type="text/css" href="css/component.css" />
  <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

</head>
<script>

  <?php
    include "functions.php";
  ?>
</script>

<body class="topmarg">

  <div class="navbar">
    <a class="active" href="docs.php"><strong>Acquisti </strong>in <strong>Cloud</strong></a>
    <a class="reg-right" href="registra.php">Registra</a>
    <a class="reg-right" href="downFIC.php">Scarica fatture da FIC</a>
    <a class="reg-right" href="uploadPDF.php">Carica fatture</a>

    <meta name="viewport" content="width=device-width, initial-scale=1">

  </div>

<form class="form-div" action="<?php uploadPDF(); ?>" method="post" enctype="multipart/form-data">
    <div class="content">
      <div class="box">
        <input type="file" name="upload[]" id="file" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" multiple />
        <label for="file"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span>Scegli un file &hellip;</span></label>
      </div>
    </div>
<br><br><br>
    Ditta: <select name="ditta">
      <?php
        retrieveDitteForDropdown();
      ?>
    </select><br>
    <input type="submit" value="Upload File" name="submit">
</form>
  <script src="js/custom-file-input.js"></script>
</body>
</html>
