<?php

define('servername', 'localhost');
define('username', 'root');
define('password', 'root');
define('dbname', 'AIC');
/* PER DEBUG */
ini_set('display_errors', 'On');
error_reporting(E_ALL);


  /*FUNZIONI PER LE STRINGHE*/
  function left($str,$len){
    return substr($str, 0, $len);
  }
  function right($str,$len){
    $len=$len*-1;
    return substr($str, $len);
  }
  function spaces($num){
    return str_repeat(' ', $num);
  }
  function sign($num){
    switch ($num) {
      case $num > 0:
        return "+";
        break;
      case $num < 0:
        return "-";
        break;
      case $num = 0:
        return " ";
        break;
    }
  }
  /* / FUNZIONI PER LE STRINGHE*/

  function creaRigaFatt() {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT *
    FROM fatture
    JOIN ditte on fatture.ditta = ditte.codiceDitta
    LEFT JOIN controparti on fatture.controparte = controparti.idControp
    ORDER BY fatture.idFatt DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          print("<tr>");  /*inizio riga*/
          print("<td style=\"display:none\">".$row["ditta"]."</td>");
          print("<td>".$row["nomeDitta"]."</td>"); /* ditta */
          if ($row["dataCaric"]) {
            $sqlDate = strtotime($row["dataCaric"]);  /*rende il formato */
            $formatDate = date("d/m/Y", $sqlDate);   /*della data normale*/
            print("<td>".$formatDate."</td>"); /* data caricamento */
          } else {
            print("<td></td>");
          }
          print("<td>".$row["causale"]."</td>"); /* causale documento */
          if ($row["dataFatt"]) {
            $sqlDate = strtotime($row["dataFatt"]);   /*rende il formato */
            $formatDate = date("d/m/Y", $sqlDate);   /*della data normale*/
            print("<td>".$formatDate."</td>"); /* data documento */
          } else {
            print("<td></td>");
          }
          print("<td>".$row["nFatt"]."</td>"); /* numero fattura */
          print("<td>".$row["nProtocollo"]."</td>"); /* protocollo */
          if ($row["personaFisica"]) {
            print("<td>".$row["nomeControp"]." ".$row["cognControp"]."</td>");  /* controparte nome cognome*/
          } else {
            print("<td>".$row["ragSocControp"]."</td>");  /* controparte ragSoc*/
          }
          if ($row["totFatt"]) {
            print("<td>".$row["totFatt"]."€</td>");  /* totale */
          } else {
            print("<td></td>");  /* totale */
          }
          switch ($row["stato"]) {  /* icona di stato */
            case "Da registrare": {
              print("<td class=\"text-center\" style=\"width: 30px;\">");
                print("<i class=\"orange fa fa-circle\"></i> Da registrare");
              print("</td>");
              print("<td style=\"width: 50px;\">");  /* icona modifica/visualizza */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-pencil bigger-120\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              print("<td>");
              print("</td>");
              break;
            }
            case "Nuovo": {
              print("<td class=\"text-center\" style=\"width: 30px;\">");
                print("<i class=\"fa fa-circle\" style=\"color: blue;\"></i> Nuovo");
              print("</td>");
              print("<td style=\"width: 50px;\">");  /* icona modifica/visualizza */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-pencil bigger-120\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              print("<td>");
              print("</td>");
              break;
            }
            case "Registrato": {
              print("<td class=\"text-center\" style=\"width: 30px;\">");
                print("<i class=\"green fa fa-check\"></i> Registrato");
              print("</td>");
              print("<td style=\"width: 50px;\">");  /* icona modifica/visualizza */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-search\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              print("<td style=\"width: 20px;\">");  /* icona undo */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-undo\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              break;
            }
            case "Rifiutato": {
              print("<td class=\"text-center\" style=\"width: 30px;\">");
                print("<i class=\"red fa fa-times\"></i> Rifiutato");
              print("</td>");
              print("<td style=\"width: 50px;\">");  /* icona modifica/visualizza */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-search\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              print("<td style=\"width: 20px;\">");  /* icona undo */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-undo\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              break;
            }
            case "Contabilizzato": {
              print("<td class=\"text-center\" style=\"width: 30px;\">");
                print("<i class=\"fa fa-archive\"></i> Contabilizzato");
              print("</td>");
              print("<td style=\"width: 50px;\">");  /* icona modifica/visualizza */
                print("<div style=\"display: inline-block; min-width: 32px;\">");
                  print("<a class=\"btn btn-xs btn-info\" data-toggle=\"tooltip\" data-placement=\"top\" data-title=\"Modifica\" href=\"/acquistiincloud/workarea.php?idDoc=".$row["idFatt"]."&ditta=".$row["ditta"]."\">");
                    print("<i class=\"ace-icon fa fa-search\"></i>");
                  print("</a>");
                print("</div>");
              print("</td>");
              print("<td>");
              print("</td>");
              break;
            }
          }
          print("</tr>");
        }
    } else {
        echo "0 results";
    }
    $conn->close();
  }

  function uploadPDF() {
    if (isset($_POST['submit'])) {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //filtra i file prelevati
    $files = array_filter($_FILES['upload']['tmp_name']);

    foreach ($files as $file) {
      // Inserisce una nuova riga per fattura nel DB
      $sql = "INSERT INTO fatture (ditta, stato)
              VALUES (".$_POST["ditta"].", \"Nuovo\")";
      $result = $conn->query($sql);
      $result = $conn->query("SELECT LAST_INSERT_ID()"); //ottiene l'ID dell'ultima fattura
      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            // inserisce il file nella cartella corretta
            if ($file) {
              move_uploaded_file($file, "documents/".$_POST["ditta"]."/".$row["LAST_INSERT_ID()"].".pdf");
            }
          }
      } else {
        print("errore");
      }
    }
    $conn->close();
    header("location: /acquistiincloud/docs.php");
    }
  }

  function retrieveDitteForDropdown() {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT nomeDitta, codiceDitta
            FROM ditte";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        print("<option></option>");
        while($row = $result->fetch_assoc()) {
          // crea una riga per ogni ditta
          print("<option value=\"".$row["codiceDitta"]."\">".$row["nomeDitta"]."</option>");
        }
    }
    $conn->close();
  }

  function registraFatt() {

    if (isset($_POST['submit'])) {
    /* I N S E R I R E
    COME VARIABILE PASSATA A FUNZIONE
    R E G I S T R A  F A T T */
    $dataReg = "31/01/2018";


    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM fatture
            JOIN ditte on fatture.ditta = ditte.codiceDitta
            JOIN controparti on fatture.controparte = controparti.idControp
            JOIN ditteSez on fatture.sezionale = ditteSez.idSez
            WHERE fatture.stato = \"Registrato\"
            ORDER BY dataFatt";
    $result = $conn->query($sql);
    $TRAF2000 = "";
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $TRAF2000 .= right("00000".$row["ditta"],5);
        $TRAF2000 .= "30";
        //D A T I  C L I F O R
        $TRAF2000 .= "00000";
        if ($row["personaFisica"]) {
          $TRAF2000 .= left($row["cognControp"]." ".$row["nomeControp"].spaces(32),32);
        } else {
          $TRAF2000 .= left($row["ragSocControp"].spaces(32),32);
        }
        $TRAF2000 .= left($row["via"]." ".$row["nCivico"].spaces(30),30);
        $TRAF2000 .= left($row["CAP"].spaces(5),5);
        $TRAF2000 .= left($row["città"].spaces(25),25);
        $TRAF2000 .= left($row["prov"].spaces(2),2);
        $TRAF2000 .= left($row["codFisc"].spaces(16),16);
        $TRAF2000 .= left($row["pIva"].spaces(11),11);
        if ($row["personaFisica"]) {
          $TRAF2000 .= "S";
          $TRAF2000 .= right("00".strlen($row["cognome"])+1,2);
        } else {
          $TRAF2000 .= "N";
          $TRAF2000 .= "00";
        }
        $TRAF2000 .= spaces(131);
        //D A T I  F A T T U R A
        $TRAF2000 .= right("000".$row["causale"],3);
        $TRAF2000 .= spaces(101);
          $sqlDate = strtotime($dataReg);         /*  rende il formato  */
          $formatDate = date("dmY", $sqlDate);   /*della data richiesto*/
        $TRAF2000 .= $formatDate;
          $sqlDate = strtotime($row["dataFatt"]); /*  rende il formato  */
          $formatDate = date("dmY", $sqlDate);   /*della data richiesto*/
        $TRAF2000 .= $formatDate;
        $TRAF2000 .= left($row["nFatt"].spaces(8),8);
          $protocollo = $row["ultimoProt"] + 1;
          $sql = "UPDATE fatture
                  SET nProtocollo = ".$protocollo."
                  WHERE idFatt = ".$row["idFatt"];
          $conn->query($sql); //assegna il protocollo alla fattura
          $sql = "UPDATE ditteSez
                  SET ultimoProt = ".$protocollo."
                  WHERE idSez = ".$row["idSez"];
          $conn->query($sql); //aggiorna l'ultimo protocollo del sez.
        $TRAF2000 .= right(str_repeat('0',5).$protocollo,5);
        $TRAF2000 .= right(str_repeat('0',2).$row["codSezionale"],2);
        $TRAF2000 .= spaces(72);
        //D A T I  I V A
        for ($i = 1; $i <= 8; $i++) { //crea una riga per ognuna delle 8 righe di fatture
          if ($row["imponibile[$i]"]) {
            $TRAF2000 .= right("00000000000".abs($row["imponibile[$i]"] * 100),11);
            $TRAF2000 .= sign($row["imponibile[$i]"]);
            $TRAF2000 .= right("000".$row["aliquota_iva[$i]"],3);
            $TRAF2000 .= spaces(3);
            $TRAF2000 .= right("00".$row["iva11[$i]"],2);
            $TRAF2000 .= right("00000000000".abs($row["imposta[$i]"] * 100),11);
            $TRAF2000 .= sign($row["imposta[$i]"]);
          } else {
            $TRAF2000 .= spaces(31);
          }
        }
        //T O T A L E  F A T T U R A
        $TRAF2000 .= right("000000000000".abs($row["totFatt"] * 100),12);
        //C O N T I  C O S T O / R I C A V O
        for ($i = 1; $i <= 8; $i++) { //crea una riga per ognuna delle 8 righe di fatture
          if ($row["conto[$i]"]) {
            $TRAF2000 .= right("0000000".$row["conto[$i]"],7);
            $TRAF2000 .= right("000000000000".abs($row["importo_conto[$i]"] * 100),12);
          } else {
            $TRAF2000 .= spaces(19);
          }
        }
        $TRAF2000 .= "\n";
        $sql = "UPDATE fatture
                SET stato = \"Contabilizzato\"
                WHERE idFatt = ".$row["idFatt"];
        $conn->query($sql); //modifica lo stato della fattura
      }
    } else {
//    print("<script>window.alert(\"Nessun documento da contabilizzare\")</script>");
    }
    $file = fopen("TRAF2000", "w");
    fwrite($file, $TRAF2000);
    fclose($file);
    $conn->close();
    }
  }

  function downloadFromFIC() {
    if (isset($_POST['submit'])) {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM ditte WHERE codiceDitta = ".$_POST["ditta"];
    $resultSQL = $conn->query($sql);
    if ($resultSQL->num_rows > 0) {
      // output data of each row
      while($row = $resultSQL->fetch_assoc()) {
        if ($row["apiUid"]) {
           $url = "https://api.fattureincloud.it/v1/acquisti/lista";
           $request = array("api_uid" => $row["apiUid"], "api_key" => $row["apiKey"], "anno" => "2018", "mostra_link_allegato" => "true");
           $options = array(
               "http" => array(
                   "header"  => "Content-type: text/json\r\n",
                   "method"  => "POST",
                   "content" => json_encode($request)
               ),
           );
           $context  = stream_context_create($options);
           $resultJSON = json_decode(file_get_contents($url, false, $context), true);
           if ($resultJSON["success"]) {
             //filtra i documenti prelevati
             $fatture = array_filter($resultJSON["lista_documenti"]);
             foreach ($fatture as $doc) {
               // Inserisce una nuova riga per fattura nel DB
               $anagrafica = APIFornitori($row["apiUid"], $row["apiKey"], $doc["id_fornitore"]);
               $sql = "INSERT INTO fatture (ditta, stato, dataFatt, totFatt, nFatt, controparte, idFIC)
                      SELECT * FROM (SELECT ".$_POST["ditta"].", \"Nuovo\", STR_TO_DATE(".sqler($doc['data']).", \"%d/%m/%Y\"), ".sqler($doc["importo_totale"]).", ".sqler($doc["descrizione"]).",
                      (SELECT idControp FROM controparti WHERE pIva = ".sqler($anagrafica["piva"])." OR codFisc = ".sqler($anagrafica["cf"])." OR ragSocControp = ".sqler($anagrafica["nome"]).")
                      ,".sqler($doc["id"]).") AS tmp
                      WHERE NOT EXISTS (SELECT idFIC FROM fatture WHERE idFIC = ".$doc["id"].")";
               $result = $conn->query($sql);
               error_log($sql);
               if (mysqli_affected_rows($conn)) {
                 $result = $conn->query("SELECT LAST_INSERT_ID()"); //ottiene l'ID dell'ultima fattura
                 if ($result->num_rows > 0) {
                     // output data of each row
                     while($row = $result->fetch_assoc()) {
                       // inserisce il file nella cartella corretta
                       copy($doc["link_allegato"], "documents/".$_POST["ditta"]."/".$row["LAST_INSERT_ID()"].".pdf");
                     }
                 } else {
                   print("errore");
                 }
               }
             }
           }
        }
      }
    } else {
      print("errore");
    }
    $conn->close();
    header("location: /acquistiincloud/docs.php");
   }
  }

  function APIFornitori($APIuid, $APIkey, $idFornitore) {
    $url = "https://api.fattureincloud.it:443/v1/fornitori/lista";
    $request = array("api_uid" => $APIuid, "api_key" => $APIkey, "id" => $idFornitore);
    $options = array(
        "http" => array(
            "header"  => "Content-type: text/json\r\n",
            "method"  => "POST",
            "content" => json_encode($request)
        ),
    );
    $context  = stream_context_create($options);
    $resultJSON = json_decode(file_get_contents($url, false, $context), true);
    if ($resultJSON["success"]) {
      //filtra i documenti prelevati
      $anagrafica = array_filter($resultJSON["lista_fornitori"][0]);
      // Create connection
      $conn = new mysqli(servername, username, password, dbname);
      // Check connection
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      }
      $sql = "INSERT INTO controparti (ragSocControp, codFisc, pIva, via, CAP, citta, prov)
              SELECT ".sqler($anagrafica["nome"]).", ".sqler($anagrafica["cf"]).", ".sqler($anagrafica["piva"]).",
              ".sqler($anagrafica["indirizzo_via"]).", ".sqler($anagrafica["indirizzo_cap"]).", ".sqler($anagrafica["indirizzo_citta"]).", ".sqler($anagrafica["indirizzo_provincia"])."
              FROM controparti
              WHERE NOT EXISTS (SELECT idControp FROM controparti WHERE pIva = \"".$anagrafica["piva"]."\" OR codFisc = \"".$anagrafica["cf"]."\" OR ragSocControp = \"".$anagrafica["nome"]."\")";
      $result = $conn->query($sql);
      error_log($sql);
      return $anagrafica;
    }
  }

  function loadWorkArea($docID) {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM fatture
            JOIN ditte on fatture.ditta = ditte.codiceDitta
            LEFT JOIN controparti on fatture.controparte = controparti.idControp
            LEFT JOIN ditteSez on fatture.sezionale = ditteSez.idSez
            WHERE fatture.idFatt = $docID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo("
          <div class=\"div-fatt\">
            <div class=\"div-pdffatt\">
              <iframe src=\"documents/".$row["codiceDitta"]."/".$row["idFatt"].".pdf\"class=\"pdfstyle\"></iframe>
            </div>
            <div class=\"div-datifatt\">
              <form action=\"\" method=\"POST\" id=\"formFatt\">
                <h3>Dati Generici</h3>
                Nr. doc: <input name=\"ndoc\" id=\"ndoc\" type=\"text\" autocomplete=\"off\" placeholder=\"Numero documento\" value=\"".$row["nFatt"]."\">
                Data doc: <input name=\"datadoc\" id=\"datadoc\" type=\"date\" autocomplete=\"off\" placeholder=\"Data documento\" value=".$row["dataFatt"].">
                <input name=\"idDoc\" type=\"hidden\" value=\"".$_GET["idDoc"]."\">
                <input name=\"ditta\" type=\"hidden\" value=\"".$_GET["ditta"]."\">
                <br>
                <hr>
                <h3>Fornitore</h3>
                <input name=\"persFis\" id=\"persFis\" type=\"hidden\" value=".$row["personaFisica"].">
                C.F.: <input name=\"cf\" id=\"cf\" type=\"text\" autocomplete=\"off\" placeholder=\"Codice Fiscale\" value=\"".$row["codFisc"]."\">
                P.IVA: <input name=\"piva\" id=\"piva\" type=\"text\" autocomplete=\"off\" placeholder=\"Partita IVA\" value=\"".$row["pIva"]."\">
                <br><br>
                <div id=\"personaFisica\" class=\"div-inline\">
                  Nome: <input name=\"nome\" id=\"nome\" type=\"text\" autocomplete=\"off\" placeholder=\"Nome\" value=\"".$row["nomeControp"]."\">
                  Cognome: <input name=\"cognome\" id=\"cognome\" type=\"text\" autocomplete=\"off\" placeholder=\"Cognome\" value=\"".$row["cognControp"]."\">
                  <br>
                </div>
                <div id=\"societa\" class=\"div-inline\">
                  Ragione sociale: <input name=\"ragsoc\" id=\"ragsoc\" type=\"text\" autocomplete=\"off\" placeholder=\"Ragione Sociale\" size=33 value=\"".$row["ragSocControp"]."\">
                </div>
                <br><br>
                Indirizzo: <input name=\"via\" id=\"via\" type=\"text\" autocomplete=\"off\" placeholder=\"Indirizzo\" value=\"".$row["via"]."\">
                <input name=\"nCivico\" id=\"nCivico\" type=\"text\" autocomplete=\"off\" size=\"6\" placeholder=\"Civico\" value=\"".$row["nCivico"]."\">
                CAP / Città: <input name=\"cap\" id=\"cap\" type=\"text\" autocomplete=\"off\" size=\"6\" placeholder=\"CAP\" value=\"".$row["CAP"]."\">
                <input name=\"citta\" id=\"citta\" type=\"text\" autocomplete=\"off\" placeholder=\"Città\" value=\"".$row["citta"]."\">
                Provincia: <input name=\"provincia\" id=\"provincia\" type=\"text\" autocomplete=\"off\" size=\"3\" placeholder=\"Provincia\" value=\"".$row["prov"]."\">
                <br>
                <hr>
                <h3>Dati contabili</h3>
                Totale: <input name=\"totFatt\" id=\"totFatt\" type=\"text\" autocomplete=\"off\" onfocusout=\"trascriviTotFatt()\" placeholder=\"Importo totale\" value=\"".$row["totFatt"]."\">
                Ritenuta d'acconto: <input name=\"ritAcc\" id=\"ritAcc\" type=\"text\" autocomplete=\"off\" placeholder=\"Ritenuta d'acconto\" value=\"".$row["importo_rit"]."\">
                <br><br>
                Causale: <input name=\"causale\" id=\"causale\" type=\"text\" autocomplete=\"off\" size=\"4\" placeholder=\"Caus.\" value=\"".$row["causale"]."\">
                Sezionale: <input name=\"sezionale\" id=\"sezionale\" type=\"text\" autocomplete=\"off\" size=\"4\" placeholder=\"Sez.\" value=\"".$row["codSezionale"]."\">
                            <a class=\"btnpopup\" href=\"#popupSez\"><i class=\"ace-icon fa fa-search\"></i></a>
                <br><br>
                <table>
                  <tr>
                    <th>Sottoconto</th>
                    <th>Imponibile</th>
                    <th>IVA</th>
                    <th>IVA11</th>
                    <th>Imposta</th>
                    <th></th>
                  </tr>
                  ");
                  for ($i = 1; $i <= 5; $i++) {
                    print("
                    <tr>
                    <td><input name=\"sottoconto_$i\" id=\"sottoconto_$i\" type=\"text\" autocomplete=\"off\" size=\"10\" value=\"".$row["conto_$i"]."\">
                       <a class=\"btnpopup\" href=\"#popupConto\" onclick=\"setRiga($i)\">
                       <i class=\"ace-icon fa fa-search\"></i>
                     </a>
                    </td>
                    <td><input name=\"imponibile_$i\" id=\"imponibile_$i\" type=\"text\" autocomplete=\"off\" size=\"10\" value=\"".$row["imponibile_$i"]."\"></td>
                    <td><input name=\"iva_$i\" id=\"iva_$i\" type=\"text\" autocomplete=\"off\" size=\"5\" value=\"".$row["aliquota_iva_$i"]."\">
                       <a class=\"btnpopup\" href=\"#popupIva\" onclick=\"setRiga($i)\">
                       <i class=\"ace-icon fa fa-search\"></i>
                     </a>
                    </td>
                    <td><input name=\"iva11_$i\" id=\"iva11_$i\" type=\"text\" autocomplete=\"off\" size=\"5\" value=\"".$row["iva11_$i"]."\"></td>
                    <td><input name=\"imposta_$i\" id=\"imposta_$i\" type=\"text\" autocomplete=\"off\" size=\"10\" value=\"".$row["imposta_$i"]."\"></td>
                    <td style=\"width: 35px;\">
                      <div style=\"display: inline-block; min-width: 32px;\" id=\"S_$i\">
                        <a class=\"btn\"data-toggle=\"tooltip\" data-placement=\"top\">
                          <i>S</i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  ");
                  }
                print("</table>
                <br>
                <div id=\"subapprfatt\">
                  <input name\"savefatt\" id=\"savefatt\" type=\"submit\" formaction=\"salva.php\" value=\"Salva\">
                  <input name\"apprfatt\" id=\"apprfatt\" type=\"submit\" formaction=\"approva.php\" value=\"Approva\">
                </div>
                </form>
                </div>
                </div>
                ");

        }
    } else {
      print("<h1>La fattura non esiste</h1>");
    }
    $conn->close();



  }

  function sottocontiToTable() {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM sottoconti";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          print(
              "<tr>
                <td>".$row["sottoconto"]."</td>
                <td>".$row["descrizione"]."</td>
                <td><a class=\"btnpopup\" onclick=\"cambiaSottoconto('".$row["sottoconto"]."')\"><i class=\"ace-icon fa fa-arrow-right\"></i></a></td>
              </tr>"
          );
        }
    }
    $conn->close();
  }

  function IVAToTable() {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM iva";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          print(
              "<tr>
                <td>".$row["codiceIva"]."</td>
                <td>".$row["descrizione"]."</td>
                <td><a class=\"btnpopup\" onclick=\"cambiaIVA('".$row["codiceIva"]."')\"><i class=\"ace-icon fa fa-arrow-right\"></i></a></td>
              </tr>"
          );
        }
    }
    $conn->close();
  }

  function sezionaliToTable($ditta) {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM ditteSez
            WHERE codDitta = ".$ditta;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          print(
              "<tr>
                <td>".$row["codSezionale"]."</td>
                <td>".$row["descrizioneSez"]."</td>
                <td><a class=\"btnpopup\" onclick=\"cambiaSez(".$row["codSezionale"].")\"><i class=\"ace-icon fa fa-arrow-right\"></i></a></td>
              </tr>"
          );
        }
    }
    $conn->close();
  }

  function sqler($d) {
    if ($d == "") {
      return "NULL";
    } else {
      return "\"$d\"";
    }
  }

  function salvaFatt() {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // AGGIORNAMENTO FATTURA IN SQL
    $sql = "INSERT INTO controparti (personaFisica, ragSocControp, nomeControp, cognControp, codFisc, pIva, via, nCivico, CAP, citta, prov)
            SELECT ".sqler($_POST["persFis"]).", ".sqler($_POST["ragsoc"]).", ".sqler($_POST["nome"]).", ".sqler($_POST["cognome"]).", ".sqler($_POST["cf"]).",
                    ".sqler($_POST["piva"]).", ".sqler($_POST["via"]).", ".sqler($_POST["nCivico"]).", ".sqler($_POST["cap"]).", ".sqler($_POST["citta"]).", ".sqler($_POST["provincia"])."
            FROM controparti
            WHERE NOT EXISTS (SELECT idControp FROM controparti WHERE pIva = \"".$_POST["piva"]."\" OR codFisc = \"".$_POST["cf"]."\" OR ragSocControp = \"".$_POST["ragsoc"]."\" OR nomeControp = \"".$_POST["nome"]."\" OR cognControp = \"".$_POST["cognome"]."\");
            UPDATE fatture
            SET totFatt = ".sqler($_POST["totFatt"]).",
            nFatt = ".sqler($_POST["ndoc"]).",
            causale = ".sqler($_POST["causale"]).",
            controparte = (SELECT idControp FROM controparti WHERE pIva = \"".$_POST["piva"]."\" OR codFisc = \"".$_POST["cf"]."\" OR ragSocControp = \"".$_POST["ragsoc"]."\" OR nomeControp = \"".$_POST["nome"]."\" OR cognControp = \"".$_POST["cognome"]."\"),
            sezionale = (SELECT idSez FROM ditteSez WHERE codSezionale = ".sqler($_POST["sezionale"])." AND codDitta = ".$_POST["ditta"]."),
            importo_rit = ".sqler($_POST["ritAcc"]).",
            dataFatt = ".sqler($_POST["datadoc"]).",\n";
            for ($i = 1; $i <= 5; $i++) {
            //aggiorna i sottoconti
                $sql .= "conto_$i = ".sqler($_POST["sottoconto_$i"]).",\n";
            //aggiorna gli imponibili
                $sql .= "imponibile_$i = ".sqler($_POST["imponibile_$i"]).",\n";
            //aggiorna le aliquote iva
                $sql .= "aliquota_iva_$i = ".sqler($_POST["iva_$i"]).",\n";
            //aggiorna le iva 11
                $sql .= "iva11_$i = ".sqler($_POST["iva11_$i"]).",\n";
            //aggiorna le imposte
                $sql .= "imposta_$i = ".sqler($_POST["imposta_$i"]).",\n";
            }
    $sql .= "stato = \"Da registrare\"
            WHERE idFatt = ".$_POST["idDoc"];
    $result = $conn->multi_query($sql);

    error_log($sql);
    $conn->close();
    header("location: /acquistiincloud/docs.php");
  }

  function approvaFatt() {
    // Create connection
    $conn = new mysqli(servername, username, password, dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // AGGIORNAMENTO FATTURA IN SQL
    $sql = "INSERT INTO controparti (personaFisica, ragSocControp, nomeControp, cognControp, codFisc, pIva, via, nCivico, CAP, citta, prov)
            SELECT ".sqler($_POST["persFis"]).", ".sqler($_POST["ragsoc"]).", ".sqler($_POST["nome"]).", ".sqler($_POST["cognome"]).", ".sqler($_POST["cf"]).",
                    ".sqler($_POST["piva"]).", ".sqler($_POST["via"]).", ".sqler($_POST["nCivico"]).", ".sqler($_POST["cap"]).", ".sqler($_POST["citta"]).", ".sqler($_POST["provincia"])."
            FROM controparti
            WHERE NOT EXISTS (SELECT idControp FROM controparti WHERE pIva = \"".$_POST["piva"]."\" OR codFisc = \"".$_POST["cf"]."\" OR ragSocControp = \"".$_POST["ragsoc"]."\" OR nomeControp = \"".$_POST["nome"]."\" OR cognControp = \"".$_POST["cognome"]."\");
            UPDATE fatture
            SET totFatt = ".sqler($_POST["totFatt"]).",
            nFatt = ".sqler($_POST["ndoc"]).",
            causale = ".sqler($_POST["causale"]).",
            controparte = (SELECT idControp FROM controparti WHERE pIva = \"".$_POST["piva"]."\" OR codFisc = \"".$_POST["cf"]."\" OR ragSocControp = \"".$_POST["ragsoc"]."\" OR nomeControp = \"".$_POST["nome"]."\" OR cognControp = \"".$_POST["cognome"]."\"),
            sezionale = (SELECT idSez FROM ditteSez WHERE codSezionale = ".sqler($_POST["sezionale"])." AND codDitta = ".$_POST["ditta"]."),
            importo_rit = ".sqler($_POST["ritAcc"]).",
            dataFatt = ".sqler($_POST["datadoc"]).",\n";
            for ($i = 1; $i <= 5; $i++) {
            //aggiorna i sottoconti
                $sql .= "conto_$i = ".sqler($_POST["sottoconto_$i"]).",\n";
            //aggiorna gli imponibili
                $sql .= "imponibile_$i = ".sqler($_POST["imponibile_$i"]).",\n";
            //aggiorna le aliquote iva
                $sql .= "aliquota_iva_$i = ".sqler($_POST["iva_$i"]).",\n";
            //aggiorna le iva 11
                $sql .= "iva11_$i = ".sqler($_POST["iva11_$i"]).",\n";
            //aggiorna le imposte
                $sql .= "imposta_$i = ".sqler($_POST["imposta_$i"]).",\n";
            }
    $sql .= "stato = \"Registrato\"
            WHERE idFatt = ".$_POST["idDoc"];
    $result = $conn->multi_query($sql);
    error_log($sql);
    $conn->close();
    header("location: /acquistiincloud/docs.php");
  }

function navbar() {
  print('
  <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="margin-bottom: 20px;">
    <a class="navbar-brand" href="docs.php">
      <img src="images/favicon.png" href="docs.php" width="30" height="30" class="d-inline-block align-top" alt="">
      Acquisti in Cloud
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item" id="navbar-uploadPDF">
          <a class="nav-link" href="uploadPDF.php">Carica Fatture<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item" id="navbar-downFIC">
          <a class="nav-link" href="downFIC.php">Scarica Fatture da FIC</a>
        </li>
        <li class="nav-item" id="navbar-registra">
          <a class="nav-link" href="registra.php">Registra</a>
        </li>
      </ul>
    </div>
  </nav>');
}

function footer(){
  print('
<!--Footer-->
<footer class="page-footer font-small blue pt-4 mt-4">

    <!--Footer Links-->
    <div class="container-fluid text-center text-md-left">
        <div class="row">

            <!--First column-->
            <div class="col-md-6">
                <h5 class="text-uppercase">Footer Content</h5>
                <p>Here you can use rows and columns here to organize your footer content.</p>
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-6">
                <h5 class="text-uppercase">Links</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Link 1</a>
                    </li>
                    <li>
                        <a href="#!">Link 2</a>
                    </li>
                    <li>
                        <a href="#!">Link 3</a>
                    </li>
                    <li>
                        <a href="#!">Link 4</a>
                    </li>
                </ul>
            </div>
            <!--/.Second column-->
        </div>
    </div>
    <!--/.Footer Links-->

    <!--Copyright-->
    <div class="footer-copyright py-3 text-center">
        © 2018 Copyright:
        <a href="https://mdbootstrap.com/material-design-for-bootstrap/"> MDBootstrap.com </a>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->
                      ');
}
?>
