<?php

/**
 * Nella classe film troviamo i metodi necessari a poter reperire tutte le informazioni su di un film.
 * Class CFilm
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CFilm
{
    /**
     * Funzione accessibile solo via GET che reperisce, dato l'id di un film, tutte le informazioni sul film e la relativa locandina. Si appoggia a getReview e getProgrammazione per completare l'operazione.
     * Inoltre la funzione incrementa, fra le preferenze dell'utente, le visite al genere del film caricato per poi salvare le preferenze aggiornate nel cookie.
     */
    public static function show()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $pm = FPersistentManager::getInstance();

            $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];

            $film = $pm->load($_GET["film"], "id", "EFilm")[0];

            CUtente::getUtente()->incrementPreference($film->getGenere(), unserialize($_COOKIE['preferences']));
            setcookie("preferences", serialize(CUtente::getUtente()->getPreferencesArray()), 86400 * 30, '/');

            $filmC = $pm->load($film->getGenere(), "Genere", "EFilm");
            foreach ($filmC as $key => $f) {
                if ($f->getId() == $film->getId()) {
                    unset($filmC[$key]);
                }
            }

            $filmC = array_values($filmC);
            if (sizeof($filmC) > 6) {
                $filmC = array_slice($filmC, 0, 6);
            }

            $copertina = $pm->load($film->getId(), "idFilm", "EMediaLocandina");

            $locandine = [];
            foreach ($filmC as $loc) {
                array_push($locandine, $pm->load($loc->getId(), "idFilm", "EMediaLocandina"));
            }

            $programmazioneFilm = self::getProgrammazione($film);

            $utente = CUtente::getUtente();
            $isAdmin = $utente !== null && $utente->isAdmin();

            $reviews = self::getReview($film, $utente);

            VFilm::show($film, $autoplay, $copertina, $filmC, $locandine, $reviews[0], $reviews[1], $programmazioneFilm, $reviews[2], $utente);
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di indivdua se l'utente che ha richiesto la pagina del film possa o meno rilasciare un commento.
     * Solo gli utenti registrati possono rilasciare in commento e solo uno per film.
     * Inoltre carica tutti i commenti espressi sul film e le immagini del rpofilo degli utenti che hanno espresso uno di questi giudizi.
     *
     * @param EFilm $film, film di cui si vogliono reperire i giudizi.
     * @param $utente, l'utente che ha richiesto la pagina.
     * @return array, array contenente l'insieme dei giudizi l'insieme delle immagini del profilo degli utenti che hanno espresso un giudizio ed un booleano per indicare se l'utente possa o meno esprirere un giudizio sul film.
     */
    private static function getReview(EFilm $film, $utente) {
        $reviews = FPersistentManager::getInstance()->load($film->getId(), "idFilm", "EGiudizio");

        $canWrite = false;

        if(CUtente::isLogged() && !$utente->isAdmin()){
            $data = $film->getDataRilascio();
            $today = new DateTime('now + 1 Week');

            if($data < $today) {
                $canWrite = true;
                foreach($reviews as $r) {
                    if($r->getUtente()->getId() === $utente->getId()){
                        $canWrite = false;
                        break;
                    }
                }
            }
        }

        $img = [];
        foreach($reviews as $loc) {
            $temp = FPersistentManager::getInstance()->load($loc->getUtente()->getId(),"idUtente","EMediaUtente");
            array_push($img,$temp);
        }

        $result = [];
        array_push($result, $reviews, $img, $canWrite);
        return $result;
    }

    /**
     * Funzione che permette, dato un film, di recuperarne le proiezioni. Una volta recuperate viene controllato se l'orario di inizio di quetse non sia già stato passato.
     * Lasciando come risultato un oggetto EProgrammazioneFilm con le proieizoni non ancora avvenute del film indicato.
     * @param EFilm $film, film dal quale reperire le proiezioni.
     * @return EProgrammazioneFilm, insieme delle proiezioni non ancora avvenute.
     */
    private static function getProgrammazione(EFilm $film): EProgrammazioneFilm {
        $elenco = FPersistentManager::getInstance()->load($film->getId(), "idFilm", "EProiezione");
        $programmazioneFilm = $elenco->getElencoProgrammazioni()[0];
        if (!isset($programmazioneFilm)){
            $programmazioneFilm = new EProgrammazioneFilm();
        }
        return EProgrammazioneFilm::amIStillGood($programmazioneFilm);
    }

    /**
     * Funzione che permette, dato un film, di ottenerne la media dei giudizi dell'utenza e la relativa locandina.
     * @param array $film, film di cui si vogliono ottenere i dati.
     * @return array, insieme contenente la locandina
     */
    public static function getFilmData(array $film): array {
        $result = [];

        $pm = FPersistentManager::getInstance();

        $punteggi = [];
        $immaginiCercate = [];
        $giudizi = [];

        foreach($film as $f) {
            array_push($immaginiCercate, $pm->load($f->getId(), "idFilm", "EMedia"));
            array_push($giudizi, $pm->load($f->getId(), "idFilm", "EGiudizio"));
        }

        foreach($giudizi as $g) {
            if(sizeof($g) > 0) {
                $p = EGiudizio::getMedia($g);
            }
            else {
                $p = 0;
            }
            array_push($punteggi, $p);
        }

        if(sizeof($giudizi) == 0) {
            array_push($punteggi, 0);
        }

        array_push($result, $immaginiCercate, $punteggi);
        return $result;
    }
}