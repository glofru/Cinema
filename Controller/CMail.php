<?php
require_once "Mail.php";

class CMail
{
    private static string $user = "help.magicboulevard@gmail.com";
    private static string $password = "Supp0rtM@gic";

    private static string $domain = "localhost";
    private static string $host = "ssl://smtp.gmail.com";
    private static string $port = "465";

    public static function sendForgotMail(EUtente $utente, string $token): bool {
        $link = "http://" . self::$domain . "/Utente/forgotPassword/?token=" . $token;

        $subject = "Reset della password — Magic Boulevard Cinema";
        $body = "Ciao " . $utente->getNome() . ",<br><br>" .
            "Puoi resettare la tua password cliccando " . "<a href='" . $link . "'>qui</a>.<br>" .
            "Se non hai fatto richiesta tu di cambiare la password, ignora la mail.<br><br>" .
            "ATTENZIONE: mail generata automaticamente, un eventuale risposta non verra' letta.";

        return self::sendMail($utente->getEmail(), $subject, $body);
    }

    private static function sendMail(string $to, string $subject, string $body): bool {
        $headers = array (
            'From' => self::$user,
            'To' => $to,
            'Subject' => $subject,
            'MIME-Version' => 1,
            'Content-type' => 'text/html;charset=iso-8859-1'
        );

        $smtp = Mail::factory(
            'smtp',
            array (
                'host' => self::$host,
                'port' => self::$port,
                'auth' => true,
                'username' => self::$user,
                'password' => self::$password
            )
        );

        $mail = $smtp->send($to, $headers, $body);

        return !PEAR::isError($mail);
    }
}