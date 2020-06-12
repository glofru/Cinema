<?php

/**
 * Nella classe Film sono presenti tutti i metodi e gli attributi necessari alla creazione di un genere.
 * Class EGenere
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EGenere {
    /**
     * EGenere constructor.
     */
    private function __construct() {}

    /**
     * @var string, genere Azione.
     */
    public static string $AZIONE = "AZIONE";

    /**
     * @var string, genere Avventura.
     */
    public static string $AVVENTURA = "AVVENTURA";

    /**
     * @var string, genere Drammatico.
     */
    public static string $DRAMMATICO = "DRAMMATICO";
    /**
     * @var string, genere Guerra.
     */
    public static string $GUERRA = "GUERRA";
    /**
     * @var string, genere Giallo.
     */
    public static string $GIALLO = "GIALLO";
    /**
     * @var string, genere Animazione.
     */
    public static string $ANIMAZIONE = "ANIMAZIONE";
    /**
     * @var string, genere Commedia.
     */
    public static string $COMMEDIA = "COMMEDIA";
    /**
     * @var string, genere Romantico.
     */
    public static string $ROMANTICO = "ROMANTICO";
    /**
     * @var string, genere Sci-Fi.
     */
    public static string $SCIFI = "SCI-FI";
    /**
     * @var string, genere Biografico.
     */
    public static string $BIOGRAFICO = "BIOGRAFICO";
    /**
     * @var string, genere Horror.
     */
    public static string $HORROR = "HORROR";
    /**
     * @var string, genere di default se ne è stato inserito uno non valido.
     */
    public static string $NOT_DEFINED = "NOT_DEFINED";

    /**
     * Funzione che ritorna un genere a partire da una stringa.
     * @param string $s, stringa contente il genere da 'istanziare'.
     * @return string, genere.
     */
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

    /**
     * Funzione che restituisce tutti i generi.
     * @return array, array contenente tutti i generi.
     */
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