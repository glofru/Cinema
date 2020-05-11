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

    public function __construct($numero,$nfile,$nposti){
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
    public function jsonSerialize ()
    {
        return
            [
                'numero'   => $this->getNumero(),
                'posti' => $this->getPosti(),
                'numeroposti'   => $this->getNumeroposti(),
            ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "La sala " . $this->getNumero() . "ha " . $this->getNumeroposti() . " posti.";
    }
}