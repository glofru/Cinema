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
     * proiezione alla quale si vuole assistere
     * @AttributeType EProiezione
     */
    private EProiezione $proiezione;
    /**
     * posto che si vuole prendere
     * @AttributeType EPosto
     */
    private EPosto $posto;
    /**
     * utente che effettua l'acquisto
     * @AttributeType EUtente
     */
    private EUtente $utente;

    public function __construct(EProiezione $proiezione, EPosto $posto, EUtente $utente)
    {
        $this->proiezione = $proiezione;
        $this->posto = $posto;
        $this->utente = $utente;
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



}