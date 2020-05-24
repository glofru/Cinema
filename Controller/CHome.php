<?php

class CHome
{

    public static function showHome() {
        $pm = FPersistentManager::getInstance();
        $gestore = EHelper::getInstance();
        $date = $gestore->getDateProssime();
        $filmProssimi = $pm->loadBetween($date[0],$date[1],"EFilm");
        $immaginiProssimi = [];
        foreach($filmProssimi as $film){
            array_push($immaginiProssimi,$pm->load($film->getId(),"idFilm","EMedia"));
        }
        $date = $gestore->getSettimana();
        $temp = $pm->loadBetween($date[0],$date[1],"EProiezione");
        $filmProiezioni = [];
        $immaginiProiezioni = [];
        foreach($temp as $pro){
            $found = false;
            foreach($filmProiezioni as $film){
                if($pro->getFilm()->getNome() == $film->getNome())
                    $found = true;
            }
            if(!$found)        
                array_push($filmProiezioni,$pro->getFilm());
        }
        foreach($filmProiezioni as $film){
            array_push($immaginiProiezioni,$pm->load($film->getId(),"idFilm","EMedia"));
        }
        $pm = FPersistentManager::getInstance();
        $date = $gestore->getDatePassate();
        $filmConsigliati = $pm->loadBetween($date[0],$date[1],"EFilm");
        $immaginiConsigliati = [];
        foreach($filmConsigliati as $film){
            array_push($immaginiConsigliati,$pm->load($film->getId(),"idFilm","EMedia"));
        }
        $home = new VHome();
        $home->showHome($filmProssimi, $immaginiProssimi, $filmConsigliati, $immaginiConsigliati, $filmProiezioni, $immaginiProiezioni, "alessio");
    }
}
?>