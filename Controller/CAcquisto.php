<?php


class CAcquisto
{
    public static function getBiglietti() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $gestore = EHelper::getInstance();
            $utente = $gestore->getUtente();
            if($utente === false) {
                header("Location: Utente/logout");
            }
            else if (!isset($utente)) {
                header("Location: /");
            }
            else {
                $id = $_POST["proiezione"];
                $str = $_POST["posti"];
                $posti = EPosto::fromString($str, true);
                $pm = FPersistentManager::getInstance();
                $proiezione = $pm->load($id, "id", "EProiezione")->getElencoProgrammazioni()[0]->getProiezioni()[0];
                $isAdmin = $gestore->isAdmin($utente);
                $locandina = $pm->load($proiezione->getFilm()->getId(), "idFilm", "EMedia");
                VAcquisto::showAcquisto($posti, $utente, $isAdmin, $proiezione, $locandina);
            }

        }
        else
        {
            header("Location: /");
        }
    }
}