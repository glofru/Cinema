<?php

/**
 * Nella classe Acquisto sono presenti metodi necessari a partettere ad Utenti Nonregistrati e Registrati di acquistare uno o più biglietti.
 * Class CAcquisto
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CAcquisto
{
    /**
     * Funzione richiamabile solo via metodo POST che, presi id della proiezione ed i posti in una stringa parsata, inizializza la fase di acquisto ed esegue le seguenti funzioni:
     * 1) Controlla se l'utente che ha eseguito la richiesta sia un utente registrato. Nel caso in cui non lo sia crea un nuovo utente non Registrato attraverso la mail inserita nella fase di scelta dei posti da acquistare.
     * 1-bis) Se l'utente è un non Registrato viene inizializzata una sessione ed inseirta come variabile di sessione l'oggetto utente non registrato.
     * 2) Se l'utente è loggato oppure la creazione di un utente non registrato ha dato esito positivo si procede con il passare l'id della proiezione, la stringa con i posti parsata e l'oggetto utente al metodo loadBiglietti.
     * @throws SmartyException
     */
    public static function getBiglietti() {
        if ($_SERVER['REQUEST_METHOD']=="POST") {
            $id  = $_POST["proiezione"];
            $str = $_POST["posti"];

            if (!isset($id) || !isset($str)) {
                VError::error(8);
            } elseif (CUtente::isLogged()) { //Utente registrato
                self::loadBiglietti($id, $str, CUtente::getUtente());
            } elseif (isset($_POST["mail"]) && EInputChecker::getInstance()->isEmail($_POST["mail"])) { //Utente non registrato
                $mail   = $_POST["mail"];

                $utente = FUtente::load($mail, "email");

                if (isset($utente) && ($utente->isRegistrato() || $utente->isAdmin())) {
                    VUtente::loginForm($mail, false);
                } else {
                    if (!isset($utente)) {
                        try {
                            $utente = new ENonRegistrato($mail, "");
                        } catch (Exception $e) {
                            VError::error(8);
                        }
                    }

                    CUtente::saveSession($utente);

                    self::loadBiglietti($id, $str, $utente);
                }
            } else { //Errore, l'utente non è loggato e non ha inviato la mail, non dovrebbe accadere
                VError::error(8);
            }
        } else {
            CFrontController::methodNotAllowed();
        }
    }

    /**
     * Funzione privata che provvede alle seguenti funzioni di supporto al processo di acquisto dei biglietti:
     * 1) Vengono reperiti dal DB il film e la locandina del film corrispondente alla proiezione.
     * 2) Viene caricata la proiezione dal DB e viene effettuato il parsing della stringa contenente i posti che si vogliono acquistare.
     * 3) Ottenuti tutti gli oggetti necessari vengono istanziati un numero di biglietti pari al numero di posti scelti.
     * 4) I biglietti appena istanziati vengono salvati in un array ed inseriti in una variabile di sessione al fine di poter essere reperiti con facilità.
     *
     *
     * @param int $id , id della proiezione.
     * @param string $str , stringa parsata con i posti che si vogliono occupare.
     * @param $utente , l'utente che effettua l'acquisto.
     * @throws SmartyException
     */
    private static function loadBiglietti(int $id, string $str, $utente) {
        $pm         = FPersistentManager::getInstance();

        $posti      = EPosto::fromString($str, true);
        $proiezione = $pm->load($id, "id", "EProiezione")->getElencoProgrammazioni()[0]->getProiezioni()[0];
        $locandina  = $pm->load($proiezione->getFilm()->getId(), "idFilm", "EMedia");
        $biglietti  = [];
        $totale     = 0;

        foreach ($posti as $key => $posto) {
            $costo  = EBiglietto::getPrezzofromProiezione($proiezione);
            array_push($biglietti, new EBiglietto($proiezione, $posto, $utente, $costo, uniqid()));
            $totale += $costo;
        }

        if(sizeof($biglietti) > 0) {
            CSessionManager::getInstance()->saveBiglietti($biglietti);

            VAcquisto::showAcquisto($biglietti, $locandina, $utente, $totale);
        } else {
            VError::error(8);
        }
    }

    /**
     * Funzione che conclude il processo di acquisto di uno o più biglietti. Accessibile solo via metodo POST. Esegue le seguenti funzioni:
     * 1) Controlla se l'utente che sta eseguendo l'acquisto è un utente Registrato o Non registrato ed estrae l'array di biglietti dalla variabile di sessione.
     * 2) Se l'utente è un non Registrato allora si controlla nel DB degli utenti se è presente. Se lo è allora viene caricato l'oggetto dal DB, altrimenti gli viene assegnata una password randomica e salvato nel DB.
     * 3) A questo punto ad ogni biglietto acquistato viene assegnato il corrispettivo utente e successivamente vengono salvati i biglietti nel DB ed occupati i relativi posti. Se almeno uno dei posti è stato già occupato durante tale processo l'acquisto viene annullato e l'utente viene invitato a riprovare.
     * 4) Se il passaggio precedente ha avuto esito positivo allora viene inviata una mail di conferma agli utenti con i biglietti ed un codice QR contenente l'id del biglietto.
     * 5) Se l'utente è un non Registrato ed è la prima volta che effettua un acquisto allora nella mail è inclusa la password temporanea che gli è stata assegnata. Nel caso invece in cui non sia il primo acquisto per l'utente non Registrato, non viene inviata la password in quanto resta valida la prima assegnatagli.
     * 6) Se l'utente è un non registrato la sessione viene terminata al termine dell'acquisto.
     * @throws SmartyException
     * @throws Exception
     */
    public static function confermaAcquisto() {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $isNonRegistrato     = false;
            $biglietti           = CSessionManager::getInstance()->loadBiglietti();
            if(!CUtente::isLogged() && CUtente::getUtente()->isNonRegistrato()) {
                $isNonRegistrato = true;
            } else if (!isset($biglietti)  || CUtente::getUtente()->isAdmin()) {
                VError::error(100);
                die;
            }

            if(!$isNonRegistrato) {
                foreach ($biglietti as $item) {
                    if ($item->getUtente()->getId() !== CUtente::getUtente()->getId()) {
                        VError::error(100);
                        die;
                    }
                }
            }

            $pm = FPersistentManager::getInstance();

            $utente = CSessionManager::getInstance()->getUtente();

            if(!$utente->isRegistrato()) {
                $utenteDB   = FUtente::load($utente->getEmail(), "email");
                if(!isset($utenteDB)) {
                    $uid    = uniqid();
                    $utente->setPassword($uid);

                    FPersistentManager::getInstance()->signup($utente);
                } else {
                    $utente = $utenteDB;
                    $uid    = null;
                }
            }

            foreach ($biglietti as $item) {
                if (!$utente->isRegistrato()) {
                    $item->setUtente($utente);
                }
            }

            $result = $pm->occupaPosti($biglietti);

            if ($result === null) {
                VError::error(12); //Il posto non esisteva
                die;
            } else if (!$result) {
                VError::error(13);
                die;
            } else {
                if (!$utente->isRegistrato()) {
                    CMail::sendTicketsNonRegistrato($utente, $biglietti, $uid);

                    unset($uid);
                    CUtente::logout(false);

                    header("Location: /MagicBoulevardCinema/Utente/controlloBigliettiNonRegistrato");
                } else {
                    foreach ($biglietti as $b) {
                        $utente->addBiglietto($b);
                    }
                    CSessionManager::getInstance()->saveUtente($utente);
                    CMail::sendTickets($utente, $biglietti);

                    header("Location: /MagicBoulevardCinema/Utente/bigliettiAcquistati");
                }
            }
        } else {
            CFrontController::methodNotAllowed();
        }
    }
}