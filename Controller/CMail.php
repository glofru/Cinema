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