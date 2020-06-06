<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../../Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../../Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../../Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="../../Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="../../Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="../../Smarty/css/plyr.css">
    <link rel="stylesheet" href="../../Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="../../Smarty/css/default-skin.css">
    <link rel="stylesheet" href="../../Smarty/css/main.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="../../Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="../../Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../../Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../../Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../../Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Aggiungi un film</title>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="body">
<div class="sign section--bg" data-bg="../../Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form action="/Admin/addProiezione" method="POST" class="sign__form" enctype="multipart/form-data">

                        <!-- Film -->
                        <div class="sign__group" style="position: relative; margin-bottom: 0;">
                            <input id="filmChosen" list="films" class="sign__input" placeholder="Film">

                            <datalist id="films">
                                {foreach $films as $film}
                                    <option id="{$film->getId()}" value="{$film->getNome()}"></option>
                                {/foreach}
                            </datalist>

                            <input id="film" type="hidden" name="film" value="">
                        </div>

{*                        <!-- Descrizione -->*}
{*                        <div class="sign__group">*}
{*                            <input type="text" class="sign__input" placeholder="Descrizione" name="descrizione">*}
{*                        </div>*}

{*                        <!-- Genere -->*}
{*                        <div class="filter__item" id="filter__genre" style="margin: auto; padding-bottom: 20px">*}
{*                            <span class="filter__item-label">Genere:</span>*}

{*                            <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-genre" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*}
{*                                <input type="text" name="genere" value="{$generi[0]}" readonly>*}
{*                                <span></span>*}
{*                            </div>*}

{*                            <ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">*}
{*                                {foreach $generi as $genere}*}
{*                                    <li>{$genere}</li>*}
{*                                {/foreach}*}
{*                            </ul>*}
{*                        </div>*}

{*                        <!-- Durata -->*}
{*                        <div class="sign__group">*}
{*                            <input type="number" max="500" class="sign__input" placeholder="Durata (minuti)" name="durata">*}
{*                        </div>*}

{*                        <!-- TrailerURL -->*}
{*                        <div class="sign__group">*}
{*                            <input type="url" class="sign__input" placeholder="Trailer" name="trailerURL">*}
{*                        </div>*}

{*                        <!-- Voto critica -->*}
{*                        <div class="sign__group" style="position:relative;">*}
{*                            <input style="padding-right: 30px;" type="number" step="0.1" class="sign__input" placeholder="Voto della critica" name="votoCritica">*}
{*                            <span class="card__rate" style="position: absolute; right: 10px; bottom: 13px;"><i class="icon ion-ios-star"></i></span>*}
{*                        </div>*}

{*                        <!-- DataRilascio -->*}
{*                        <div class="sign__group">*}
{*                            <input type="date" class="sign__input" placeholder="GG/MM/AAAA" name="dataRilascio">*}
{*                        </div>*}

{*                        <!-- Paese -->*}
{*                        <div class="sign__group">*}
{*                            <input type="text" maxlength="3" class="sign__input" placeholder="Paese" name="paese">*}
{*                        </div>*}

{*                        <!-- Età consigliata -->*}
{*                        <div class="filter__item" id="filter__age" style="margin: auto; padding-bottom: 20px">*}
{*                            <span class="filter__item-label">Età consigliata:</span>*}

{*                            <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-age" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*}
{*                                <input type="text" name="etaConsigliata" value="NO" readonly>*}
{*                                <span></span>*}
{*                            </div>*}

{*                            <ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">*}
{*                                <li>NO</li>*}
{*                                <li>14+</li>*}
{*                                <li>16+</li>*}
{*                                <li>18+</li>*}
{*                            </ul>*}
{*                        </div>*}

{*                        <!-- Attori -->*}
{*                        <div class="sign__group" style="position: relative; margin-bottom: 0;">*}
{*                            <input id="actorChosen" list="actors" class="sign__input" placeholder="Attori">*}
{*                            <button id="addActor" type="button" class="sign__btn" style="position: absolute; right: 10px; bottom: 15px; width: 20px; height: 20px">+</button>*}

{*                            <datalist id="actors">*}
{*                                {foreach $attori as $attore}*}
{*                                    <option id="{$attore->getId()}" value="{$attore->getFullName()}"></option>*}
{*                                {/foreach}*}
{*                            </datalist>*}

{*                            <input id="attori" type="hidden" name="attori" value="">*}
{*                        </div>*}
{*                        <div>*}
{*                            <ul id="displayActors" style="width:250px" class="dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">*}
{*                            </ul>*}
{*                        </div>*}

{*                        <!-- Registi -->*}
{*                        <div class="sign__group" style="position: relative; margin-top: 15px; margin-bottom: 0px;">*}
{*                            <input id="directorChosen" list="directors" class="sign__input" placeholder="Registi">*}
{*                            <button id="addDirector" type="button" class="sign__btn" style="position: absolute; right: 10px; bottom: 15px; width: 20px; height: 20px">+</button>*}

{*                            <datalist id="directors">*}
{*                                {foreach $registi as $regista}*}
{*                                <option id="{$regista->getId()}" value="{$regista->getFullName()}">*}
{*                                    {/foreach}*}
{*                            </datalist>*}

{*                            <input id="registi" type="hidden" name="registi" value="">*}
{*                        </div>*}
{*                        <div>*}
{*                            <ul id="displayDirectors" style="width:250px" class="dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">*}
{*                            </ul>*}
{*                        </div>*}

                        <button id="submit" class="sign__btn" type="submit">Aggiungi proiezione</button>
                    </form>
                    <!-- end authorization form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="../../Smarty/js/jquery-3.3.1.min.js"></script>
<script src="../../Smarty/js/bootstrap.bundle.min.js"></script>
<script src="../../Smarty/js/owl.carousel.min.js"></script>
<script src="../../Smarty/js/jquery.mousewheel.min.js"></script>
<script src="../../Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="../../Smarty/js/wNumb.js"></script>
<script src="../../Smarty/js/nouislider.min.js"></script>
<script src="../../Smarty/js/plyr.min.js"></script>
<script src="../../Smarty/js/jquery.morelines.min.js"></script>
<script src="../../Smarty/js/photoswipe.min.js"></script>
<script src="../../Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="../../Smarty/js/main.js"></script>


</body>
</html>