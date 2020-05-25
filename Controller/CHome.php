<?php
class CHome
{

    public static function showHome() {
        $pm = FPersistentManager::getInstance();
        $gestore = EHelper::getInstance();
        $cookie = $gestore->preferences($_COOKIE['preferences']);
        $prossimi = self::getProssimi($pm, $gestore);
        $consigliati = self::getConsigliati($pm, $gestore, $cookie);
        $proiezioni = self::getProiezioni($pm, $gestore);
        $prossima = self::getProiezioniProssima($pm, $gestore);
        $scorsa = self::getProiezioniScorsa($pm, $gestore);
        $home = new VHome();
        $home->showHome($prossimi[0], $prossimi[1], $consigliati[0], $consigliati[1], $proiezioni[0], $proiezioni[1], $scorsa[0], $scorsa[1], $prossima[0], $prossima[1], "alessio");
    }

    private static function getProssimi(FPersistentManager $pm, EHelper $gestore) {
        $date = $gestore->getDateProssime();
        $filmProssimi = $pm->loadBetween($date[0],$date[1],"EFilm");
        $immaginiProssimi = [];
        foreach($filmProssimi as $film){
            array_push($immaginiProssimi,$pm->load($film->getId(),"idFilm","EMedia"));
        }
        $result = [];
        array_push($result,$filmProssimi,$immaginiProssimi);
        return $result;
    }

    private static function getConsigliati(FPersistentManager $pm, EHelper $gestore, $cookie) { 
        $result = [];
        if($gestore->getPreferences($cookie) === true){
            $date = $gestore->getDatePassate();
            $filmConsigliati = $pm->loadBetween($date[1],$date[0],"EFilm");
            shuffle($filmConsigliati);
            if(sizeof($filmConsigliati) > 6) {
                $filmConsigliati = array_slice($filmConsigliati,0,6);
            }
        }
        else {
            $filmConsigliati = [];
            foreach($cookie as $key => $c) {
                if($c !== 0) {
                    $f = $pm->load($key,"Genere","EFilm");
                    shuffle($f);
                    if(sizeof($f) > $c);
                        {$f = array_slice($f,0,$c);}
                    foreach($f as $elem){
                        array_push($filmConsigliati,$elem);
                    }
                }
            }
        }
        $immaginiConsigliati = [];
        foreach($filmConsigliati as $film){
            array_push($immaginiConsigliati,$pm->load($film->getId(),"idFilm","EMedia"));
        }
        array_push($result,$filmConsigliati,$immaginiConsigliati);
        return $result;
    }

    public static function getProiezioni(FPersistentManager $pm, EHelper $gestore) {
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
        $result = [];
        array_push($result,$filmProiezioni,$immaginiProiezioni);
        return $result;
    }

    public static function getProiezioniProssima(FPersistentManager $pm, EHelper $gestore) {
        $date = $gestore->getSettimanaProssima();
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
        $result = [];
        array_push($result,$filmProiezioni,$immaginiProiezioni);
        return $result;
    }

    public static function getProiezioniScorsa(FPersistentManager $pm, EHelper $gestore) {
        $date = $gestore->getSettimanaScorsa();
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
        $result = [];
        array_push($result,$filmProiezioni,$immaginiProiezioni);
        return $result;
    }
}
?>