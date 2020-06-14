<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{$path}Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/plyr.css">
    <link rel="stylesheet" href="{$path}Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="{$path}Smarty/css/default-skin.css">
    <link rel="stylesheet" href="{$path}Smarty/css/main.css">
    <style>
        .filter__item-label {
            font-size: 19px;
        }
    </style>

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{$path}Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{$path}Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$path}Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$path}Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$path}Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Modifica Film</title>

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

{if isset($errore)}<script>alert("{$errore}")</script>{/if}

<div class="sign section--bg" data-bg="{$path}Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <input type="hidden" name="film" value="{$film->getId()}">

            {if isset($error)}
                <script>alert({$error})</script>
            {/if}

            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form action="{$path}Admin/modificaFilm" onsubmit="return validate()" method="POST" class="sign__form" enctype="multipart/form-data">
                        <input type="hidden" name="film" value="{$film->getId()}">

                        <!-- Copertina -->
                        <a href="/MagicBoulevardCinema" class="sign__logo">
                            <img src="{$path}Smarty/img/logo.svg" alt="Logo">
                        </a>
                        <div class="sign__group">
                            <span class="filter__item-label">Copertina:</span>
                            <img src="{$copertina->getImmagineHTML()}" alt="">
                            <button id="insert_image" class="sign__btn" type="button" style="width: 200px" onclick="document.getElementById('choose_image').click()">Carica copertina</button>
                            <input id="choose_image" type="file" name="locandina" style="display: none" accept=".jpg, .jpeg, .gif, .png">
                            <br>
                        </div>

                        <!-- Titolo -->
                        <div class="sign__group">
                            <span class="filter__item-label">Titolo:</span>
                            <input class="form__input" type="text" id="titolo" name="titolo" value="{$film->getNome()}" placeholder="Titolo" style="width: 280px">
                        </div>

                        <!-- Descrizione -->
                        <div class="sign__group">
                            <span class="filter__item-label">Descrizione:</span>
                            <textarea class="form__input" type="text" id="descrizione" name="descrizione" placeholder="Descrizione" style="width: 280px; height: 200px; padding-top: 10px">{$film->getDescrizione()}</textarea>
                        </div>

                        <!-- Genere -->
                        <div class="filter__item" id="filter__genre" style="margin: auto; padding-bottom: 20px">
                            <span class="filter__item-label">Genere:</span>

                            <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-genre" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <input type="text" name="genere" value="{$film->getGenere()}" readonly>
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
                            <span class="filter__item-label">Durata: (in minuti)</span>
                            <input class="sign__input" id="durata" min = "0" type="number" max="500"  value="{$film->getDurataMinuti()}" name="durata">
                        </div>

                        <!-- TrailerURL -->
                        <div class="sign__group">
                            <span class="filter__item-label">Trailer:</span>
                            <input type="url" class="sign__input" value="{$film->getTrailerURL()}" name="trailerURL">
                        </div>

                        <!-- Voto critica -->
                        <div class="sign__group" style="position:relative;">
                            <span class="filter__item-label">Voto critica:</span>
                            <input style="padding-right: 30px;" type="number" min="0" max="10" step="0.1" class="sign__input" value="{$film->getVotoCritica()}" name="votoCritica">
                            <span class="card__rate" style="position: absolute; right: 10px; bottom: 13px;"><i class="icon ion-ios-star"></i></span>
                        </div>

                        <!-- DataRilascio -->
                        <div class="sign__group">
                            <span class="filter__item-label">Data rilascio:</span>
                            <input id="dataRilascio" type="date" class="sign__input" value="{$film->getDataRliascioForm()}" name="dataRilascio">
                        </div>

                        <!-- Paese -->
                        <div class="sign__group">
                            <span class="filter__item-label">Paese:</span>
                            <input type="text" maxlength="3" class="sign__input" value="{$film->getPaese()}" name="paese">
                        </div>

                        <!-- Età consigliata -->
                        <div class="filter__item" id="filter__age" style="margin: auto; padding-bottom: 20px">
                            <span class="filter__item-label">Età consigliata:</span>

                            <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-age" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <input type="text" name="etaConsigliata" value="{$film->getEtaConsigliata()}" readonly>
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
                            <span class="filter__item-label">Attori:</span>
                            <input id="actorChosen" list="actors" class="sign__input" placeholder="Attori">
                            <button id="addActor" type="button" class="sign__btn" style="position: absolute; right: 10px; bottom: 15px; width: 20px; height: 20px">+</button>

                            <datalist id="actors">
                                {foreach $attori as $attore}
                                    <option id="{$attore->getId()}" value="{$attore->getFullName()}">{$attore->getFullName()} - IMDB ID: {$attore->getImdbId()}</option>
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
                            <span class="filter__item-label">Registi:</span>
                            <input id="directorChosen" list="directors" class="sign__input" placeholder="Registi">
                            <button id="addDirector" type="button" class="sign__btn" style="position: absolute; right: 10px; bottom: 15px; width: 20px; height: 20px">+</button>

                            <datalist id="directors">
                                {foreach $registi as $regista}
                                    <option id="{$regista->getId()}" value="{$regista->getFullName()}">{$regista->getFullName()} - IMDB ID: {$regista->getImdbId()}</option>
                                {/foreach}
                            </datalist>

                            <input id="registi" type="hidden" name="registi" value="">
                        </div>
                        <div>
                            <ul id="displayDirectors" style="width:250px" class="dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
                            </ul>
                        </div>

                        <button id="submit" class="sign__btn" style="width: 280px">Applica Modifiche</button>
                    </form>
                    <!-- end authorization form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{$path}Smarty/js/jquery-3.3.1.min.js"></script>
