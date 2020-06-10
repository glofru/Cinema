<!DOCTYPE html>
<html lang="it">

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
    <title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body">

{include file="{$path}Smarty/templates/header.tpl"}

<!-- details -->
    <section class="section details">
        <!-- details background -->
        <div class="details__bg" data-bg="{$path}../../Smarty/img/home/home__bg.jpg"></div>
        <!-- end details background -->

        <!-- details content -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section__title section__title--center">Ecco i giudizi che hai espresso :)</h2>
                </div>
                {if sizeof($giudizi) === 0}
                <div class="col-12">
                    <h2 class="section__title section__title--center">Non hai ancora espresso giudizi... :(</h2>
                </div>
                {else}
                <div class="col-12 col-lg-8 col-xl-8">
                    <div class="col-12">
                        <div class="reviews">
                            <ul class="reviews__list">
                                {if ($giudizi)}
                                    {foreach $giudizi as $key => $rev}
                                        <li class="reviews__item">
                                            <div class="reviews__autor">
                                                <img class="reviews__avatar" src="{$propic->getImmagineHTML()}" alt="">
                                                <span class="reviews__name" style="display: inline-block">{$rev->getTitle()}</span>
                                                <span class="reviews__name" style="display: inline-block; position: relative; float: right; bottom: -7px">
                                                    <a style="line-height: normal" class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
                                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                                        <li><a onclick="erase({$rev->getFilm()->getId()}, {$rev->getUtente()->getId()})" href="#null">Cancella</a></li>
                                                        <form id="form" action="" method="POST"></form>
                                                    </ul>
                                                </span>
                                                <span class="reviews__time">da @{$rev->getUtente()->getUsername()} il {$rev->getDataPubblicazioneString()} nel film <a href="{$path}../../Film/show/?film={$rev->getFilm()->getId()}&autoplay=true" target="_blank">{$rev->getFilm()->getNome()}</a></span>
                                                <span class="reviews__rating"><i class="icon ion-ios-star"></i>{$rev->getPunteggio()}</span>
                                            </div>
                                            <p class="reviews__text">{$rev->getCommento()}</p>
                                        </li>
                                    {/foreach}
                                {/if}
                            </ul>
                        </div>
                    </div>
                </div>
                {/if}
            </div>
        </div>
    </section>

{include file="{$path}Smarty/templates/footer.tpl"}
                            <!-- JS -->
<script>
    function erase(idFilm, idUtente) {
        let form = $("#form");
        form.attr("action", "/Giudizio/delete");

        form.append("<input type='hidden' name='film' value='" + idFilm + "' />");
        form.append("<input type='hidden' name='utente' value='" + idUtente + "' />");
        form.append("<input type='hidden' name='redirect' value='noredirect' />");

        form.submit();
    }
</script>
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