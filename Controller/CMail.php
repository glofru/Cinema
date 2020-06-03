<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

class CMail
{
    private static string $user = "help.magicboulevard@gmail.com";
    private static string $password = "Supp0rtM@gic";

    private static string $domain = "localhost";
    private static string $host = "smtp.gmail.com";
    private static string $port = "587";

    public static function sendForgotMailNonRegistrato(EUtente $utente): bool {
        $link = "http://" . self::$domain . "/Utente/controlloBigliettiNonRegistrato/?";

        $subject = "Reset del tuo codice - Magic Boulevard Cinema";
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
        $body = "Ciao " . $utente->getNome() . " questi sono i biglietti che hai appena acquistato: <br><br>" . $tickets . "Ti auguriamo una buona visione :)";
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
            $otp = " il tuo codice di accesso è: <b>" . $uid . "</b> e";
        } else {
            $otp = "";
        }
        $body = "Ciao " . $utente->getEmail() . $otp . " questi sono i biglietti che hai appena acquistato: <br><br>" . $tickets . "Ti auguriamo una buona visione :)";
        $name = $utente->getEmail();
        return self::sendMail($utente->getEmail(), $subject, $body, $name);
    }

    private static function sendMail(string $to, string $subject, string $body, string $name = ""): bool {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = self::$host;
        $mail->isHTML(true);

        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Host       = self::$host;
        $mail->Port       = self::$port;
        $mail->Username   = self::$user;
        $mail->Password   = self::$password;

        $mail->setFrom(self::$user, 'Support Magic Boulevard Cinema');
        $mail->addAddress($to, $name);
        $mail->Subject    = $subject;
        $mail->Body       = $body;
        $mail->AltBody    = $body; //Non HTML clients

        try {
            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}