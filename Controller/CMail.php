<?php

class CMail
{
    private static string $domain = "localhost";

    public static function sendForgotMailNonRegistrato(EUtente $utente): bool {
        $link = "http://" . self::$domain . "/Utente/controlloBigliettiNonRegistrato/?";

        $subject = "Reset del tuo codice — Magic Boulevard Cinema";
        $body = "Ciao " . $utente->getEmail() . ",<br><br>" .
            "Come da te richiesto  ecco il tuo novo codice per accedere ai tuoi biglietti acquistati." . "<b>" . $utente->getPassword() . "</b> <br>" .  "Adesso puoi controllare i tuoi biglietti acquistati " . "<a href='" . $link . "'>qui</a> ".
            "ATTENZIONE: mail generata automaticamente, un eventuale risposta non verra' letta.";

        $name = $utente->getEmail();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    public static function sendForgotMail(EUtente $utente, EToken $token): bool {
        $link = "http://" . self::$domain . "/Utente/forgotPassword/?token=" . $token->getValue();

        $subject = "Reset della password - Magic Boulevard Cinema";
        $body = "Ciao " . $utente->getNome() . ",<br><br>" .
            "Puoi resettare la tua password cliccando " . "<a href='" . $link . "'>qui</a>. Hai a disposizione un'ora per completare l'operazione. Altrimenti dovrai ripetere la richesta sul nostro portale!!!<br>" .
            "Se non hai fatto richiesta tu di cambiare la password, ignora la mail.<br><br>" .
            "ATTENZIONE: mail generata automaticamente, un eventuale risposta non verra' letta.";

        $name = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    public static function sendTickets(ERegistrato $utente, array $biglietti) {
        $subject = "I tuoi bilgietti - Magic Boulevard Cinema";

        $tickets = "";
        foreach ($biglietti as $item) {
            $tickets .= "Biglietto #" . $item->getId() . "<br>" . "Film: " . $item->getProiezione()->getFilm()->getNome() . "<br>" . "Sala: " . $item->getProiezione()->getSala()->getNumeroSala() . "<br>" . "Giono e Ora: " . $item->getProiezione()->getData() . " alle " . $item->getProiezione()->getOra() . "<br>". $item->getPosto() . "<br>" . "Prezzo: " . $item->getCosto() . " Euro<br>" .
            "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". $item->getId() . "&choe=UTF-8\" title=\"Codice QR damostrare all'ingresso\" />" . "<br><br>";
        }
        $body = "Ciao " . $utente->getNome() . ",<br><br>questi sono i biglietti che hai appena acquistato: <br><br>" . $tickets . "Ti auguriamo una buona visione :)";

        $name = $utente->getNome() . " " . $utente->getCognome();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    public static function sendTicketsNonRegistrato(ENonRegistrato $utente, array $biglietti, $uid = null) {
        $subject = "I tuoi bilgietti - Magic Boulevard Cinema";

        $tickets = "";
        foreach ($biglietti as $item) {
            $tickets .= "Biglietto #" . $item->getId() . "<br>" . "Film: " . $item->getProiezione()->getFilm()->getNome() . "<br>" . "Sala: " . $item->getProiezione()->getSala()->getNumeroSala() . "<br>" . "Giono e Ora: " . $item->getProiezione()->getData() . " alle " . $item->getProiezione()->getOra() . "<br>". $item->getPosto() . "<br>" . "Prezzo: " . $item->getCosto() . " Euro<br>" .
                "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". $item->getId() . "&choe=UTF-8\" title=\"Codice QR damostrare all'ingresso\" />" . "<br><br>";
        }

        if(isset($uid)) {
            $otp = "il tuo codice di accesso è: <b>" . $uid . "</b> e";
        } else {
            $otp = "";
        }
        $body = "Ciao " . $utente->getEmail() . ",<br><br>" . $otp . " questi sono i biglietti che hai appena acquistato: <br><br>" . $tickets . "Ti auguriamo una buona visione :)";

        $name = $utente->getEmail();

        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    private static function sendMail(string $to, string $subject, string $body, string $name): bool {
        $email = new EMail($to, $name, $subject, $body);

        return EMailSender::send($email);
    }

    public static function sendNewsLetter() {
        if($_SERVER['REQUEST_METHOD']=="GET" && $_GET["token"] === "S3ndM34M41l") {
            $utenti = FPersistentManager::getInstance()->loadAll();
            if(isset($utenti) && sizeof($utenti) > 0) {
                $date = EHelper::getInstance()->getSettimanaProssima();
                $results = CHome::getProiezioni($date);
                foreach ($utenti as $utente){
                    self::newsLetter($utente, $date, $results);
                }
            }
        }
    }

    public static function newsLetter(EUtente $utente,array $date, array $results) {
        $subject = "Proiezioni dal " . DateTime::createFromFormat('Y-m-d',$date[0])->format('d-m') . " al " . DateTime::createFromFormat('Y-m-d',$date[1])->format('d-m') . " - Magic Boulevard Cinema";
        $body = "Ciao" . $utente->getNome() . " " . $utente->getCognome() . " ecco a te le proeizioni della prossima settimana: <br><br>";
        $immagini = $results[1];
        foreach ($results[0] as $key => $film) {
            $eta = "";
            if ($film->getEtaConsigliata() != "") {
                $eta = "Eta' consigliata: " . $film->getEtaConsigliata() . "<br>";
            }
            $img = $immagini[$key]->getImmagineHTML();
            $body .="Film :" . $film->getNome() . "<br>" . "Data di rilascio" . $film->getDataRilascioString() . "<br>". $eta . "Durata: " . $film->getDurataMinuti() . "minuti" . "<br><br>" . "<b>Proiezioni</b>: " . "<br>" . $results[3][$key] . "<br>" . "<img src=\"$img\" alt=\"Locandina\" width=\"200\" height=\"300\"/>" . "<br><br><br>";
            $name = $utente->getNome() . " " . $utente->getCognome();
        }
        self::sendMail($utente->getEmail(), $subject, $body, $name);
    }
}