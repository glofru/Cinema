<?php

/**
 * La claase Film permette di visualizzare la schermata con tutte le informazioni su di un film.
 * Class VFilm
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package view
 */
class VFilm
{
    /**
     * Funzione che mostra tutti i dettagli su di un film.
     * @param EFilm $film, film da mostrare.
     * @param bool $autoplay, se il trailer del film debba partire in automatico appena caricata la pagina.
     * @param EMedia $copertina, locandina del film.
     * @param array $filmconsigliati, film consigliati sulla base del genere del film.
     * @param array $imgconsigliati, locandine dei film consigliati.
     * @param array $reviews, giudiizi espressi dagli utenti sul film.
     * @param array $propic, immagini di profilo degli utenti che hanno espresso un giudizio sul film.
     * @param EProgrammazioneFilm $programmazioneFilm, la programmazione del film.
     * @param bool $canView, se l'utente è registrato e non ha già commentato il film può vedere la schermata di aggiunta commento.
     * @param $utente, utente che richiede la pagina.
     * @throws SmartyException
     */
    public static function show(EFilm $film, bool $autoplay, EMedia $copertina, array $filmconsigliati, array $imgconsigliati, array $reviews, array $propic, EProgrammazioneFilm $programmazioneFilm, bool $canView, $utente)
    {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("film", $film);
        $smarty->assign("consigli", $filmconsigliati);
        $smarty->assign("autoplay", $autoplay);
        $smarty->assign("locandina", $copertina);
        $smarty->assign("immagini", $imgconsigliati);
        $smarty->assign("registi", $film->getRegisti());
        $smarty->assign("attori", $film->getAttori());
        $smarty->assign("recensioni", $reviews);
        $smarty->assign("propic", $propic);
        $smarty->assign("canView", $canView);
        $smarty->assign("programmazioneFilm", $programmazioneFilm);
        $smarty->assign("utente", $utente);

        $smarty->display("film.tpl");
    }
}