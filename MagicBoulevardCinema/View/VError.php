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
    public static function error(int $num, string $descrizione = "")
    {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        if ($num != 0) {
            $smarty->assign("error_number", $num);
        }

        switch ($num) {
            case 0:
                $error_description = $descrizione;
                break;
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
                $error_description = "Estensione immagine non accettata";
                break;
            case 100:
            default:
                $error_description = "Errore generico.";
        }
        $smarty->assign("error_description", $error_description);

        $smarty->display("error.tpl");
    }
}