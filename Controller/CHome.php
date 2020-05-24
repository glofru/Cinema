<?php

class CHome
{

    public static function showHome() {
        $pm = FPersistentManager::getInstance();
        $oggi = new DateTime('now');
        $oggi = $oggi->format('Y-m-d');
        $filmProssimi = $pm->loadBetween($oggi,'2100-01-01',"EFilm");
        $immaginiProssimi = [];
        foreach($filmProssimi as $film){
            array_push($immaginiProssimi,$pm->load($film->getId(),"idFilm","EMediaLocandina"));
        }
        $oggi = new DateTime('tomorrow');
        $week = new DateInterval('P6D');
        $fine = $oggi->add($week);
        $temp = $pm->loadBetween($oggi->format('Y-m-d'),$fine->format('Y-m-d'),"EProiezione");
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
        $oggi = new DateTime('first day of this month - 2 weeks');
        $oggi = $oggi->format('Y-m-d');
        $filmConsigliati = $pm->loadBetween("0000-00-00",$oggi,"EFilm");
        $immaginiConsigliati = [];
        foreach($filmConsigliati as $film){
            array_push($immaginiConsigliati,$pm->load($film->getId(),"idFilm","EMedia"));
        }
        $home = new VHome();
        $home->showHome($filmProssimi, $immaginiProssimi, $filmConsigliati, $immaginiConsigliati, $filmProiezioni, $immaginiProiezioni, "alessio");
    }
}
?>