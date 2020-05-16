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
class ESalaVirtuale implements JsonSerializable
{
    /**
    * Numero identificativo della sala
    * @AttributeType int
    */
    private int $numeroSala;
    /**
     * Insieme dei posti presenti in sala
     * @AttributeType array
     */
    private array $posti;
    /**
     * @AttributeType int
     */
    private int $nFile;
    /**
     * @var int
     */
    private int $nPostiFila;

    /**
     * ESalaVirtuale constructor.
     * @param int $numeroSala
     * @param int $nFile
     * @param int $nPostiFila
     */
    public function __construct(int $numeroSala, int $nFile, int $nPostiFila) {
        $this->setNumeroSala($numeroSala);
        $this->init($nFile, $nPostiFila);
    }

    /**
     * @param ESalaFisica $salaFisica
     * @return ESalaVirtuale
     */
    public static function fromSalaFisica(ESalaFisica $salaFisica): ESalaVirtuale
    {
        return new ESalaVirtuale($salaFisica->getNumeroSala(), $salaFisica->getNFile(), $salaFisica->getNPostiFila());
    }

    /**
     * @param $nFile
     * @param $nPostiFila
     */
    private function init($nFile, $nPostiFila) {
        $this->posti = array();
        $value = 64; //64 = A
        for ($i = 0; $i < $nFile; $i++) {
            for ($j = 0; $j < $nPostiFila; $j++) {
                array_push($this->posti, new EPosto(chr($value + $i), $j));
            }
        }
    }

//-------------- SETTER ----------------------

    /**
     * @param int $numeroSala
     */
    public function setNumeroSala(int $numeroSala){
        $this->numeroSala = $numeroSala;
    }

//----------------- GETTER --------------------
    /**
     * @return int numero di sala
     */
    public function getNumeroSala(): int {
        return $this->numeroSala;
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
    public function getNumeroPosti(): int {
        return $this->nFile * $this->nPostiFila;
    }

    /**
     * @return int
     */
    public function getNFile(): int
    {
        return $this->nFile;
    }

    /**
     * @return int
     */
    public function getNPostiFila(): int
    {
        return $this->nPostiFila;
    }

//------------- ALTRI METODI ----------------

    /**
     * @return array|mixed
     */
    public function jsonSerialize () {
        return
            [
                'numero'   => $this->getNumeroSala(),
                'posti' => $this->getPosti(),
                'nFile' => $this->getNFile(),
                'nPostiFila' => $this->getNPostiFila()
            ];
    }

    /**
     * Controlla se un posto è presente realmente nella sala gestita
     * @param EPosto $posto posto che si vuole controllare
     * @return int indice del posto nell'array dei posti in sala
     */
    public function esiste(EPosto $posto): int {
        $result = array_search($posto,$this->getPosti());
        if ($result !== "") {
            return $result;
        }

        return -1;
    }

    /**
     * Controlla se un posto è libero in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato del controllo
     */
    public function isPostolibero(EPosto $posto): bool
    {
        $result = $this->esiste($posto);
        if ($result === -1) {
            echo "errore";
            return false;
        }

         return $this->getPosti()[$result]->getOccupato();
    }
    /**
     * Controlla se un posto è occupato o meno in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function occupaPosto(EPosto $posto): bool
    {
        if ($this->isPostolibero($posto) == true) {
            $result = array_search($posto, $this->getPosti());
            $this->getPosti()[$result]->setOccupato(false);
            return true;
        }

        return false;
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
            return true;
        }

        return false;
    }
    /**
     * Conta il numero dei posti liberi in sala
     * @return int numero dei posti liberi in sala
     */
    public function getPostiLiberi(): int{
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
        return $this->getNumeroPosti() - $this->getPostiLiberi();
    }

    /**
     * @return string
     */
    public function __toString(){
        return "La sala " . $this->getNumeroSala() . "ha " . $this->getNumeroPosti() . " posti.";
    }
}