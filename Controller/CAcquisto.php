<?php


class CAcquisto
{
    public static function getBiglietti() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $gestore = EHelper::getInstance();
            $utente = CUtente::getUtente();
            $isAdmin = EUtente::isAdmin($utente);
            $id = $_POST["proiezione"];
            $str = $_POST["posti"];
            if (!isset($utente) || $isAdmin === true || !isset($id) || !isset($str)) {
                header("Location: /");
            }
            else {
                $posti = EPosto::fromString($str, true);
                $pm = FPersistentManager::getInstance();
                $proiezione = $pm->load($id, "id", "EProiezione")->getElencoProgrammazioni()[0]->getProiezioni()[0];
                $locandina = $pm->load($proiezione->getFilm()->getId(), "idFilm", "EMedia");
                $biglietti = [];
                foreach ($posti as $key => $posto) {
                    array_push($biglietti, new EBiglietto($proiezione, $posto, $utente, 5.0));
                }
                if(sizeof($biglietti) > 0) {
                   $serialized = serialize($biglietti);
                   $_SESSION["biglietti"] = $serialized;
                   VAcquisto::showAcquisto($biglietti, $isAdmin, $locandina, $utente);
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
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $gestore = EHelper::getInstance();
            $utente = CUtente::getUtente();
            if(!isset($_SESSION["biglietti"])){
                //header("Location: /");
                echo "NO_SESS";
            }
            if($utente === false) {
                header("Location: ../../Utente/logout");
            }
            else if (!isset($utente)) {
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
                echo $result;
            }
        }
        else {
            header("Location: /");
        }
    }
}