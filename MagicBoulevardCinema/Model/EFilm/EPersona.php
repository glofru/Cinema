<?php


/**
 *  * Nella classe Biglietto sono i presenti attributi e metodi per la creazione e la gestione di una persona. Ovvero un attore o un regsita.
 * Class EPersona
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EPersona implements JsonSerializable
{
    /**
     * Id della persona.
     * @var int
     */
    private int $id = 0;
    /**
     * Nome della persona.
     * @var string,
     */
    private string $nome;
    /**
     * Cognome della persona.
     * @var string
     */
    private string $cognome;
    /**
     * URL del sito IMDB per reperire maggiori informazioni sulla persona.
     * @var string
     */
    private string $imdbUrl;
    /**
     * Identifica se la persona è un attore.
     * @var bool
     */
    private bool $isAttore;
    /**
     * Identifica se la persona è un regista.
     * @var bool
     */
    private bool $isRegista;

    /**
     * EPersona constructor.
     * @param string $nome, nome della persona.
     * @param string $cognome, cognome della persona.
     * @param string $imdbUrl, URL del sito IMDB.
     * @param bool $isAttore, se la persona è un attore.
     * @param bool $isRegista, se la persona è un regista.
     */
    public function __construct(string $nome, string $cognome, string $imdbUrl, bool $isAttore, bool $isRegista) {
        $this->setNome($nome);
        $this->setCognome($cognome);
        $this->setImdbUrl($imdbUrl);
        $this->setIsAttore($isAttore);
        $this->setIsRegista($isRegista);
    }

    /**
     * @return int, id della persona.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id, id della persona.
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string, nome della persona.
     */
    public function getNome(): string {
        return $this->nome;
    }

    /**
     * @param string $nome, nome della persona.
     */
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    /**
     * @return string, cognome della persona.
     */
    public function getCognome(): string {
        return $this->cognome;
    }

    /**
     * @param string $cognome, cognome della persona.
     */
    public function setCognome(string $cognome): void {
        $this->cognome = $cognome;
    }

    /**
     * @return string, nome e cognome della persona.
     */
    public function getFullName(): string {
        return $this->getNome() . " " . $this->getCognome();
    }

    /**
     * @return string, URL del sito IMDB.
     */
    public function getImdbUrl(): string {
        return $this->imdbUrl;
    }

    /**
     * @return string, id della persona nel sito IMDB. Necessario per evitare che gli omonimi possano rendere impossibile distinguere due persone.
     */
    public function getImdbId(): string {
        $x = explode("/",$this->getImdbUrl());

        return $x[sizeof($x)-2];
    }

    /**
     * @param string $imdbUrl, URL del sito IMDB.
     */
    public function setImdbUrl(string $imdbUrl): void {
        $this->imdbUrl = $imdbUrl;
    }

    /**
     * @return bool, se la persona è un attore.
     */
    public function isAttore(): bool {
        return $this->isAttore;
    }

    /**
     * @param bool $isAttore, se la persona è un attore.
     */
    public function setIsAttore(bool $isAttore): void {
        $this->isAttore = $isAttore;
    }

    /**
     * @return bool, se la persona è un regista.
     */
    public function isRegista(): bool {
        return $this->isRegista;
    }

    /**
     * @param bool $isRegista, se la persona è un regista.
     */
    public function setIsRegista(bool $isRegista): void {
        $this->isRegista = $isRegista;
    }

    /**
     * @return mixed|void, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFUL.
     */
    public function jsonSerialize() {
        return [
            'nome'      => $this->getNome(),
            'cognome'   => $this->getCognome(),
            'imdbUrl'   => $this->getImdbUrl(),
            'isAttore'  => $this->isAttore(),
            'isRegista' => $this->isRegista()
        ];
    }
}