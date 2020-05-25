<?php


class VError
{
    public static function error(int $num, string $descrizione = "")
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("error_number", $num);
        $error_description = "";
        switch ($num)
        {
            case 0:
                $error_description = $descrizione;
                break;
            case 1:
                $error_description = "Errore nell'accesso al Database.";
                break;
            case 2:
                $error_description = "Errore nella scrittura sul database.";
                break;
            default:
                $error_description = "Errore generico.";
        }
        $smarty->assign("error_description", $error_description);
        $smarty->display("error.tpl");
    }
}