<?php
require_once "Mail.php";

class CMail
{
    private static string $user = "help.magicboulevard@gmail.com";
    private static string $password = "Supp0rtM@gic";

    private static string $host = "ssl://smtp.gmail.com";
    private static string $port = "465";

    public static function sendForgotMail(EUtente $utente): bool {
        $link = "";

        $subject = "Reset della password — Magic Boulevard Cinema";
        $body = "Ciao " . $utente->getNome() . ", " . PHP_EOL . PHP_EOL .
            "Puoi resettare la tua password cliccando " . "<a href='" . $link . "'>qui</a>" . PHP_EOL .
            "Se non hai fatto richiesta tu di cambiare la password, ignora la mail." . PHP_EOL . PHP_EOL .
            "ATTENZIONE: mail generata automaticamente, un eventuale risposta non verrà letta.";

        return self::sendMail($utente->getEmail(), $subject, $body);
    }

    private static function sendMail(string $to, string $subject, string $body): bool {
        $headers = array (
            'From' => self::$user,
            'To' => $to,
            'Subject' => $subject
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