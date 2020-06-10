<?php
class CFilm
{
    public static function show()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $pm = FPersistentManager::getInstance();

            $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];

            $film = $pm->load($_GET["film"], "id", "EFilm")[0];

            $gestore = EHelper::getInstance();
            $cookie = $gestore->preferences($_COOKIE['preferences']);
            $gestore->setPreferences($film->getGenere(), $cookie);

            unset($cookie);

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

            VFilm::show($film, $autoplay, $copertina, $filmC, $locandine, $reviews[0], $reviews[1], $programmazioneFilm, $reviews[2], $utente, $isAdmin);
        } else {
            CMain::methodNotAllowed();
        }
    }

    private static function getReview(EFilm $film, $utente) {
        $reviews = FPersistentManager::getInstance()->load($film->getId(), "idFilm", "EGiudizio");

        $canWrite = false;

        if(CUtente::isLogged()){
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
            //TODO: muovere in foundation!!!
            if($temp->getImmagine() == ""){
                $temp->setImmagine('../../Smarty/img/user.png');
            }

            array_push($img,$temp);
        }

        $result = [];
        array_push($result, $reviews, $img, $canWrite);
        return $result;
    }

    private static function getProgrammazione(EFilm $film): EProgrammazioneFilm {
        $elenco = FPersistentManager::getInstance()->load($film->getId(), "idFilm", "EProiezione");
        $programmazioneFilm = $elenco->getElencoProgrammazioni()[0];
        if (!isset($programmazioneFilm)){
            $programmazioneFilm = new EProgrammazioneFilm();
        }
        return EHelper::getInstance()->programmazione($programmazioneFilm);
    }
}