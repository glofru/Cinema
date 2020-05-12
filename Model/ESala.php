<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per creare una sala per il cinema
 * I suoi attributi sono i seguenti:
 * - numero: valore numerico che identifica la sala;
 * - posti: array di posti contenente tutti i possibili posti a sedere presenti in sala;
 * - numeroposti: valore numerico che identifica la capienza della sala;
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ESala implements JsonSerializable
{
    /**
    * Numero identificativo della sala
    * @AttributeType int
    */
    private int $numero;
    /**
     * Insieme dei posti presenti in sala
     * @AttributeType array
     */
    private array $posti;
    /**
     * Numero di posti presenti in sala
     * @AttributeType int
     */
    private int $numeroposti;

    public function __construct($numero,$nfile,$nposti) {
        $this->numero=$numero;
        $i=1;
        $value = 64;
        while($i <= $nfile){
            $j = 1;
            while($j < $nposti){
                array_push($this->posti,new EPosto(chr($value+$i),$j));
                $j += 1;
            }
            $i += 1;
        }
        $this->numeroposti = $nfile * $nposti;
    }

//-------------- SETTER ----------------------
    /**
     * @param int $numero numero identificativo della sala
     */
    public function setNumero(int $numero){
        $this->numero = $numero;
    }

    /**
     * @param array $posti insieme dei posti a sedere presenti in sala
     */
    public function setPosti(array $posti){
        $this->posti = $posti;
    }

    /**
     * @param int $numeroposti numero complessivo dei posti a sedere in sala
     */
    public function setNumeroposti(int $numeroposti){
        $this->numeroposti = $numeroposti;
    }

//----------------- GETTER --------------------
    /**
     * @return int numero di sala
     */
    public function getNumero(): int {
        return $this->numero;
    }

    /**
     * @return array posti a sedere nella sala
     */
    public function getPosti(): array {
        return $this->posti;
    }

    /**
     * @return int numero complessivo di posti in sala
     */
    public function getNumeroposti(): int {
        return $this->numeroposti;
    }

//------------- ALTRI METODI ----------------
    public function jsonSerialize () {
        return
            [
                'numero'   => $this->getNumero(),
                'posti' => $this->getPosti(),
                'numeroposti'   => $this->getNumeroposti(),
            ];
    }

    /**
     * Controlla se un posto è presente realmente nella sala gestita
     * @param EPosto $posto posto che si vuole controllare
     * @return int indice del posto nell'array dei posti in sala
     */
    public function esiste(EPosto $posto): int {
        $result = array_search($posto,$this->getPosti());
        if ($result === "") {
            return -1;
        } else {
            return $result;
        }
    }

    /**
     * Controlla se un posto è libero in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function isPostolibero(EPosto $posto): string
    {
        $result = $this->esiste($posto);
        if ($result === -1) {
            return "Posto non presente in sala";
        }
        if ($this->getPosti()[$result]->getOccupato()) {
            return "false";
        } else {
            return "true";
        }
    }
    /**
     * Controlla se un posto è occupato o meno in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function occupaPosto(EPosto $posto): bool
    {
        if ($this->isPostolibero($posto) == "true") {
            $result = array_search($posto, $this->getPosti());
            $this->getPosti()[$result]->setOccupato(false);
        } else {
            return false;
        }
    }
    /**
     * Controlla se un posto è occupato in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato booleano del controllo
     */
    public function liberaPosto(EPosto $posto): bool
    {
        if ($this->isPostolibero($posto) === "false") {
            $result = array_search($posto, $this->getPosti());
            $this->getPosti()[$result]->setOccupato(true);
        } else {
            return false;
        }
    }
    /**
     * Conta il numero dei posti liberi in sala
     * @return int numero dei posti liberi in sala
     */
    public function postiLiberi(): int{
        $count = 0;
        foreach ($this->getPosti() as $elem){
            if($elem->getOccupato() === false){
                $count += 1;
            }
        }
        return $count;
    }
    /**
     * Conta il numero dei posti occupati in sala
     * @return int numero dei posti occupati in sala
     */
    public function postiOccupati(): int{
        return $this->getNumeroPosti() - $this->postiLiberi();
    }

    /**
     * @return string
     */
    public function __toString(){
        return "La sala " . $this->getNumero() . "ha " . $this->getNumeroposti() . " posti.";
    }
}