<!DOCTYPE html>
<html>
<script>
  <?php
  include "functions.php"
  ?>
</script>
<head>

<meta charset="UTF-8">

  <title>
    Acquisti in Cloud
  </title>

  <style>
  @import url(docs.css);
  </style>

 <!-- Icone tabella -->

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <link rel="icon" type="image/png" href="/acquistiincloud/images/favicon.png">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
        $(".custom-select").each(function(){
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom-select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
    })
  </script>

</head>
<body class="topmarg">

  <div class="navbar" href="#top">
    <a class="active" href="docs.php"><strong>Acquisti </strong>in <strong>Cloud</strong></a>
    <a class="reg-right" href="registra.php">Registra</a>
    <a class="reg-right" href="downFIC.php">Scarica fatture da FIC</a>
    <a class="reg-right" href="uploadPDF.php">Carica fatture</a>

    <meta name="viewport" content="width=device-width, initial-scale=1">
  </div>

<div class="widget-box widget-position"><br>
    <div class="div-filterfull">
        <div class="div-filter1">
          <h2>Stato</h2>
          <label class="container">
            <input type="checkbox" id="daregistrare" checked="true">Da registrare
            <span class="checkmark"></span>
          </label>
          <label class="container">
            <input type="checkbox" id="nuovo" checked="true">Nuovo
            <span class="checkmark"></span>
          </label>
          <label class="container">
            <input type="checkbox" id="registrato" checked="true">Registrato
            <span class="checkmark"></span>
          </label>
          <label class="container">
            <input type="checkbox" id="rifiutato" checked="true">Rifiutato
            <span class="checkmark"></span>
          </label>
          <label class="container">
            <input type="checkbox" id="contabilizzato" checked="true">Contabilizzato
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="div-filter2">
          <br><br><br><br>
          Ditta: <select name="ditta" id="ditta">
            <?php
              retrieveDitteForDropdown();
            ?>
         </select>
          <br><br>
          <label>Controparte:</label> <input id="controparte" placeholder="Controparte" title="Controparte" type="text">
          <br><br>
         <label>Causale:</label> <input id="causale" placeholder="Causale" title="Causale" type="text">
        </div>
        <div class="div-filter3">
          <br><br><br><br>
          <label>Numero:</label> <input id="numero" placeholder="Numero" title="Numero" type="text">
          <br><br>
          <label>Protocollo:</label> <input id="protocollo" placeholder="Protocollo" title="Protocollo" type="text">
          <br><br>
          <label>Data da:</label> <input id="datada" type="date">
          <br><br>
          <label>Data a:</label> <input id="dataa" type="date">
        </div>
        <input type="submit" value="Filtra" class="submitbtn" onclick="filtra()">
        <input type="submit" value="Reset" class="resetbtn" onclick="reset()">
    </div>
</div>

  <table id="tableFatture">
    <tr>
      <th style="display:none;">Codice Ditta</th>
      <th>Ditta</th>
      <th>Data caricamento</th>
      <th>Causale</th>
      <th>Data documento</th>
      <th>Numero fatt.</th>
      <th>Protocollo</th>
      <th>Controparte</th>
      <th>Totale</th>
      <th>Stato</th>
      <th></th>
      <th></th>
    </tr>
    <?php
      creaRigaFatt();
    ?>
  </table>
</div>
</div>
<a href="#top">Top</a>
</body>
<script>
//script per filtri
  function filtra() {
    var input, filter, table, tr, td, i;
    table = document.getElementById("tableFatture");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
    //azzera la riga e ottiene i campi
      tr[i].style.display = "";
      td = tr[i].getElementsByTagName("td");
    //filtra in base alla Ditta
      input = document.getElementById("ditta");
      filter = input.value.toUpperCase();
      if (td[0].innerHTML.toUpperCase() != filter && filter != ""){
        tr[i].style.display = "none";
      }
    //filtra in base alla controparte
      input = document.getElementById("controparte");
      filter = input.value.toUpperCase();
      if (td[7].innerHTML.toUpperCase().indexOf(filter) == -1 && filter != ""){
        tr[i].style.display = "none";
      }
    //filtra in base alla Causale
      input = document.getElementById("causale");
      filter = input.value.toUpperCase();
      if (td[3].innerHTML.toUpperCase() != filter && filter != ""){
        tr[i].style.display = "none";
      }
    //filtra in base al Protocollo
      input = document.getElementById("protocollo");
      filter = input.value.toUpperCase();
      if (td[6].innerHTML.toUpperCase() != filter && filter != ""){
        tr[i].style.display = "none";
      }
    //filtra in base al numero
      input = document.getElementById("numero");
      filter = input.value.toUpperCase();
      if (td[5].innerHTML.toUpperCase().indexOf(filter) == -1 && filter != ""){
        tr[i].style.display = "none";
      }
    //filtra in base allo stato
      //Da registrare
      filter = document.getElementById("daregistrare").checked;
    }
  }
//script per resettare i filtri
  function reset() {
    document.getElementById("daregistrare").checked = true;
    document.getElementById("nuovo").checked = true;
    document.getElementById("registrato").checked = true;
    document.getElementById("rifiutato").checked = true;
    document.getElementById("contabilizzato").checked = true;
    document.getElementById("ditta").value = "";
    document.getElementById("controparte").value = "";
    document.getElementById("causale").value = "";
    document.getElementById("controparte").value = "";
    document.getElementById("numero").value = "";
    document.getElementById("protocollo").value = "";
    document.getElementById("datada").value = "";
    document.getElementById("dataa").value = "";
    this.filtra();
  }
</script>
</html>
