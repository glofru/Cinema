<?php


class CAcquisto
{
    public static function getBiglietti() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $gestore = EHelper::getInstance();
            $utente = $gestore->getUtente();
            $isAdmin = $gestore->isAdmin($utente);
            $id = $_POST["proiezione"];
            $str = $_POST["posti"];
            if($utente === false) {
                header("Location: Utente/logout");
            }
            else if (!isset($utente) || $isAdmin === true || !isset($id) || !isset($str)) {
                header("Location: /");
            }
            else {
                $posti = EPosto::fromString($str, true);
                $pm = FPersistentManager::getInstance();
                $proiezione = $pm->load($id, "id", "EProiezione")->getElencoProgrammazioni()[0]->getProiezioni()[0];
                $locandina = $pm->load($proiezione->getFilm()->getId(), "idFilm", "EMedia");
                $biglietti = [];
                foreach ($posti as $posto) {
                    array_push($biglietti, new EBiglietto($proiezione, $posto, $utente, 5.0));
                }
                if(sizeof($biglietti) > 0) {
                    $serialized = serialize($biglietti);
                    VAcquisto::showAcquisto($biglietti, $isAdmin, $locandina, $serialized);
                }
                else {
                    header("Location: /");
                }
            }

        }
        else
        {
            header("Location: /");
        }
    }

    public static function confermaAcquisto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["biglietti"])) {
            $gestore = EHelper::getInstance();
            $utente = $gestore->getUtente();
            if($utente === false) {
                header("Location: Utente/logout");
            }
            else if (!isset($utente)) {
                header("Location: /");
            }
            else {
                $biglietti = unserialize($_POST["biglietti"]);
                echo "BIGLIETTI: ";
                print_r($biglietti);
                foreach ($biglietti as $item) {
                    print $item->getPosto() . "<br>";
                }
            }
        }
        else {
            header("Location: /");
        }
    }
}