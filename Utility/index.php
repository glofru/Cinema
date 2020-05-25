<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include_once('autoload.inc.php');

$f = FPersistentManager::getInstance();
//$a= new ERegistrato("K", "R", "J", "G", "T");
//$u = $f->load("D","username","ERegistrato");
//$film = $f->load('2','id','EFilm');
//print_r ($film[0]->getAttori());
//$a= new EAdmin("K", "R", "J", "G", "T");
//$f->save($a);
//$g = new EGiudizio("SOS",10.1,$film[0],$u);
//$g = $f->loadDebole("17","idUtente","2","idFilm","EGiudizio");
//echo $g->getPunteggio();
//print_r($film[0]->getAttori());
/*echo $film[0]->getNome() . '<br>';
$film = new EFilm("A","B",new DateInterval("PT1H30M"),"YOUTUBE",6.0,DateTime::createFromFormat("Y-m-d","2020-10-02"),"AZIONE");
$f->save($film);*/
//$sala = $f->load('1','nSala','ESalaFisica');
//$sala = ESalaVirtuale::fromSalaFisica($sala);
//echo $sala->getNumeroSala();
//$proiezione = $f->loadBetween("2020-01-01","2020-12-30","EProiezione");
/*echo "PROIEZIONI: " . sizeof($proiezione) . "<br>";
foreach($proiezione as $row){
    echo $row->getId() . " " . $row->getFilm()->getNome() . "<br>";
}*/
//echo $proiezione[0]->getData();
$utente = $f->load("c","username","EUtente");
$emailUtente = $utente->getEmail();
//$data = DateTime::createFromFormat("Y-m-d\TH:i","2020-10-02T14:30");
//$pro = new EProiezione($film[0],$sala,$data);
/*$val = $f->saveProiezione($pro);*/
$proiezione = $f->load("53","id","EProiezione");
$posto = EPosto::fromString("A 3",false);
$biglietto = new EBiglietto($proiezione[0],$posto,$utente,5.0);
$f->save($biglietto);
/*$res = $f->save($pro);
if($res !== true) {
    foreach($res as $row){
        echo $row->getId() . " " . $row->getFilm()->getNome() . "<br>";
    }
}*/
//$biglietto = $f->loadDebole("53","idProiezione","A 2","posto","EBiglietto");
//echo "Biglietto: " . $biglietto->getCosto();
/*
$idProiezione = strval($proiezione[0]->getId());
$posto = $posto->getPostoDB();
$emailUtente = $utente->getEmail();
$costo = 5.0;*/
//$biglietto = $f->occupaPosto($idProiezione,$posto,$emailUtente,$costo);*/
/*if(isset($biglietto))
    echo $biglietto->getCosto();*/
//$f->liberaPosto($idProiezione,$posto,$emailUtente);
//$persona = new EPersona("Kim","Kerouach","WWW",true,true);
//$f->save($persona);
/*$p1 = $f->load("1","id","EPersona");
$p2 = $f->load("2","id","EPersona");
$str = strval($p1->getId()) . ";" . strval($p2->getId());
$f->update("2","id","attori",$str,"EFilm");*/

?>