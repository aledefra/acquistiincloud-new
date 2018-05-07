jQuery(document).ready(function(){

  $("#file").on("change", function(){

    var files = $(this)[0].files;

    if(files.length >= 2){

      $("#label_span").text(files.length + " files ready to upload");

    } else {

      var filename = e.target.value.split('\\').pop();
      $("#label_span").text(filename);

    }

  });

});

//workarea
function controllaCF() {
  // Definisco un pattern per il confronto
  var pattern = /^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$/;

  // creo una variabile per richiamare con facilità il nostro campo di input
  var CodiceFiscale = document.getElementById("cf");

  // utilizzo il metodo search per verificare che il valore inserito nel campo
  // di input rispetti la stringa di verifica (pattern)
  if (CodiceFiscale.value.search(pattern) == -1)
  {
    // In caso di errore stampo un avviso e pulisco il campo...
    alert("Il valore inserito non è un codice fiscale!");
    CodiceFiscale.value = "";
    CodiceFiscale.focus();
  }else{
     // ...in caso contrario stampo un avviso di successo!
     alert("Il codice fiscale è corretto!");
  }
}
var focus = 0,
  blur = 0;
$( "input[name='cf']" )
  .focusout(function() {
    if (CodiceFiscale.value.search(pattern) == -1)
    {
      // In caso di errore stampo un avviso e pulisco il campo...

      CodiceFiscale.value = "";
      CodiceFiscale.focus();
    }else{
       // ...in caso contrario stampo un avviso di successo!
       alert("Il codice fiscale è corretto!");
    }



  })
function showragsoc() {
  if (isNaN(document.getElementById("cf")))
  {
    var nome = document.createElement("input");
    nome.setAttribute('type', 'text')
  }
}
