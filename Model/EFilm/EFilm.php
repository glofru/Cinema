<?php


/**
 * Class EFilm
 */
class EFilm implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $nome;
    /**
     * @var string
     */
    private string $descrizione;
    /**
     * @var DateInterval
     */
    private DateInterval $durata;
    /**
     * @var string
     */
    private string $trailerURL;
    /**
     * @var float
     */
    private float $votoCritica;
    /**
     * @var DateTime
     */
    private DateTime $dataRilascio;
    /**
     * @var string
     */
    private string $genere;
    /**
     * @var array
     */
    private array $registi;
    /**,
     * @var array
     */
    private array $attori;

    /**
     * EFilm constructor.
     * @param int $id
     * @param string $nome
     * @param string $descrizione
     * @param DateInterval $durata
     * @param string $trailerURL
     * @param float $votoCritica
     * @param DateTime $dataDiRilascio
     * @param EGenere $genere
     */
    public function __construct(string $nome, string $descrizione, DateInterval $durata, string $trailerURL, float $votoCritica, DateTime $dataDiRilascio, string $genere)
    {
        $this->setNome($nome);
        $this->setDescrizione($descrizione);
        $this->setDurata($durata);
        $this->setTrailerURL($trailerURL);
        $this->setVotoCritica($votoCritica);
        $this->setDataRilascio($dataDiRilascio);
        $this->setGenere($genere);
        $this->registi = array();
        $this->attori = array();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * @param string $descrizione
     */
    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return DateInterval
     */
    public function getDurata(): DateInterval
    {
        return $this->durata;
    }

    public function getDurataString() : string {
        return $this->getDurata()->format('%h:%I');
    }

    public function getDurataMinuti() {
        return $this->getDurata()->m;
    }

    public function getDurataDB() : string {
        $durata = explode(":",$this->getDurataString());
        return "PT" . $durata[0] . "H" . $durata[1] . "M";
    }

    /**
     * @param DateInterval $durata
     */
    public function setDurata(DateInterval $durata): void
    {
        $this->durata = $durata;
    }

    /**
     * @return string
     */
    public function getTrailerURL(): string
    {
        return $this->trailerURL;
    }

    public function getEmbedURL(): string
    {
        $videoID = explode("=", $this->getTrailerURL())[1];
        return "https://youtube.com/embed/" . $videoID;
    }

    /**
     * @param string $trailerURL
     */
    public function setTrailerURL(string $trailerURL): void
    {
        $this->trailerURL = $trailerURL;
    }

    /**
     * @return float
     */
    public function getVotoCritica(): float
    {
        return $this->votoCritica;
    }

    /**
     * @param float $votoCritica
     */
    public function setVotoCritica(float $votoCritica): void
    {
        $this->votoCritica = $votoCritica;
    }

    /**
     * @return DateTime
     */
    public function getDataRilascio(): DateTime
    {
        return $this->dataRilascio;
    }

    public function getDataRilascioString(): string {
        return $this->getDataRilascio()->format("d-m-Y");
    }

    public function getdataRilascioSQL(): string {
        return $this->getDataRilascio()->format("Y-m-d");
    }

    public function getAnno(): int {
        return intval($this->getDataRilascio()->format("Y"));
    }

    /**
     * @param DateTime $dataRilascio
     */
    public function setDataRilascio(DateTime $dataRilascio): void
    {
        $this->dataRilascio = $dataRilascio;
    }

    /**
     * @return string
     */
    public function getGenere(): string
    {
        return $this->genere;
    }

    /**
     * @param string $genere
     */
    public function setGenere(string $genere): void
    {
        $this->genere = $genere;
    }

    /**
     * @return array
     */
    public function getRegisti(): array
    {
        return $this->registi;
    }

    /**
     * @param EPersona $regista
     */
    public function addRegista(EPersona $regista): void
    {
        if ($regista->isRegista() != true) {
            //TODO: So cazzi
        } else {
            array_push($this->registi, $regista);
        }
    }

    /**
     * @return array
     */
    public function getAttori(): array
    {
        return $this->attori;
    }

    /**
     * @param EPersona $attore
     */
    public function addAttore(EPersona $attore): void
    {
        if ($attore->isAttore() != true) {
            //TODO: So cazzi di nuovo
        } else {
            array_push($this->attori, $attore);
        }
    }

    /**
     * @return array|mixed
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
            'genere' => $this->getGenere(),
            'attori' => $this->getAttori(),
            'registi' => $this->getRegisti()
        ];
    }
}