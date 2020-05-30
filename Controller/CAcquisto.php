<?php


class CAcquisto
{
    public static function getBiglietti() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $id = $_POST["proiezione"];
            $str = $_POST["posti"];

            if (!CUtente::isLogged() || !isset($id) || !isset($str)) {
                header("Location: /");
            } else {
                $pm = FPersistentManager::getInstance();

                $posti = EPosto::fromString($str, true);
                $proiezione = $pm->load($id, "id", "EProiezione")->getElencoProgrammazioni()[0]->getProiezioni()[0];
                $locandina = $pm->load($proiezione->getFilm()->getId(), "idFilm", "EMedia");
                $utente = CUtente::getUtente();

                $biglietti = [];
                foreach ($posti as $key => $posto) {
                    array_push($biglietti, new EBiglietto($proiezione, $posto, $utente, 5.0));
                }

                if(sizeof($biglietti) > 0) {
                   $serialized = serialize($biglietti);
                   $_SESSION["biglietti"] = $serialized;
                   VAcquisto::showAcquisto($biglietti, $locandina, $utente);
                } else {
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
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $gestore = EHelper::getInstance();

            if(!isset($_SESSION["biglietti"])) {
                header("Location: /");
            }

            if(CUtente::isLogged()) {
                header("Location: ../../Utente/logout");
            } else if (!isset($utente)) {
                header("Location: /");
            } else {
                $biglietti = unserialize($_SESSION["biglietti"]);
                foreach($biglietti as $item) {
                    if($item->getUtente()->getId() !== $utente->getId()) {
                        //TODO
                    }
                }
                $pm = FPersistentManager::getInstance();
                $result = $pm->occupaPosti($biglietti);
                echo $result;
            }
        } else {
            header("Location: /");
        }
    }
}