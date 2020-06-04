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
                self::loadBiglietti($id, $str, CUtente::getUtente());
            } elseif (isset($_POST["mail"]) && EInputChecker::getInstance()->isEmail($_POST["mail"])) { //Utente non registrato
                $mail = $_POST["mail"];

                $utente = FUtente::load($mail, "email");

                if (isset($utente) && $utente->isRegistrato()) {
                    VUtente::loginForm($mail, false);
                } else {
                    if (!isset($utente)) {
                        try {
                            $utente = new ENonRegistrato($mail, "");
                        } catch (Exception $e) {
                            VError::error(8);
                        }
                    }

                    session_start();
                    session_regenerate_id(true);
                    session_set_cookie_params(300, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini | Andrebbe inoltre inserito il 4° parametro
                    $_SESSION["nonRegistrato"] = serialize($utente);
                    self::loadBiglietti($id, $str, $utente);
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
            $userPassed = $utente->isRegistrato() ? $utente : null;
            VAcquisto::showAcquisto($biglietti, $locandina, $userPassed, $totale);
        } else {
            VError::error(8);
        }
    }

    public static function confermaAcquisto() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $isNonRegistrato = false;
            if(!CUtente::isLogged(false) && isset($_SESSION["nonRegistrato"])) {
                $isNonRegistrato = true;
            }
            else if (!isset($_SESSION["biglietti"])  || CUtente::getUtente()->isAdmin()) {
                VError::error(100);
                return;
            }
            $biglietti = unserialize($_SESSION["biglietti"]);
            if(!$isNonRegistrato) {
                foreach ($biglietti as $item) {
                    if ($item->getUtente()->getId() !== CUtente::getUtente()->getId()) {
                        VError::error(100);
                        return;
                    }
                }
            }

            $pm = FPersistentManager::getInstance();
            if($isNonRegistrato) {
                $utente = unserialize($_SESSION["nonRegistrato"]);
            } else {
               $utente = CUtente::getUtente();
            }

            if(!$utente->isRegistrato()) {
                $utenteDB = FUtente::load($utente->getEmail(), "email");
                if(!isset($utenteDB)) {
                    $uid = uniqid();
                    $utente->setPassword(EHelper::getInstance()->hash($uid));
                    FPersistentManager::getInstance()->save($utente);
                } else {
                    $utente = $utenteDB;
                    $uid = null;
                }
            }

            foreach ($biglietti as $item) {
                if (!$utente->isRegistrato()) {
                    $item->setUtente($utente);
                }
            }

            $result = $pm->occupaPosti($biglietti);

            if ($result === null) {
                VError::error(5); //Il posto non esisteva
                die;
            } else if (!$result) {
                VError::error(0, "Almeno uno dei posti che voleva acquistare è stato già occupato. La invitiamo a riprovare!");
                die;
            } else {
                if (!$utente->isRegistrato()) {
                    CMail::sendTicketsNonRegistrato($utente, $biglietti, $uid);
                    unset($uid);
                    CUtente::logout(false);
                    header("Location: ../../Utente/controlloBigliettiNonRegistrato");
                } else {
                    foreach ($biglietti as $b) {
                        $utente->addBiglietto($b);
                    }
                    $_SESSION["utente"] = serialize($utente);
                    CMail::sendTickets($utente, $biglietti);
                    header("Location: ../../Utente/bigliettiAcquistati");
                }
            }
        } else {
            CMain::notFound();
        }
    }
}