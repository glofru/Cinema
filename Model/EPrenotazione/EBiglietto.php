<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione di un biglietto
 * I suoi attributi sono i seguenti:
 * - proiezione: oggetto contenente la proiezione alla quale si vuole partecipare
 * - posto: il posto che si vuole acquistare
 * - utente: oggetto contente le informazioni sull'utente che acquista il biglietto
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EBiglietto implements JsonSerializable
{
    /**
     * Proiezione alla quale si vuole assistere
     * @AttributeType EProiezione
     */
    private EProiezione $proiezione;
    /**
     * Posto che si vuole prendere
     * @AttributeType EPosto
     */
    private EPosto $posto;
    /**
     * Utente che effettua l'acquisto
     * @AttributeType EUtente
     */
    private EUtente $utente;

    private float $costo;

    public function __construct(EProiezione $proiezione, EPosto $posto, EUtente $utente, float $costo)
    {
        $this->setProiezione($proiezione);
        $this->setPosto($posto);
        $this->setUtente($utente);
        $this->setCosto($costo);
    }

//-------------- SETTER ----------------------
    /**
     * @param EProiezione $proiezione proiezione alla quale si vuole assistere
     */
    public function setProiezione(EProiezione $proiezione){
        $this->proiezione = $proiezione;
    }
    /**
     * @param EPosto $posto posto che si sceglie di acquistare
     */
    public function setPosto(EPosto $posto){
    $this->posto = $posto;
    }
    /**
     * @param EUtente $utente utente che acquista il biglietto
     */
    public function setUtente(EUtente $utente){
        $this->utente = $utente;
    }

    public function setCosto(float $costo){
        $this->costo = $costo;
    }

//----------------- GETTER --------------------
    /**
     * @return EProiezione la proiezione alla quale si vuole assistere
     */
    public function getProiezione(): EProiezione{
        return $this->proiezione;
    }
    /**
     * @return EPosto il posto che si vuole prendere
     */
    public function getPosto(): EPosto{
        return $this->posto;
    }
    /**
     * @return EUtente l'utente che effettua l'operazione
     */
    public function getUtente() : EUtente{
        return $this->utente;
    }

    public function getCosto(): float{
        return $this->costo;
    }

    public function getSimplifiedString() {
        return strval($this->proiezione->getId()) . "|" . $this->getPosto()->getId() . "|" . $this->getUtente()->getId() . "|" . strval($this->getCosto());
    }
//------------- ALTRI METODI ----------------
    public function jsonSerialize ()
    {
        return
            [
                'proiezione'   => $this->getProiezione(),
                'posto' => $this->getPosto(),
                'utente'   => $this->getUtente(),
            ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Biglietto per il film: " . $this->getProiezione() . "al posto " . $this->getPosto();
    }

}