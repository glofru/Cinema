<!DOCTYPE html>
<html lang="it">

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

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{$path}Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{$path}Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$path}Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$path}Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$path}Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body">

{include file="header.tpl"}

{if (isset($errorAddFilm))}<script>alert('{$errorAddFilm}')</script>{/if}
{if (isset($errorAddPersona))}<script>alert('{$errorAddPersona}')</script>{/if}

<!-- content -->
<section class="content">
    <div class="content__head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- content title -->
                    <h2 class="content__title">Discover</h2>
                    <!-- end content title -->

                    <!-- content tabs nav -->
                    <ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist" style="margin-top: 50px">
                        <li class="nav-item">
                            <a class="nav-link {if !isset($errorAddPersona)}active{/if}" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Aggiungi film</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {if isset($errorAddPersona)}active{/if}" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Aggiungi attore/regista</a>
                        </li>
                    </ul>
                    <!-- end content tabs nav -->

                    <!-- content mobile tabs nav -->
                    <div class="content__mobile-tabs" id="content__mobile-tabs">
                        <div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <input type="button" value="Aggiungi film">
                            <span></span>
                        </div>

                        <div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Aggiungi film</a></li>

                                <li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Aggiungi attore/regista</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- end content mobile tabs nav -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8" style="margin: auto">
                <!-- content tabs -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {if !(isset($errorAddPersona))}show active{/if}" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                        <div class="row">
                            <!-- authorization form -->
                            <form action="{$path}Admin/gestioneFilm" onsubmit="return validate()" method="POST" class="form" enctype="multipart/form-data" style="margin: auto">
                                <input type="hidden" name="addFilm" value="true">

                                <!-- Copertina -->
                                <div class="sign__group">
                                    <button id="insert_image" class="sign__btn" type="button" style="width: 200px" onclick="document.getElementById('choose_image').click()">Carica copertina</button>
                                    <input id="choose_image" type="file" name="copertina" onchange="validateImage()" style="display: none" accept=".jpg, .jpeg, .gif, .png">
                                    <br>
                                    <b><p id="image_name" class="faq__text" style="text-align: center; max-width: 300px">Nessuna immagine caricata (MAX 2MB)</p></b>
                                </div>

                                <!-- Titolo -->
                                <div class="sign__group">
                                    <input id="titolo" type="text" class="sign__input" placeholder="Titolo del film" name="titolo" value="{$titolo}">
                                </div>

                                <!-- Descrizione -->
                                <div class="sign__group">
                                    <textarea id="descrizione" type="text" class="sign__input" placeholder="Descrizione" name="descrizione" style="padding-top: 10px; height: 150px">{$descrizione}</textarea>
                                </div>

                                <!-- Genere -->
                                <div class="filter__item" id="filter__genre" style="margin: auto; padding-bottom: 20px">
                                    <span class="filter__item-label">Genere:</span>

                                    <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-genre" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <input type="text" name="genere" value="{if isset($genere)}{$genere}{else}{$generi[0]}{/if}" readonly>
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
                                    <input id="durata" type="number" min="0" max="500" class="sign__input" placeholder="Durata (minuti)" name="durata" value="{$durata}">
                                </div>

                                <!-- TrailerURL -->
                                <div class="sign__group">
                                    <input type="url" class="sign__input" placeholder="Trailer" name="trailerURL" value="{$trailerURL}">
                                </div>

                                <!-- Voto critica -->
                                <div class="sign__group" style="position:relative;">
                                    <input style="padding-right: 30px;" type="number" min="0" max="10" step="0.1" class="sign__input" placeholder="Voto della critica" name="votoCritica" value="{$votoCritica}">
                                    <span class="card__rate" style="position: absolute; right: 22px; bottom: 13px;"><i class="icon ion-ios-star"></i></span>
                                </div>

                                <!-- DataRilascio -->
                                <div class="sign__group">
                                    <input id="dataRilascio" type="date" class="sign__input" placeholder="Data di rilascio: AAAA/MM/GG" name="dataRilascio" value="{$dataRilascio}">
                                </div>

                                <!-- Paese -->
                                <div class="sign__group">
                                    <input type="text" maxlength="3" class="sign__input" placeholder="Paese" name="paese" value="{$paese}">
                                </div>

                                <!-- Età consigliata -->
                                <div class="filter__item" id="filter__age" style="margin: auto; padding-bottom: 20px">
                                    <span class="filter__item-label">Età consigliata:</span>

                                    <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-age" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <input type="text" name="etaConsigliata" value="{if isset($etaConsigliata)}{$etaConsigliata}{else}NO{/if}" readonly>
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
                                    <input id="actorChosen" list="actors" class="sign__input" placeholder="Attori">
                                    <button id="addActor" type="button" class="sign__btn" style="position: absolute; right: 30px; bottom: 15px; width: 20px; height: 20px">+</button>

                                    <datalist id="actors">
                                        {foreach $attori as $attore}
                                            <option id="{$attore->getId()}" value="{$attore->getFullName()}">IMDB ID: {$attore->getImdbId()}</option>
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
                                    <input id="directorChosen" list="directors" class="sign__input" placeholder="Registi">
                                    <button id="addDirector" type="button" class="sign__btn" style="position: absolute; right: 30px; bottom: 15px; width: 20px; height: 20px">+</button>

                                    <datalist id="directors">
                                        {foreach $registi as $regista}
                                            <option id="{$regista->getId()}" value="{$regista->getFullName()}">IMDB ID: {$regista->getImdbId()}</option>
                                        {/foreach}
                                    </datalist>

                                    <input id="registi" type="hidden" name="registi" value="">
                                </div>
                                <div>
                                    <ul id="displayDirectors" style="width:250px" class="dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
                                    </ul>
                                </div>

                                <button id="submit" class="sign__btn">Aggiungi</button>
                            </form>
                            <!-- end authorization form -->
                        </div>
                    </div>

                    <div class="tab-pane fade {if (isset($errorAddPersona))}show active{/if}" id="tab-2" role="tabpanel" aria-labelledby="2-tab">
                        <div class="row" style="align-content: center">
                            <form action="{$path}Admin/gestioneFilm" onsubmit="return validate()" method="POST" class="form" enctype="multipart/form-data" style="margin: auto">
                                <input type="hidden" name="addPersona" value="true">

                                <!-- Nome -->
                                <div class="sign__group">
                                    <input id="nome" type="text" class="sign__input" placeholder="Nome" name="nome">
                                </div>

                                <!-- Cognome -->
                                <div class="sign__group">
                                    <input id="cognome" type="text" class="sign__input" placeholder="Cognome" name="cognome">
                                </div>

                                <!-- IMDB URL -->
                                <div class="sign__group">
                                    <input type="url" class="sign__input" placeholder="URL Imdb" name="imdbURL">
                                </div>

                                <!-- isAttore -->
                                <div class="sign__group sign__group--checkbox">
                                    <input id="attore" name="attore" type="checkbox">
                                    <label for="attore">Attore</label>
                                </div>

                                <!-- isRegista -->
                                <div class="sign__group sign__group--checkbox">
                                    <input id="regista" name="regista" type="checkbox">
                                    <label for="regista">Regista</label>
                                </div>

                                <button id="submit" class="sign__btn">Aggiungi</button>
                            </form>
                            <!-- end authorization form -->
                        </div>
                    </div>
                    <!-- end reviews -->
                </div>
            </div>
        </div>
        <!-- end content tabs -->
    </div>
</section>
<!-- end content -->

{include file="footer.tpl"}

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
    It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <!-- Preloader -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

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