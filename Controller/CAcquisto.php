<?php


class CAcquisto
{
    public static function getBiglietti() {
        if ($_SERVER['REQUEST_METHOD']=="POST") {
            $id = $_POST["proiezione"];
            $str = $_POST["posti"];

            if (!isset($id) || !isset($str)) {
                VError::error(8);
            } elseif (CUtente::isLogged()) { //Utente registrato
                self::loadBiglietti($id, $str);
            } elseif (isset($_POST["mail"]) && EInputChecker::getInstance()->isEmail($_POST["mail"])) { //Utente non registrato
                $mail = $_POST["mail"];

                $utente = FUtente::load($mail, "email");

                if (isset($utente) && $utente->isRegistrato()) {
                    VUtente::loginForm($mail, false, $utente);
                } else {
                    if (!isset($utente)) {
                        try {
                            $utente = new ENonRegistrato($mail, uniqid());
                        } catch (Exception $e) {
                            VError::error(8);
                        }
                    }

                    session_start();
                    $_SESSION["nonRegistrato"] = serialize($utente);

                    self::loadBiglietti($id, $str, null);
                }
            } else { //Errore, l'utente non è loggato e non ha inviato la mail, non dovrebbe accadere
                VError::error(8);
            }

        } else {
            CMain::notFound();
        }
    }

    private static function loadBiglietti(int $id, string $str, $utente) {
        $pm = FPersistentManager::getInstance();

        $posti = EPosto::fromString($str, true);
        $proiezione = $pm->load($id, "id", "EProiezione")->getElencoProgrammazioni()[0]->getProiezioni()[0];
        $locandina = $pm->load($proiezione->getFilm()->getId(), "idFilm", "EMedia");
        $biglietti = [];
        $totale = 0;

        foreach ($posti as $key => $posto) {
            $costo = EBiglietto::getPrezzofromProiezione($proiezione);
            array_push($biglietti, new EBiglietto($proiezione, $posto, $utente, $costo, uniqid()));
            $totale += $costo;
        }

        if(sizeof($biglietti) > 0) {
            $serialized = serialize($biglietti);
            $_SESSION["biglietti"] = $serialized;
            VAcquisto::showAcquisto($biglietti, $locandina, $utente, $totale);
        } else {
            VError::error(8);
        }
    }

    public static function confermaAcquisto() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if(!CUtente::isLogged() || CUtente::getUtente()->isAdmin() || !isset($_SESSION["biglietti"])) {
                header("Location: /");
                return;
            }

            $biglietti = unserialize($_SESSION["biglietti"]);

            foreach ($biglietti as $item) {
                if ($item->getUtente()->getId() !== CUtente::getUtente()->getId()) {
                    VError::error(100);
                    return;
                }
            }

            $pm = FPersistentManager::getInstance();
            $result = $pm->occupaPosti($biglietti);
            if ($result === null) {
                VError::error(5); //Il posto non esisteva
                die;
            } elseif ($result) {
                foreach ($biglietti as $item) {
                    $pm->save($item);
                }
                CMail::sendTickets(CUtente::getUtente(), $biglietti);
                header("Location: ../../Utente/bigliettiAcquistati");
            } else {
                VError::error(0, "Almeno uno dei posti che voleva acquistare è stato già occupato. La invitiamo a riprovare!");
            }
        } else {
            CMain::notFound();
        }
    }
}