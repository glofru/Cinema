<?php

class EGenere {
    private function __construct() {}

    public static string $AZIONE = "AZIONE";
    public static string $AVVENTURA = "AVVENTURA";
    public static string $DRAMMATICO = "DRAMMATICO";
    public static string $GUERRA = "GUERRA";
    public static string $GIALLO = "GIALLO";
    public static string $ANIMAZIONE = "ANIMAZIONE";
    public static string $COMMEDIA = "COMMEDIA";
    public static string $ROMANTICO = "ROMANTICO";
    public static string $SCIFI = "SCI-FI";
    public static string $BIOGRAFICO = "BIOGRAFICO";
    public static string $NOT_DEFINED = "NOT_DEFINED";

    public static function fromString(string $s)
    {
        switch ($s) {
            case "AZIONE":
                return self::$AZIONE;
            case "AVVENTURA":
                return self::$AVVENTURA;
            case "DRAMMATICO":
                return self::$DRAMMATICO;
            case "GUERRA":
                return self::$GUERRA;
            case "GIALLO":
                return self::$GIALLO;
            case "ANIMAZIONE":
                return self::$ANIMAZIONE;
            case "COMMEDIA":
                return self::$COMMEDIA;
            case "ROMANTICO":
                return self::$ROMANTICO;
            case "SCI-FI";
                return self::$SCIFI;
            case "BIOGRAFICO";
                return self::$BIOGRAFICO;
            default:
                return self::$NOT_DEFINED;
        }
    }
}