<script src="{$path}Smarty/js/bootstrap.bundle.min.js"></script>
<script src="{$path}Smarty/js/owl.carousel.min.js"></script>
<script src="{$path}Smarty/js/jquery.mousewheel.min.js"></script>
<script src="{$path}Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="{$path}Smarty/js/wNumb.js"></script>
<script src="{$path}Smarty/js/nouislider.min.js"></script>
<script src="{$path}Smarty/js/plyr.min.js"></script>
<script src="{$path}Smarty/js/jquery.morelines.min.js"></script>
<script src="{$path}Smarty/js/photoswipe.min.js"></script>
<script src="{$path}Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="{$path}Smarty/js/main.js"></script>

<script>
    let actors = [];
    let directors = [];

    {foreach $film->getAttori() as $att}
    actors.push("{$att->getId()}");
    var button = $("<button type='button' name='" + {$att->getId()} + "' class='sign__btn' style='width: 20px; height: 20px; display: inline'>X</button>");
    var list = $("#displayActors");
    var li = $("<li id='" + {$att->getId()} + "' style=\"color: white; text-align: right\"></li>").append('{$att->getFullName()}', " ", button);
    li.click(function(e) {
        actors.splice(actors.indexOf($(this).attr("id")), 1);
        $(this).remove();
    });
    list.append(li);
    {/foreach}

    {foreach $film->getRegisti() as $reg}
    directors.push("{$reg->getId()}");
    var button = $("<button type='button' name='" + {$reg->getId()} + "' class='sign__btn' style='width: 20px; height: 20px; display: inline'>X</button>");
    var list = $("#displayDirectors");
    var li = $("<li id='" + {$reg->getId()} + "' style=\"color: white; text-align: right\"></li>").append('{$reg->getFullName()}', " ", button);
    li.click(function(e) {
        actors.splice(actors.indexOf($(this).attr("id")), 1);
        $(this).remove();
    });
    list.append(li);
    {/foreach}

    $(document).ready(function(){
        // Aggiorna nome copertina
        $('#choose_image').change(function(e) {
            document.getElementById("image_name").innerText = e.target.files[0].name;
        });

        // Aggiungi attore
        $('#addActor').click(function(e) {
            let actorChosen = $("#actorChosen").val();
            if (actorChosen !== "") {
                let idActorChosen = $("#actors").find("option[value='" + actorChosen + "']").attr("id");

                actors.push(idActorChosen);

                $("#actorChosen").val("");

                let button = $("<button type='button' name='" + idActorChosen + "' class='sign__btn' style='width: 20px; height: 20px; display: inline'>X</button>");
                let list = $("#displayActors");
                let li = $("<li id='" + idActorChosen + "' style=\"color: white; text-align: right\"></li>").append(actorChosen, " ", button);
                li.click(function(e) {
                    actors.splice(actors.indexOf($(this).attr("id")), 1);
                    $(this).remove();
                });
                list.append(li);
            }
        });

        $('#addDirector').click(function(e) {
            let directorChosen = $("#directorChosen").val();
            if (directorChosen !== "") {
                let idDirectorChosen = $("#directors").find("option[value='" + directorChosen + "']").attr("id");

                directors.push(idDirectorChosen);

                $("#directorChosen").val("");

                let button = $("<button type='button' name='" + idDirectorChosen + "' class='sign__btn' style='width: 20px; height: 20px; display: inline'>X</button>");
                let list = $("#displayDirectors");
                let li = $("<li id='" + idDirectorChosen + "' style=\"color: white; text-align: right\"></li>").append(directorChosen, " ", button);
                li.click(function(e) {
                    directors.splice(directors.indexOf($(this).attr("id")), 1);
                    $(this).remove();
                });
                list.append(li);
            }
        });
    });

    function validate() {
        if ($("#titolo").val() === "" ||
            $("#descrizione").val() === "" ||
            $("#durata").val() === "" ||
            $("#dataRilascio").val() === "") {
            alert("Inserisci almeno titolo, descrizione, durata e data di rilascio");
            return false;
        }

        $('#attori').attr("value", actors.join(";"));
        $('#registi').attr("value", directors.join(";"));

        return true;
    }

    function validateImage() {
        let formData = new FormData();

        let file = document.getElementById("choose_image").files[0];

        formData.append("Filedata", file);

        let t = file.type.split('/').pop().toLowerCase();
        if (t !== "jpeg" && t !== "jpg" && t !== "png" && t !== "gif") {
            alert('Inserire un file di immagine valido!');
            document.getElementById("choose_image").value = '';
            return false;
        }

        if (file.size > 2*1024*1024) {
            alert('Non puoi caricare file più grandi di 2 MB');
            document.getElementById("choose_image").value = '';
            return false;
        }

        return true;
    }
</script>

</body>
</html>