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
    public static string $HORROR = "HORROR";
    public static string $NOT_DEFINED = "NOT_DEFINED";

    public static function fromString(string $s)
    {
        switch (strtoupper($s)) {
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
            case "HORROR";
                return self::$HORROR;
            default:
                return self::$NOT_DEFINED;
        }
    }

    public static function getAll(): array
    {
        $return = [];
        array_push($return, self::$AZIONE);
        array_push($return, self::$AVVENTURA);
        array_push($return, self::$DRAMMATICO);
        array_push($return, self::$GUERRA);
        array_push($return, self::$GIALLO);
        array_push($return, self::$ANIMAZIONE);
        array_push($return, self::$COMMEDIA);
        array_push($return, self::$ROMANTICO);
        array_push($return, self::$SCIFI);
        array_push($return, self::$BIOGRAFICO);
        array_push($return, self::$HORROR);
        return $return;
    }
}