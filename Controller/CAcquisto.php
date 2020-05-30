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
                $totale = 0;
                foreach ($posti as $key => $posto) {
                    $costo = EBiglietto::getPrezzofromProiezione($proiezione);
                    array_push($biglietti, new EBiglietto($proiezione, $posto, $utente, $costo));
                    $totale += $costo;
                }
                if(sizeof($biglietti) > 0) {
                   $serialized = serialize($biglietti);
                   $_SESSION["biglietti"] = $serialized;
                   VAcquisto::showAcquisto($biglietti, $locandina, $utente, $totale);
                } else {
                    header("Location: /");
                }
            }

        } else {
            header("Location: /");
        }
    }

    public static function confermaAcquisto() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $gestore = EHelper::getInstance();
            $utente = CUtente::getUtente();
            if(!isset($utente)) {
                header("Location: /");
            }
            else if(!isset($_SESSION["biglietti"])) {
                header("Location: /");
            }
            else {
                $biglietti = unserialize($_SESSION["biglietti"]);
                foreach($biglietti as $item) {
                    if($item->getUtente()->getId() !== $utente->getId()) {
                        //TODO
                    }
                }
                $pm = FPersistentManager::getInstance();
                $result = $pm->occupaPosti($biglietti);
                echo "RES: " . $result . "<br>";
                if($result == '1') {
                    foreach ($biglietti as $item) {
                        $pm->save($item);
                    }
                    header("Location: ../../Utente/bigliettiAcquistati");
                }
                else if ($result == '0') {
                    echo "ERRORE 0";
                }
                else {
                    echo "ERRORE 1";
                }
            }
        }
        else {
            header("Location: /");
        }
    }
}