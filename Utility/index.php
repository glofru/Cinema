<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include_once('autoload.inc.php');

$f = FPersistentManager::getInstance();
/*$film = $f->load('3','id','EFilm');
echo $film[0]->getNome() . '<br>';
$film = new EFilm("A","B",new DateInterval("PT1H30M"),"YOUTUBE",6.0,DateTime::createFromFormat("Y-m-d","2020-10-02"),"AZIONE");
$f->save($film);*/
//$sala = $f->load('1','nSala','ESalaFisica');
//echo $sala->getNumeroSala();
$proiezione = $f->loadProiezioni("51","id",true,NULL,NULL,"EProiezione");
//echo $proiezione[0]->getData();
$utente = $f->load("c","username","EUtente");
//$emailUtente = $utente->getEmail();
//$sala = ESalaVirtuale::fromSalaFisica($sala);
//$data = DateTime::createFromFormat("Y-m-d\TH:i","2020-10-02T12:30");
//$pro = new EProiezione($film[0],$sala,$data);
/*$val = $f->saveProiezione($pro);*/
$posto = EPosto::fromString("A 2",false);
$biglietto = new EBiglietto($proiezione[0],$posto,$utente,5.0);
$f->save($biglietto);
//$biglietto = $f->loadDebole("52","idProiezione","A 1","posto","EBiglietto");
//echo "Biglietto: " . $biglietto->getCosto();
//$idProiezione = strval($proiezione[0]->getId());
//$posto = $posto->getPostoDB();
//$emailUtente = $utente->getEmail();
//$costo = 5.0;
//$biglietto = $f->occupaPosto($idProiezione,$posto,$emailUtente,$costo);
//echo $biglietto->getCosto();
//$f->liberaPosto($idProiezione,$posto,$emailUtente);
?>