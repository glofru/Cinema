<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

class EMailSender
{
    private static string $user = "help.magicboulevard@gmail.com";
    private static string $password = "Supp0rtM@gic";

    private static string $host = "smtp.gmail.com";
    private static string $port = "587";

    private function __construct() {}

    public static function send(EMail $email): bool {
        $sender = new PHPMailer(true);

        $sender->isSMTP();
        $sender->Host = self::$host;
        $sender->isHTML(true);

        $sender->SMTPAuth   = true;
        $sender->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $sender->Host       = self::$host;
        $sender->Port       = self::$port;
        $sender->Username   = self::$user;
        $sender->Password   = self::$password;

        $sender->setFrom(self::$user, 'Support Magic Boulevard Cinema');
        $sender->addAddress($email->getTo(), $email->getName());
        $sender->Subject    = $email->getSubject();
        $sender->Body       = $email->getBody();
        $sender->AltBody    = $email->getBody(); //Non HTML clients

        try {
            return $sender->send();
        } catch (Exception $e) {
            return false;
        }
    }
}