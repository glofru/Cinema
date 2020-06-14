<?php

/**
 * La classe Mail fornisce i metodi necessari ad impostare diverse tipologie di email standard da inviare ad i nostri utenti.
 * Class CMail
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CMail
{

    /**
     * Funzione che invia una email contenente un nuovo codice univoco (uid) ad un utente non Registrato che non trovi più quello che gli è stato assegnato dopo aver effettuato il suo primo acquisto.
     * @param EUtente $utente , utente destinatario della email, ovvero l'utente che ha chiesto il reset della password.
     * @return bool, esito dell'invio.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sendForgotMailNonRegistrato(EUtente $utente): bool {
        $link    = "http://" . $GLOBALS["domain"] . "/MagicBoulevardCinema/Utente/controlloBigliettiNonRegistrato/?";

        $subject = "Reset del tuo codice — Magic Boulevard Cinema";
        $body    =  "Ciao " . $utente->getEmail() . ",<br><br>" .
                    "Come da te richiesto  ecco il tuo novo codice per accedere ai tuoi biglietti acquistati." . "<b>" . $utente->getPassword() . "</b> <br>" .  "Adesso puoi controllare i tuoi biglietti acquistati " . "<a href='" . $link . "'>qui</a> ".
                    "ATTENZIONE: mail generata automaticamente, un eventuale risposta non verra' letta.";

        $name    = $utente->getEmail();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione che invia un link per il reset della password per un utente Registrato. L'utente può cliccare sul link presente nella mail ed accedere alla sezione relativa al reset della password e sceglierne una nuova.
     * @param EUtente $utente , utente destinatario della mail e che ha richiesto il reset della password.
     * @param EToken $token , token di reset della password.
     * @return bool, esito dell'invio.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sendForgotMail(EUtente $utente, EToken $token): bool {
        $link    = "http://" . $GLOBALS["domain"] . "/MagicBoulevardCinema/Utente/forgotPassword/?token=" . $token->getValue();

        $subject = "Reset della password - Magic Boulevard Cinema";
        $body    = "Ciao " . $utente->getNome() . ",<br><br>" .
            "Puoi resettare la tua password cliccando " . "<a href='" . $link . "'>qui</a>. Hai a disposizione un'ora per completare l'operazione. Altrimenti dovrai ripetere la richesta sul nostro portale!!!<br>" .
            "Se non hai fatto richiesta tu di cambiare la password, ignora la mail.<br><br>" .
            "ATTENZIONE: mail generata automaticamente, un eventuale risposta non verra' letta.";

        $name    = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione che invia ad un utente i biglietti acquistati. Mail specifica per utenti Registrati che continene anche un QR Code per l'identificazione del biglietto.
     * @param ERegistrato $utente , utente Registrato destinatario della mail e che ha effettuato l'acquisto.
     * @param array $biglietti , insieme dei biglietti acquistati.
     * @return bool, esito dell'invio.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sendTickets(ERegistrato $utente, array $biglietti) {
        $subject = "I tuoi bilgietti - Magic Boulevard Cinema";

        $tickets = "";
        foreach ($biglietti as $item) {
            $tickets .= "Biglietto #" . $item->getId() . "<br>" .
                        "Film: " . $item->getProiezione()->getFilm()->getNome() . "<br>" .
                        "Sala: " . $item->getProiezione()->getSala()->getNumeroSala() . "<br>" .
                        "Giono e Ora: " . $item->getProiezione()->getData() . " alle " . $item->getProiezione()->getOra() . "<br>" .
                        $item->getPosto() . "<br>" .
                        "Prezzo: " . $item->getCosto() . " Euro<br>" .
                        "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". $item->getId() . "&choe=UTF-8\" title=\"Codice QR damostrare all'ingresso\" />" . "<br><br>";
        }

        $body    = "Ciao " . $utente->getNome() . ",<br><br>questi sono i biglietti che hai appena acquistato: <br><br>" . $tickets . "Ti auguriamo una buona visione :)";

        $name    = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione che invia una mail contenente i biglietti acquistati da un utente non Registrato. Contiene per ogni biglietto un QR Code per l'identififazione del bliglietto.
     * Se è la prima volta che l'utente effettua un acquisto gli viene anche inviato il proprio codice univoco necessario a poter effettuare il login nella sezione apposita per consultare i biglietti acquistati.
     * @param ENonRegistrato $utente , utente non Registrato destinatario della mail e che ha effettuato l'acquisto.
     * @param array $biglietti , insieme dei biglietti acquistati.
     * @param string|null $uid , codice univoco di accesso. Inviato solo se è il primo acquisto effettuato dall'utente.
     * @return bool, esito dell'operaizone.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sendTicketsNonRegistrato(ENonRegistrato $utente, array $biglietti, $uid = null) {
        $subject = "I tuoi bilgietti - Magic Boulevard Cinema";

        $tickets = "";
        foreach ($biglietti as $item) {
            $tickets .= "Biglietto #" . $item->getId() . "<br>" .
                        "Film: " . $item->getProiezione()->getFilm()->getNome() . "<br>" .
                        "Sala: " . $item->getProiezione()->getSala()->getNumeroSala() . "<br>" .
                        "Giono e Ora: " . $item->getProiezione()->getData() . " alle " . $item->getProiezione()->getOra() . "<br>" .
                        $item->getPosto() . "<br>" . "Prezzo: " . $item->getCosto() . " Euro<br>" .
                        "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". $item->getId() . "&choe=UTF-8\" title=\"Codice QR damostrare all'ingresso\" />" . "<br><br>";
        }

        if(isset($uid)) {
            $otp = "il tuo codice di accesso è: <b>" . $uid . "</b> e";
        } else {
            $otp = "";
        }
        $body    = "Ciao " . $utente->getEmail() . ",<br><br>" . $otp . " questi sono i biglietti che hai appena acquistato: <br><br>" . $tickets . "Ti auguriamo una buona visione :)";

        $name    = $utente->getEmail();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione elementare che, raccolti gli elementi necessari da inserire in una mail, richiama l'entità che si occupa dell'invio delle email.
     * @param string $to, indirizzo mail del destinatario.
     * @param string $subject, oggetto della mail.
     * @param string $body, corpo del messaggio.
     * @param string $name, nome del destinatario.
     * @return bool, esito dell'operazione.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private static function sendMail(string $to, string $subject, string $body, string $name): bool {
        $email = new EMail($to, $name, $subject, $body);

        return EMailSender::send($email);
    }


    /**
     * Funzione che prepara una mail contenente le proiezioni che avranno luogo la settimana prossima.
     * @param EUtente $utente, utente iscritto alla newsletter destinatario della mail.
     * @param array $date, data di inizio e di fine della prossima settimana [LUN-DOM].
     * @param array $results, insieme dei film in proieizione, informazioni sugli orari di proieizone e le relative locandine.
     * @throws \PHPMailer\PHPMailer\Exception
     * @return bool, esito dell'invio.
     */
    public static function newsLetter(EUtente $utente,array $date, array $results): bool {
        $subject = "Proiezioni dal " . DateTime::createFromFormat('Y-m-d',$date[0])->format('d-m') . " al " . DateTime::createFromFormat('Y-m-d',$date[1])->format('d-m') . " - Magic Boulevard Cinema";

        $body = "Ciao" . $utente->getNome() . " " . $utente->getCognome() . "<br>" .
                "ecco a te le proeizioni della prossima settimana: <br><br>";

        $immagini = $results[1];
        foreach ($results[0] as $key => $film) {
            $eta = "";
            if ($film->getEtaConsigliata() != "") {
                $eta = "Eta' consigliata: " . $film->getEtaConsigliata() . "<br>";
            }
            $img = $immagini[$key]->getImmagineHTML(); //NELLE CASELLE DI POSTA LE IMMAGINI COME TESTO VENGONO FILTRATE ANDREBBEBRO CREATI DEI FILE DI IMMAGINE CON LE LOCANDINE ED HOSTATE SUL SITO PER POI ESSERE CHIAMATO IL PATH NEL SRC...
            $body .="Film :" . $film->getNome() . "<br>" .
                    "Data di rilascio" . $film->getDataRilascioString() . "<br>" .
                    $eta . "Durata: " . $film->getDurataMinuti() . " minuti" . "<br><br>" .
                    "<b>Proiezioni</b>: " . "<br>" . $results[3][$key] . "<br>" .
                    /*"<img src=\"$img\" alt=\"Locandina\" width=\"200\" height=\"300\"/>" .*/ "<br><br><br>";
            $name = $utente->getNome() . " " . $utente->getCognome();
        }

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione che invia una mail ad un utente, iscritto alla newsletter, informandolo che è stato caricato sul nostro sito un film con genere presente fra i suoi generi preferiti.
     * Viene, quindi, avvertito che prossimamente potrebbe essere in programmazione e quindi di controllare le programmazioni per essere al corrente di quando verrà proiettato.
     * @param EUtente $utente, utente destinatario della mail e che abbia fra i suoi generi preferiti lo stesso genere del film appena caricato.
     * @param EFilm $film, il film apena inserito nel sito.
     * @throws \PHPMailer\PHPMailer\Exception
     * @return bool, esito dell'invio.
     */
    public static function addedNewFilm(EUtente $utente, EFilm $film): bool {
        $subject  = "Abbiamo aggiunto un nuovo film  - Magic Boulevard Cinema";
        $eta      = "";
        $attori   = "Nel film ci saranno: ";
        $registi  = "Il film è diretto da: ";

        if ($film->getEtaConsigliata() != "") {
            $eta  = "Eta' consigliata: " . $film->getEtaConsigliata() . "<br>";
        }

        foreach ($film->getAttori() as $att) {
            $link = $att->getImdbUrl();
            $attori .= "<a href='$link'>" . $att->getFullName() . "</a>" . " ";
        }

        foreach ($film->getRegisti() as $att) {
            $link     = $att->getImdbUrl();
            $registi .= "<a href='$link'>" . $att->getFullName() . "</a>" . " ";
        }

        $trailer = $film->getTrailerURL();
        $body    =  "Ciao" . $utente->getNome() . " " . $utente->getCognome() . ",<br>" .
                    "volevamo avvisarti che nel nostro cinema è stato appena inserito un nuovo film del genere <b>" . $film->getGenere(). "</b>" . " ecco a te i dettagli: " . "<br><br>" .
                    "Titolo: " . $film->getNome() . "<br>" .
                    "Data di rilascio: " . $film->getDataRilascioString() . "<br>" .
                    $eta . "Durata: " . $film->getDurataMinuti() . "minuti" . "<br>" .
                    $attori . "<br>" .
                    $registi . "<br>" .
                    "Puoi vedere il trailer del film <a href='$trailer'>qui</a><br>" .
                    "Speriamo di vederti presto nel nostro cinema :). <br>";
        $name    = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione che invia una mail di ringraziamento ad un utente per essersi registrato presso il nostro sito.
     * @param EUtente $utente, utente che si è apppena iscritto.
     * @throws \PHPMailer\PHPMailer\Exception
     * @return bool, esito dell'invio.
     */
    public static function newEntry(EUtente $utente): bool {
        $subject = "Benvenuto - Magic Boulevard Cinema";
        $body    =  "Ciao " . $utente->getNome() . ", <br>" .
                    "grazie per esserti registrato sul nostro portale. Adesso puoi effettuare il login <a href='http://" . $GLOBALS["domain"] . "/MagicBoulevardCinema/Utente/login'><b>qui</b></a>. <br> " .
                    "Speriamo che il nostri contenuti siano di tuo gradimento e di facile utilizzo :)";
        $name    = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    /**
     * Funzione che avverte l'utente che la sua password è stata modificata. Nel caso non fosse stato lui ad eseguire l'operazione può contattare gli amministratori per provare a risolvere la sitauzione.
     * @param EUtente $utente, utente destinatario della mail e che ha appena modificato la sua password.
     * @throws \PHPMailer\PHPMailer\Exception
     * @return bool, esito dell'invio.
     */
    public static function modifiedPassword(EUtente $utente): bool {
        $subject = "Password modificata  - Magic Boulevard Cinema";
        $body    =  "Ciao " . $utente->getNome() . " " . $utente->getCognome() . "<br>" .
                    "ti segnaliamo che la tua password è stata modificata. Puoi effettuare il login <a href='http://" . $GLOBALS["domain"] . "/MagicBoulevardCinema/Utente/login'><b>qui</b></a>.<br><br>" .
                    "<b>ATTENZIONE</b>:Se non sei stato tu ad effettuare questa modifica <a href='http://" . $GLOBALS["domain"] . "/MagicBoulevardCinema/Utente/forgotPassword'>richiedi una nuova password</a>";
        $name    = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }
}