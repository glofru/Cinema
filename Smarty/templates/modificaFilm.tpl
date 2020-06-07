<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{$path}../../Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/plyr.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/default-skin.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/main.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{$path}../../Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{$path}../../Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$path}../../Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$path}../../Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$path}../../Smarty/icon/apple-touch-icon-144x144.png">

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

        .custom_upload::-webkit-file-upload-button {
            visibility: hidden;
        }
        .custom_upload::before {
            content: 'Carica copertina';
            display: inline-block;
            background: linear-gradient(top, #f9f9f9, #e3e3e3);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            text-shadow: 1px 1px #fff;
            font-weight: 700;
            font-size: 10pt;
        }
        .custom_upload:hover::before {
            border-color: black;
        }
        .custom_upload:active::before {
            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
        }
    </style>
</head>
<body class="body">
<div class="sign section--bg" data-bg="{$path}../../Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <input type="hidden" name="film" value="{$film->getId()}">

            {if isset($error)}
                <script>alert({$error})</script>
            {/if}

            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form action="{$path}../../Admin/modificaFilm/?film={$film->getId()}" method="POST" class="sign__form" enctype="multipart/form-data">
                        <a href="/" class="sign__logo">
                            <img src="../../Smarty/img/logo.svg" alt="">
                        </a>
                        <div class="sign__group">
                            <img src="{$copertina->getImmagine()}" alt="">
                            <button id="insert_image" class="sign__btn" type="button" style="width: 200px" onclick="document.getElementById('choose_image').click()">Carica copertina</button>
                            <input id="choose_image" type="file" name="copertina" style="display: none" accept=".jpg, .jpeg, .gif, .png">
                            <br>
                        </div>

                        <!-- Titolo -->
                        <div class="sign__group">
                            <input class="form__input" type="text" id="titolo" name="titolo" value="{$film->getNome()}" placeholder="Titolo">
                        </div>

                        <!-- Descrizione -->
                        <div class="sign__group">
                            <input class="form__input" type="text" id="descrizione" name="descrizione" value="{$film->getDescrizione()}" placeholder="Descrizione">
                        </div>

                        <!-- Genere -->
                        <div class="filter__item" id="filter__genre" style="margin: auto; padding-bottom: 20px">
                            <span class="filter__item-label">Genere:</span>

                            <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-genre" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <input type="text" name="genere" value="{$film->getGenere}" readonly>
                                <span></span>
                            </div>

                            <ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
                                {foreach $generi as $genere}
                                    <li>{$genere}</li>
                                {/foreach}
                            </ul>
                        </div>

                        <!-- Durata -->
                        <div class="sign__group">
                            <input class="sign__input" id="durata" type="number" max="500"  value="{$film->getDurataMinuti}" name="durata">
                        </div>

                        <!-- TrailerURL -->
                        <div class="sign__group">
                            <input type="url" class="sign__input" value="{$film->getTrailerURL}" name="trailerURL">
                        </div>

                        <!-- Voto critica -->
                        <div class="sign__group" style="position:relative;">
                            <input style="padding-right: 30px;" type="number" min="0" max="10" step="0.1" class="sign__input" value="{$film->getVotoCritica}" name="votoCritica">
                            <span class="card__rate" style="position: absolute; right: 10px; bottom: 13px;"><i class="icon ion-ios-star"></i></span>
                        </div>

                        <!-- DataRilascio -->
                        <div class="sign__group">
                            <input id="dataRilascio" type="date" class="sign__input" value="{$film->getDataRilascioString}" name="dataRilascio">
                        </div>

                        <!-- Paese -->
                        <div class="sign__group">
                            <input type="text" maxlength="3" class="sign__input" value="{$film->getPaese}" name="paese">
                        </div>

                        <!-- Età consigliata -->
                        <div class="filter__item" id="filter__age" style="margin: auto; padding-bottom: 20px">
                            <span class="filter__item-label">Età consigliata:</span>

                            <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-age" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <input type="text" name="etaConsigliata" value=value="{$film->getEtaConsigliata}" readonly>
                                <span></span>
                            </div>

                            <ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
                                <li>NO</li>
                                <li>14+</li>
                                <li>16+</li>
                                <li>18+</li>
                            </ul>
                        </div>

                        <!-- Attori -->
                        <div class="sign__group" style="position: relative; margin-bottom: 0;">
                            <input id="actorChosen" list="actors" class="sign__input" value="{$film->getAttori}">
                            <button id="addActor" type="button" class="sign__btn" style="position: absolute; right: 10px; bottom: 15px; width: 20px; height: 20px">+</button>

                            <datalist id="actors">
                                {foreach $attori as $attore}
                                    <option id="{$attore->getId()}" value="{$attore->getFullName()}">Ei</option>
                                {/foreach}
                            </datalist>

                            <input id="attori" type="hidden" name="attori" value="">
                        </div>
                        <div>
                            <ul id="displayActors" style="width:250px" class="dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
                            </ul>
                        </div>

                        <!-- Registi -->
                        <div class="sign__group" style="position: relative; margin-top: 15px; margin-bottom: 0px;">
                            <input id="directorChosen" list="directors" class="sign__input" value="{$film->getRegisti}"
                            <button id="addDirector" type="button" class="sign__btn" style="position: absolute; right: 10px; bottom: 15px; width: 20px; height: 20px">+</button>

                            <datalist id="directors">
                                {foreach $registi as $regista}
                                <option id="{$regista->getId()}" value="{$regista->getFullName()}">
                                    {/foreach}
                            </datalist>

                            <input id="registi" type="hidden" name="registi" value="">
                        </div>
                        <div>
                            <ul id="displayDirectors" style="width:250px" class="dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
                            </ul>
                        </div>

                        <button id="submit" class="sign__btn">Aggiungi Film</button>
                    </form>
                    <!-- end authorization form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{$path}../../Smarty/js/jquery-3.3.1.min.js"></script>
<script src="{$path}../../Smarty/js/bootstrap.bundle.min.js"></script>
<script src="{$path}../../Smarty/js/owl.carousel.min.js"></script>
<script src="{$path}../../Smarty/js/jquery.mousewheel.min.js"></script>
<script src="{$path}../../Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="{$path}../../Smarty/js/wNumb.js"></script>
<script src="{$path}../../Smarty/js/nouislider.min.js"></script>
<script src="{$path}../../Smarty/js/plyr.min.js"></script>
<script src="{$path}../../Smarty/js/jquery.morelines.min.js"></script>
<script src="{$path}../../Smarty/js/photoswipe.min.js"></script>
<script src="{$path}../../Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="{$path}../../Smarty/js/main.js"></script>



</body>
</html>