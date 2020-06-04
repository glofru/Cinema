<?php
class CFilm
{
    public static function show()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $pm = FPersistentManager::getInstance();
            $filmID = $_GET["film"];
            $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];
            $film = $pm->load($filmID, "id", "EFilm")[0];
            $gestore = EHelper::getInstance();
            $cookie = $gestore->preferences($_COOKIE['preferences']);
            $gestore->setPreferences($film->getGenere(), $cookie);
            unset($cookie);

            $filmC = $pm->load($film->getGenere(), "Genere", "EFilm");
            foreach ($filmC as $key => $f) {
                if ($f->getId() == $filmID) {
                    unset($filmC[$key]);
                }
            }

            $filmC = array_values($filmC);
            if (sizeof($filmC) > 6) {
                $filmC = array_slice($filmC, 0, 6);
            }
            $copertina = $pm->load($filmID, "idFilm", "EMediaLocandina");

            $locandine = [];
            foreach ($filmC as $loc) {
                array_push($locandine, $pm->load($loc->getId(), "idFilm", "EMediaLocandina"));
            }

            $reviews = self::getReview($pm, $filmID, $gestore);

            $programmazioneFilm = self::getProgrammazione($pm, $gestore, $filmID);

            $utente = CUtente::getUtente();
            $isAdmin = $utente !== null && $utente->isAdmin();

            VFilm::show($film, $autoplay, $copertina, $filmC, $locandine, $reviews[0], $reviews[1], $programmazioneFilm, $reviews[2], $utente, $isAdmin);
        } else {
            CMain::methodNotAllowed();
        }
    }

    private static function getReview(FPersistentManager $pm, $filmID, EHelper $gestore) {
        $reviews = $pm->load($filmID,"idFilm","EGiudizio");
        $film = $pm->load($filmID,"id","EFilm")[0];
        $utente = CUtente::getUtente();

        if(CUtente::isLogged()){
            $canWrite = $gestore->checkWrite($utente, $reviews, $film);
        } else {
            $canWrite = false;
        }

        $img = [];
        foreach($reviews as $loc) {
            $temp = $pm->load($loc->getUtente()->getId(),"idUtente","EMediaUtente");
            if($temp->getImmagine() == ""){
                $temp->setImmagine('../../Smarty/img/user.png');
            }
            array_push($img,$temp);
        }

        $result = [];
        array_push($result, $reviews, $img, $canWrite);
        return $result;
    }

    private static function getProgrammazione(FPersistentManager $pm, EHelper $gestore, string $filmID): EProgrammazioneFilm {
        $elenco = $pm->load($filmID, "idFilm", "EProiezione");
        $programmazioneFilm = $elenco->getElencoProgrammazioni()[0];
        if (!isset($programmazioneFilm)){
            $programmazioneFilm = new EProgrammazioneFilm();
        }
        return $gestore->programmazione($programmazioneFilm);
    }
}