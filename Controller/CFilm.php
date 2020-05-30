<?php
class CFilm
{
    public static function show()
    {
        $pm = FPersistentManager::getInstance();
        $filmID = $_GET["film"];
        $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];
        $film = $pm->load($filmID, "id", "EFilm")[0];
        $gestore = EHelper::getInstance();
        $cookie = $gestore->preferences($_COOKIE['preferences']);
        $gestore->setPreferences($film->getGenere(),$cookie);
        unset($cookie);

        $filmC = $pm->load($film->getGenere(),"Genere","EFilm");
        foreach($filmC as $key => $f) {
            if ($f->getId() == $filmID) {
                unset($filmC[$key]);
            }
        }

        $filmC = array_values($filmC);
        if(sizeof($filmC) > 6){
            $filmC = array_slice($filmC,0,6);
        }
        $copertina = $pm->load($filmID,"idFilm","EMediaLocandina");

        $locandine = [];
        foreach($filmC as $loc) {
            array_push($locandine,$pm->load($loc->getId(),"idFilm","EMediaLocandina"));
        }

        $rvw = self::getReview($pm, $filmID, $gestore);

        $pro = self::getProiezioni($pm, $gestore, $filmID);
        $utente = CUtente::getUtente();
        $isAdmin = $utente !== null && $utente->isAdmin();

        VFilm::show($film, $autoplay, $copertina, $filmC, $locandine, $rvw[0], $rvw[1], $pro, $rvw[2], $utente, $isAdmin);
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

    private static function getProiezioni(FPersistentManager $pm, EHelper $gestore, $filmID): array {
        $elenco = $pm->load($filmID, "idFilm", "EProiezione");
        $film = $pm->load($filmID, "id","EFilm")[0];
        $proiezionifilm = $elenco->getElencoprogrammazioni()[0];
        return $gestore->programmazione($proiezionifilm, $film);
    }
}