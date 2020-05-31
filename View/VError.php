<?php


class VError
{
    public static function error(int $num, string $descrizione = "")
    {
        $smarty = StartSmarty::configuration();

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
                $error_description = "Errore il tuo account è stato sospseso.";
                break;
            default:
                $error_description = "Errore generico.";
        }

        $smarty->assign("error_description", $error_description);
        $smarty->display("error.tpl");
    }
}