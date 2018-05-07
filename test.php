<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<script>

    function ControllaCF(cf) {
        if (cf.length < 12) {
            return ControllaPIVA(cf)
        } else {
        var validi, i, s, set1, set2, setpari, setdisp;
        if (cf == '') return '';
        cf = cf.toUpperCase();
        if (cf.length != 16)
            return "La lunghezza del codice fiscale non è\n"
            + "corretta: il codice fiscale dovrebbe essere lungo\n"
            + "esattamente 16 caratteri.\n";
        validi = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (i = 0; i < 16; i++) {
            if (validi.indexOf(cf.charAt(i)) == -1)
                return "Il codice fiscale contiene un carattere non valido `" +
                    cf.charAt(i) +
                    "'.\nI caratteri validi sono le lettere e le cifre.\n";
        }
        set1 = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        set2 = "ABCDEFGHIJABCDEFGHIJKLMNOPQRSTUVWXYZ";
        setpari = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        setdisp = "BAKPLCQDREVOSFTGUHMINJWZYX";
        s = 0;
        for (i = 1; i <= 13; i += 2)
            s += setpari.indexOf(set2.charAt(set1.indexOf(cf.charAt(i))));
        for (i = 0; i <= 14; i += 2)
            s += setdisp.indexOf(set2.charAt(set1.indexOf(cf.charAt(i))));
        if (s % 26 != cf.charCodeAt(15) - 'A'.charCodeAt(0))
            return "Il codice fiscale non ès corretto:\n" +
                "il codice di controllo non corrisponde.\n";
        return "";
        }
    }

    /*****************************************
        Controllo della Partita I.V.A.
        Linguaggio: JavaScript
    ******************************************/
    function ControllaPIVA(pi) {
        if (pi == '') return '';
        if (pi.length != 11)
            return "La lunghezza della partita IVA non è\n" +
                "corretta: la partita IVA dovrebbe essere lunga\n" +
                "esattamente 11 caratteri.\n";
        validi = "0123456789";
        for (i = 0; i < 11; i++) {
            if (validi.indexOf(pi.charAt(i)) == -1)
                return "La partita IVA contiene un carattere non valido `" +
                    pi.charAt(i) + "'.\nI caratteri validi sono le cifre.\n";
        }
        s = 0;
        for (i = 0; i <= 9; i += 2)
            s += pi.charCodeAt(i) - '0'.charCodeAt(0);
        for (i = 1; i <= 9; i += 2) {
            c = 2 * (pi.charCodeAt(i) - '0'.charCodeAt(0));
            if (c > 9) c = c - 9;
            s += c;
        }
        if ((10 - s % 10) % 10 != pi.charCodeAt(10) - '0'.charCodeAt(0))
            return "La partita IVA non è valida:\n" +
                "il codice di controllo non corrisponde.\n";
        return "";
    }


    jQuery.validator.addMethod("codicefiscale",
        function (value, element, param) {
            //aggiungere validazione client
            var ritorno = "";
            $(element).blur(ritorno = ControllaCF(value));
            if (ritorno == "") {
                return true;
            }
            else {
                return false;
            }
        });

    jQuery.validator.unobtrusive.adapters.add
        ("codicefiscale", [], function (options) {
            options.rules["codicefiscale"] = options.params;
            options.messages["codicefiscale"] = options.message;
        });

</script>
</body>
</html>
