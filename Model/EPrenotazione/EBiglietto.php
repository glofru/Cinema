<?php
require_once "configCinema.conf.php";
/**
 * Nella classe Biglietto sono i presenti attributi e metodi per la creazione e la gestione di un biglietto.
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EBiglietto implements JsonSerializable
{
    /**
     * Proiezione alla quale si vuole assistere.
     * @AttributeType EProiezione
     */
    private EProiezione $proiezione;
    /**
     * Posto che si vuole prenotare.
     * @AttributeType EPosto
     */
    private EPosto $posto;
    /**
     * Utente che effettua l'acquisto.
     * @AttributeType EUtente
     */
    private EUtente $utente;

    /**
     * Costo del biglietto.
     * @var float
     */
    private float $costo;

    /**
     * Id del biglietto.
     * @var int
     */
    private int $id = 0;

    /**
     * EBiglietto constructor.
     * @param EProiezione $proiezione, proiezione per la quale si è acquistato il biglietto.
     * @param EPosto $posto, posto che si sta prenotando.
     * @param EUtente $utente, utente che sta effettuando l'acquisto.
     * @param float $costo, costo del biglietto.
     * @param int $id, id del biglietto.
     */
    public function __construct(EProiezione $proiezione, EPosto $posto, EUtente $utente, float $costo, int $id)
    {
        $this->setProiezione($proiezione);
        $this->setPosto($posto);
        $this->setUtente($utente);
        $this->setCosto($costo);
        $this->setId($id);
    }

//-------------- SETTER ----------------------
    /**
     * @param EProiezione $proiezione, proiezione alla quale si vuole assistere.
     */
    public function setProiezione(EProiezione $proiezione){
        $this->proiezione = $proiezione;
    }
    /**
     * @param EPosto $posto, posto che si sceglie di acquistare.
     */
    public function setPosto(EPosto $posto){
    $this->posto = $posto;
    }
    /**
     * @param EUtente $utente, utente che acquista il biglietto.
     */
    public function setUtente(EUtente $utente){
        $this->utente = $utente;
    }

    /**
     * @param float $costo, costo del biglietto.
     */
    public function setCosto(float $costo){
        $this->costo = $costo;
    }

    /**
     * @param int $id, id del biglietto.
     */
    public function setId(int $id){
        $this->id = $id;
    }

//----------------- GETTER --------------------
    /**
     * @return EProiezione, la proiezione alla quale si vuole assistere.
     */
    public function getProiezione(): EProiezione{
        return $this->proiezione;
    }
    /**
     * @return EPosto, il posto che si vuole prendere.
     */
    public function getPosto(): EPosto{
        return $this->posto;
    }
    /**
     * @return EUtente, l'utente che effettua l'operazione.
     */
    public function getUtente() : EUtente{
        return $this->utente;
    }

    /**
     * @return float, costo del biglietto.
     */
    public function getCosto(): float{
        return $this->costo;
    }

    /**
     * @return int, id del biglietto.
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * Funzione che ritorna una stringa contenete gli elementi base da cui poter ricostruire il biglietto. La stringa è formattata in modo tale da poter risalire ad i singoli valori.
     * @return string, stringa formattata.
     */
    public function getSimplifiedString() {
        return strval($this->proiezione->getId()) . "|" . $this->getPosto()->getId() . "|" . $this->getUtente()->getId() . "|" . strval($this->getCosto());
    }

    /**
     * Funzione che permette di risalire al costo del biglietto sulla base della proiezione alla quale si vuoel assistere. Se la proeizione si terrà ad almeno 7 giorni dalla data di acquisto viene applicata una sovrattassa di prenotazione.
     * @param EProiezione $proiezione, proieizone alla quale si vuole assistere
     * @return mixed, costo del biglietto.
     */
    public static function getPrezzofromProiezione(EProiezione $proiezione) {
        $dataProiezione = $proiezione->getDataProiezione();
        $costo = $GLOBALS["prezzi"][$dataProiezione->format("D")];
        $date = new DateTime('now + 7 Days');
        if($dataProiezione > $date) {
            $costo += $GLOBALS["extra"];
        }
        return $costo;
    }

    /**
     * Funzione ausiliaria a usort() neseccaria ad identificare secondo quali criteri eseguire il sorting dell'array di oggetti che gli viene passato. L'array viene sortato in ordine descrescente.
     * @param EBiglietto $b1, generico bilgietto.
     * @param EBiglietto $b2, generico biglietto.
     * @return bool, esito del confronto fra i due oggetti.
     */
    public static function sortByDatesBiglietti(EBiglietto $b1, EBiglietto $b2) {
        return $b1->getProiezione()->getDataProiezione() < $b2->getProiezione()->getDataProiezione();
    }

//------------- ALTRI METODI ----------------

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFUL.
     */
    public function jsonSerialize ()
    {
        return
            [
                'id' => $this->$this->getId(),
                'proiezione'   => $this->getProiezione(),
                'posto' => $this->getPosto(),
                'utente'   => $this->getUtente(),
                'costo' => $this->getCosto(),
            ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Biglietto per il film: " . $this->getProiezione()->getFilm()->getNome() . "al posto " . $this->getPosto();
    }

}