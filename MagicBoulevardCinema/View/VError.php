<?php

/**
 * La classe Error permette di visualizzare diverse schermate di errore.
 * Class VError
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VError
{
    /**
     * Funzione che permette di scegliere diverse possibili schermate di errore sulla base di un codice numerico.
     * @param int $num, numero di errore.
     * @param string $descrizione, nel caso in cui num sia 0 è possibile inserire un messaggio particolare da mostrare.
     * @throws SmartyException
     */
    public static function error(int $num, string $descrizione = "") {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        if ($num != 0) {
            $smarty->assign("error_number", $num);
        }

        switch ($num) {
            case 1:
                $error_description = "Errore nell'accesso al Database.";
                break;
            case 2:
                $error_description = "Errore nella scrittura sul database.";
                break;
            case 3:
                $error_description = "Pagina destinata agli amministratori.";
                break;
            case 4:
                $error_description = "Il tuo account è stato sospseso.";
                break;
            case 5:
                $error_description = "Utente non presente nel database.";
                break;
            case 6:
                $error_description = "Non si può accedere a questa pagina senza login.";
                break;
            case 7:
                $error_description = "Password non valida.";
                break;
            case 8:
                $error_description = "C'è stato un problema, riprova.";
                break;
            case 10:
                $error_description = "Estensione immagine non accettata.";
                break;
            case 11:
                $error_description = "La password è stata cambiata!";
                break;
            case 12:
                $error_description = "Posto non presente nella sala.";
                break;
            case 13:
                $error_description = "Almeno uno dei posti che voleva acquistare è stato già occupato. La invitiamo a riprovare!";
                break;
            case 14:
                $error_description = "Azione non valida";
                break;
            case 15:
                $error_description = "Un admin non può esprimere giudizi su un film.";
                break;
            case 16:
                $error_description = "Pagina destinata ad utenti non Registrati";
                break;
            case 17:
                $error_description = "Utente non trovato.";
                break;
            case 18:
                $error_description = "Richiedi di inviarti un nuovo link, questo potrebbe essere scaduto.";
                break;
            case 19:
                $error_description = "C'è stato un errore. Riprova più tardi.";
                break;
            case 20:
                $error_description = "Area riservata agli utenti <b>non registrati</b> presso il nostro portale";
                break;
            case 21:
                $error_description = "I diritti di scrittura in questa cartella ci impediscono di creare le configurazioni. Modificane i diritti e riprova.";
                break;
            case 22:
                $error_description = "Versione di PHP inferiore alla 7.4.0, AGGIORNARLA per poter proseguire! <br>";
                break;
            case 23:
                $error_description = "Cookie non abilitati! Per permetterci di funzionare abilitarli per favore! <br>";
                break;
            case 24:
                $error_description = "Esecuzione di codice JS non abilitata! Per permetterci di funzionare abilitalo per favore!";
                break;
            case 100:
            default:
                $error_description = "Errore generico.";
        }
        $smarty->assign("error_description", $error_description);

        $smarty->display("error.tpl");
    }
}