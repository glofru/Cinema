<?php


/**
 * Nella classe Film sono presenti tutti i metodi e gli attributi necessari alla creazione e gestione di un film.
 * Class EFilm
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EFilm implements JsonSerializable
{
    /**
     * Id del film.
     * @var int
     */
    private int $id;
    /**
     * Nome del film.
     * @var string
     */
    private string $nome;
    /**
     * Descrizione del film.
     * @var string
     */
    private string $descrizione;
    /**
     * Durata del film.
     * @var DateInterval
     */
    private DateInterval $durata;
    /**
     * URL con il trailer su Youtube del film.
     * @var string
     */
    private string $trailerURL;
    /**
     * Voto della critica specializzata.
     * @var float
     */
    private float $votoCritica;
    /**
     * Data di rilascio del film.
     * @var DateTime
     */
    private DateTime $dataRilascio;
    /**
     * Genere del film.
     * @var string
     */
    private string $genere;
    /**
     * Insieme dei registi del film.
     * @var array
     */
    private array $registi;
    /**
     * Insieme degli attori che hanno recitato nel film.
     * @var array
     */
    private array $attori;

    /**
     * Paese di produzione del film.
     * @var string
     */
    private string $paese;

    /**
     * Età cosigliata per la visione del film.
     * @var string
     */
    private string $etaConsigliata;

    /**
     * EFilm constructor.
     * @param string $nome, nome dle film.
     * @param string $descrizione, descrizione del film.
     * @param DateInterval $durata, durata del film.
     * @param string $trailerURL, URL del trailer su Youtube del film.
     * @param float $votoCritica, voto della critica specializzata.
     * @param DateTime $dataDiRilascio, data di rilascio del film.
     * @param string $genere, genere dle film.
     * @param string $paese, paese di produzione del film.
     * @param string $etaConsigliata, età consigliata per la visione del film.
     */
    public function __construct(string $nome, string $descrizione, DateInterval $durata, string $trailerURL, float $votoCritica, DateTime $dataDiRilascio, string $genere, string $paese, string $etaConsigliata)
    {
        $this->setNome($nome);
        $this->setDescrizione($descrizione);
        $this->setDurata($durata);
        $this->setTrailerURL($trailerURL);
        $this->setVotoCritica($votoCritica);
        $this->setDataRilascio($dataDiRilascio);
        $this->setGenere($genere);
        $this->setPaese($paese);
        $this->setetaconsigliata($etaConsigliata);
        $this->registi = array();
        $this->attori = array();
    }

    /**
     * @return int, Id del film.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id, id del film sul DB.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string, nome del film.
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome, nome del film.
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string, descrizione del film.
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * @return string, descrizione del film in forma ridotta per adattarsi agli spazi presenti nella pagina.
     */
    public function getDescrizioneHTML(): string {
        if (strlen($this->getDescrizione()) > 249) {
            $temp = substr($this->getDescrizione(),0,249);
            $temp .= "...";
            return $temp;
        }
        else
        {
            return $this->getDescrizione();
        }
    }

    /**
     * @return string, descrizione del film in forma minimale.
     */
    public function getDescrizioneHTMLLess(): string {
        if (strlen($this->getDescrizione()) > 167) {
            $temp = substr($this->getDescrizione(),0,167);
            $temp .= "...";
            return $temp;
        }
        else
        {
            return $this->getDescrizione();
        }
    }
    /**
     * @param string $descrizione, descrizione del film.
     */
    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return DateInterval, durata del film.
     */
    public function getDurata(): DateInterval
    {
        return $this->durata;
    }

    /**
     * @return string, durata nel formato ore:minuti.
     */
    public function getDurataString(): string {
        return $this->getDurata()->format('%h:%I');
    }

    /**
     * @return int, durata del film in minuti.
     */
    public function getDurataMinuti(): int {
        return $this->getDurata()->h * 60 + $this->getDurata()->i;
    }

    /**
     * @return string, data di rilascio nel formato necessario ad essere accettato dagli oggetti 'date' nel HTML.
     */
    public function getDataRliascioForm(): string {
        return $this->getDataRilascio()->format('Y-m-d');
    }

    /**
     * @return string, durata del film nel formato adatto ad essere salvato sul DB.
     */
    public function getDurataDB() : string {
        $durata = explode(":",$this->getDurataString());
        return "PT" . $durata[0] . "H" . $durata[1] . "M";
    }

    /**
     * @param DateInterval $durata, durata del film.
     */
    public function setDurata(DateInterval $durata): void
    {
        $this->durata = $durata;
    }

    /**
     * @return string, trailer del film.
     */
    public function getTrailerURL(): string
    {
        return $this->trailerURL;
    }

    /**
     * @param bool $autoplay, se il trailer debba partire in automatico quando viene caricato l'URL.
     * @return string, stringa contenente l'URL del trailer su Youtube.
     */
    public function getEmbedURL($autoplay = false): string
    {
        $videoID = explode("=", $this->getTrailerURL())[1];
        $url = "https://youtube.com/embed/" . $videoID;
        if ($autoplay)
        {
            $url .= "?autoplay=1&mute=1&enablejsapi=1";
        }
        return $url;
    }

    /**
     * @param string $trailerURL, trailer del film.
     */
    public function setTrailerURL(string $trailerURL): void
    {
        $this->trailerURL = $trailerURL;
    }

    /**
     * @return float, voto della critica specializzata.
     */
    public function getVotoCritica(): float
    {
        return $this->votoCritica;
    }

    /**
     * @param float $votoCritica, voto della critica specializzata.
     */
    public function setVotoCritica(float $votoCritica): void
    {
        $this->votoCritica = $votoCritica;
    }

    /**
     * @return DateTime, data di rilascio del film.
     */
    public function getDataRilascio(): DateTime
    {
        return $this->dataRilascio;
    }

    /**
     * @return string, data di rilascio espressa nel formato giorno-mese-anno
     */
    public function getDataRilascioString(): string {
        return $this->getDataRilascio()->format("d-m-Y");
    }

    /**
     * @return string, data di rilascio espressa nel formato consono ad essere slavata sul DB.
     */
    public function getdataRilascioSQL(): string {
        return $this->getDataRilascio()->format("Y-m-d");
    }

    /**
     * @return int, anno di rilascio del film.
     */
    public function getAnno(): int {
        return intval($this->getDataRilascio()->format("Y"));
    }

    /**
     * @param DateTime $dataRilascio, data di rilascio del film.
     */
    public function setDataRilascio(DateTime $dataRilascio): void
    {
        $this->dataRilascio = $dataRilascio;
    }

    /**
     * @return string, genere del film.
     */
    public function getGenere(): string
    {
        return $this->genere;
    }

    /**
     * @param string $genere, genere del film.
     */
    public function setGenere(string $genere): void
    {
        $this->genere = $genere;
    }

    /**
     * @return array, insieme dei registi del film.
     */
    public function getRegisti(): array
    {
        return $this->registi;
    }

    /**
     * @param EPersona $regista, regista da aggiungere al film.
     */
    public function addRegista(EPersona $regista): void
    {
        if ($regista->isRegista() != true) {
            return;
        }

        array_push($this->registi, $regista);
    }

    /**
     * @return array, insieme di attori che hanno partecipato al film.
     */
    public function getAttori(): array
    {
        return $this->attori;
    }

    /**
     * @param EPersona $attore, attore da aggiungere al film.
     */
    public function addAttore(EPersona $attore): void
    {
        if ($attore->isAttore() != true) {
            return;
        }

        array_push($this->attori, $attore);
    }

    /**
     * @param string $paese, paese di produzione del film.
     */
    public function setPaese(string $paese) {
        $this->paese = $paese;
    }

    /**
     * @return string, paese di produzione del film.
     */
    public function getPaese(): string {
        return $this->paese;
    }

    /**
     * @param $etaConsigliata, età consigliata per la visione del film.
     */
    public function setEtaConsigliata($etaConsigliata) {
        $this->etaConsigliata = $etaConsigliata;
    }

    /**
     * @return string, età consigliata per la visione del film.
     */
    public function getEtaConsigliata(): string {
        return $this->etaConsigliata;
    }

    /**
     * Funzione ausiliaria a usort() neseccaria ad identificare secondo quali criteri eseguire il sorting dell'array di oggetti che gli viene passato. L'array viene sortato in ordine crescente.
     * @param EFilm $f1, generico oggetto film.
     * @param EFilm $f2, generico oggetto film.
     * @return bool, esito del confronto.
     */
    public static function sortByDatesFilm(EFilm $f1, EFilm $f2) {
        return $f1->getDataRilascio() > $f2->getDataRilascio();
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'descrizione' => $this->getDescrizione(),
            'durata' => $this->getDurata()->i,
            'trailerURL' => $this->getTrailerURL(),
            'votoCritica' => $this->getVotoCritica(),
            'dataDiRilascio' => $this->getDataRilascio()->format('d-m-Y'),
            'etaConsigliata' => $this->getEtaConsigliata(),
            'paese' => $this->getPaese(),
            'genere' => $this->getGenere(),
            'attori' => $this->getAttori(),
            'registi' => $this->getRegisti()
        ];
    }
}