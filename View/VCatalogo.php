<?php


class VCatalogo
{

    public static function prossimeUscite(array $result, $utente, bool $isAdmin, array $consigliati) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("filmProssimi", $result[0]);
        $smarty->assign("immaginiProssimi", $result[1]);
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);
        $smarty->assign("filmConsigliati", $consigliati[0]);
        $smarty->assign("immaginiConsigliati", $consigliati[1]);
        $smarty->assign("whois", "Prossime uscite");
        $smarty->display("catalogo.tpl");
    }

    public static function programmazioniPassate(array $film, array $immagini, array $punteggio, array $date, $utente, bool $isAdmin, array $consigliati, array $toShow) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);
        $smarty->assign("filmPassati", $film);
        $smarty->assign("immaginiPassati", $immagini);
        $smarty->assign("punteggio", $punteggio);
        $smarty->assign("date", $date);
        $smarty->assign("whois", "Programmazioni delle ultime settimane");
        $smarty->assign("filmConsigliati", $consigliati[0]);
        $smarty->assign("immaginiConsigliati", $consigliati[1]);
        $smarty->assign("toShow", $toShow);
        $smarty->display("catalogo.tpl");
    }

    public static function piuApprezzati(array $result, $utente, bool $isAdmin, array $consigliati) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);
        $smarty->assign("filmApprezzati", $result[0]);
        $smarty->assign("immaginiApprezzati", $result[1]);
        $smarty->assign("punteggio", $result[2]);
        $smarty->assign("filmConsigliati", $consigliati[0]);
        $smarty->assign("immaginiConsigliati", $consigliati[1]);
        $smarty->assign("whois", "Top 10 film più apprezzati dagli utenti");
        $smarty->display("catalogo.tpl");
    }
}