<!DOCTYPE html>
<html lang="it">

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
    <title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body">

<!-- header -->
<header class="header">
    <div class="header__wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__content">
                        <!-- header logo -->
                        <a href="../../index.php" class="header__logo">
                            <img src="../../Smarty/img/logo.svg" alt="">
                        </a>
                        <!-- end header logo -->

                        <!-- header nav -->
                        <ul class="header__nav">
                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="../../index.php" role="button" >Home</a>

                                
                            </li>
                            <!-- end dropdown -->

                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalogo</a>

                                <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                    <li><a href="catalog1.html">Prossime Uscite</a></li>
                                    <li><a href="catalog2.html">Programmazione</a></li>
                                    <li><a href="details1.html">Film più apprezzati</a></li>
                                </ul>
                            </li>
                            <!-- end dropdown -->

                            <li class="header__nav-item">
                                <a href="pricing.html" class="header__nav-link">Prezzi</a>
                            </li>

                            <li class="header__nav-item">
                                <a href="faq.html" class="header__nav-link">Aiuto</a>
                            </li>

                            <!-- dropdown -->
                            <li class="dropdown header__nav-item">
                                <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
                                {if (!isset($utente))}
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="about.html">Su di noi</a></li>
                                        <li><a href="/Utente/signup">Registrati</a></li>
                                    </ul>
                                {else}
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="about.html">Su di noi</a></li>
                                    </ul>
                                {/if}
                            </li>
                            <!-- end dropdown -->
                        </ul>
                        <!-- end header nav -->

                        <!-- header auth -->
                        <div class="header__auth">
                            <button class="header__search-btn" type="button">
                                <i class="icon ion-ios-search"></i>
                            </button>

                            {if (!isset($utente))}
                                <a href="../../Utente/login" methods="GET" class="header__sign-in">
                                    <i class="icon ion-ios-log-in"></i>
                                    <span>Login</span>
                                </a>
                            {elseif (isset($utente) && !$admin)}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="">Il mio profilo</a></li>
                                        <li><a href="">I miei acquisti</a></li>
                                        <li><a href="https://www.youporn.com/watch/15481840/il-sole-sul-balcone-amatoriale-italianovery-myller/#1">I miei video porno</a></li>
                                        <li><a href="../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
                                    </ul>
                                </li>
                            {elseif (isset($utente) && $admin)}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="">Il mio profilo</a></li>
                                        <li><a href="">Gestione film</a></li>
                                        <li><a href="">Gestione Proiezioni</a></li>
                                        <li><a href="">Gestione Utenti</a></li>
                                        <li><a href="../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
                                    </ul>
                                </li>
                            {/if}
                        </div>
                        <!-- end header auth -->

                        <!-- header menu btn -->
                        <button class="header__btn" type="button">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <!-- end header menu btn -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header search -->
    <form action="/Ricerca/cercaFilm" method= "POST" class="header__search">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__search-content">
                        <input type="text" name="filmCercato" placeholder="Cerca un film">

                        <button type="submit">Cerca</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end header search -->
</header>
<!-- end header -->

<!-- details -->
<section class="section details">
    <!-- details background -->
    <div class="details__bg" data-bg="../../Smarty/img/home/home__bg.jpg"></div>
    <!-- end details background -->

    <!-- details content -->
    <div class="container">
        {if $film}
        <div class="row">
            <!-- title -->
            <div class="col-12">
                <h1 class="details__title">{$film->getNome()}</h1>
            </div>
            <!-- end title -->

            <!-- content -->
            <div class="col-12 col-xl-6">
                <div class="card card--details">
                    <div class="row">
                        <!-- card cover -->
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-5">
                            <div class="card__cover">
                                <img src="{$locandina->getImmagineHTML()}" alt="">
                            </div>
                        </div>
                        <!-- end card cover -->

                        <!-- card content -->
                        <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-xl-7">
                            <div class="card__content">
                                <div class="card__wrap">
                                    {if ($film->getVotoCritica() != '0')}
                                        <span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()}</span>
                                    {/if}
                                    {if ($film->getEtaConsigliata() != "")}
                                        <ul class="card__list">
                                            <li>{$film->getEtaConsigliata()}</li>
                                        </ul>
                                    {/if}
                                </div>

                                <ul class="card__meta">
                                    <li><span>Genere:</span> <a href="#">{$film->getGenere()}</a>
                                    <li><span>Anno di rilascio:</span> {$film->getAnno()}</li>
                                    <li><span>Durata:</span> {$film->getDurataMinuti()} min</li>
                                    <li><span>Paese:</span> <a href="#">{$film->getPaese()}</a> </li>
                                    <li><span>Regista:</span> {foreach $registi as $reg} <a href="{$reg->getImdbUrl()}" target="_blank">{$reg->getNome()} {$reg->getCognome()} </a> {/foreach}</li>
                                    <li><span>Attori:</span> {foreach $attori as $att} <a href="{$att->getImdbUrl()}" target="_blank">{$att->getNome()} {$att->getCognome()} </a> {/foreach}</li>
                                        
                                </ul>

                                <div class="card__description card__description--details">
                                    {$film->getDescrizione()}
                                </div>
                            </div>
                        </div>
                        <!-- end card content -->
                    </div>
                </div>
            </div>
            <!-- end content -->

            <!-- player -->
            <div class="col-12 col-xl-6">
                {if $autoplay}
                    <iframe width="500" height="300" style="border: 7px solid #000; border-radius: 25px;" src="{$film->getEmbedURL(true)}" frameborder="0" allow="autoplay;" allowfullscreen></iframe>
                {else}
                    <iframe width="500" height="300" style="border: 7px solid #000; border-radius: 25px;" src="{$film->getEmbedURL()}" frameborder="0" allowfullscreen></iframe>
                {/if}
            </div>
            <!-- end player -->

            <div class="col-12">
                <div class="details__wrap">
                    <!-- share -->
                    <div class="details__share">
                        <span class="details__share-title">Condividi il nostro sito con i tuoi amici:</span>

                        <ul class="details__share-list">
                            <li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
                            <li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
                            <li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
                            <li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
                        </ul>
                    </div>
                    <!-- end share -->
                </div>
            </div>
            {/if}
        </div>
    </div>
    <!-- end details content -->
</section>
<!-- end details -->
{if (sizeof($proiezioni) > 0)}
<!-- sala prenotazione -->
<section class="content">
    <div class="content__head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Title -->
                    <h2 class="content__title">Prenota il tuo posto</h2>
                    <!-- content tabs nav -->
                    <ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">
                        {foreach $proiezioni as $key => $pro}
                        <li class="nav-item">
                            {if $key == 0}
                            <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true"> {$pro->getDataRed()}</a>
                            {else}
                            <a class="nav-link" data-toggle="tab" href="#tab-{$key+1}" role="tab" aria-controls="tab-{$key+1}" aria-selected="true"> {$pro->getDataRed()}</a>
                            {/if}
                        </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="tab-content" id="myTabContent">
        {foreach $proiezioni as $key => $pro}
            {if ($key == 0)}
            <div class="tab-pane fade show active" id="tab-{$key+1}" role="tabpanel" aria-labelledby="{$key+1}-tab">
            {else}
            <div class="tab-pane fade" id="tab-{$key+1}" role="tabpanel" aria-labelledby="{$key+1}-tab">
            {/if}
            <div class="col-12">
                <h2 class="section__title section__title--center">Sala: {$pro->getSala()->getNumeroSala()}</h2>
            </div>
                <div class="row--center">
                    <form id="book" class="form" action="/Acquisto/getBiglietti" method="POST">
                        <table style="margin-left:auto;margin-right:auto;" id="t01">
                            {foreach $pro->getSala()->getPosti() as $fila}
                                <tr>
                                    {foreach $fila as $posto}
                                        {if $posto->isOccupato}
                                            <th><img name="{$pro->getId()}" id="{$posto->getId()}" onclick="book(this)" src="../../Smarty/img/cinema/sedia_occupata.png" alt="Posto"/></th>
                                        {else}
                                            <th><img name="{$pro->getId()}" id="{$posto->getId()}" onclick="book(this)" src="../../Smarty/img/cinema/sedia_libera.png" alt="Posto"/></th>
                                        {/if}
                                    {/foreach}
                                </tr>
                            {/foreach}
                        </table>
                    </form>
                </div>
            </div>
        {/foreach}
        <div class="col-12--center">
            <a onclick="acquista()" style="color: white; cursor:pointer;" class="section__btn" id="acquista">Acquista</a>
        </div>
    </div>
</section>
{/if}
<!-- content -->
<section class="content">
    <div class="content__head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- content title -->
                    <h2 class="content__title">Cosa ne pensano gli altri spettatori?</h2>
                    <!-- end content title -->

                    <!-- content tabs nav -->
                    <ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Recensioni</a>
                        </li>
                    </ul>
                    <!-- end content tabs nav -->

                    <!-- content mobile tabs nav -->
                    <div class="content__mobile-tabs" id="content__mobile-tabs">
                        <div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <input type="button" value="Comments">
                            <span></span>
                        </div>

                        <div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Comments</a></li>

                                <li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Reviews</a></li>

                                <li class="nav-item"><a class="nav-link" id="3-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Photos</a></li>
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
            <div class="col-12 col-lg-8 col-xl-8">
                <!-- content tabs -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                        <div class="row">
                            <!-- reviews -->
                            <div class="col-12">
                                <div class="reviews">
                                    <ul class="reviews__list">
                                        {if ($recensioni)}
                                            {foreach $recensioni as $key => $rev}
                                        <li class="reviews__item">
                                            <div class="reviews__autor">
                                                <img class="reviews__avatar" src="{$propic[$key]->getImmagine()}" alt="">
                                                <span class="reviews__name">{$rev->getTitle()}</span>
                                                <span class="reviews__time">da @{$rev->getUtente()->getUsername()} il {$rev->getDataPubblicazioneString()}</span>

                                                <span class="reviews__rating"><i class="icon ion-ios-star"></i>{$rev->getPunteggio()}</span>
                                            </div>
                                            <p class="reviews__text">{$rev->getCommento()}</p>
                                        </li>
                                            {/foreach}
                                        {/if}
                                    </ul>
                                    {if $canView}
                                    <form action="/Giudizio/add" class="form" method="POST">
                                        <input name="titolo" type="text" class="form__input" placeholder="Titolo (max 30 caratteri)" maxlength="30">
                                        <textarea name="commento" class="form__textarea" placeholder="Recensione (max 200 caratteri)" maxlength="200"></textarea>
                                        <div class="form__slider">
                                            <div class="form__slider-rating" id="slider__rating"></div>
                                            <div class="form__slider-value" id="form__slider-value"></div>
                                        </div>
                                        <input type="hidden" id="film" name="filmId" value="{$film->getId()}">
                                        <input type="hidden" name="punteggio" id="punteggio">
                                        <button type="submit" class="form__btn" onclick="getVal()">Invia</button>
                                    </form>
                                    {/if}
                                </div>
                            </div>
                            <!-- end reviews -->
                        </div>
                    </div>
                </div>
                <!-- end content tabs -->
            </div>

            <!-- sidebar -->
            <div class="col-12 col-lg-4 col-xl-4">
                <div class="row">
                    <!-- section title -->
                    <div class="col-12">
                        <h2 class="section__title section__title--sidebar">Potrebbero interessarti anche...</h2>
                    </div>
                    <!-- end section title -->
                    {if ($consigli)}
                        {foreach $consigli as $key => $film }
                    <!-- card -->
                    <div class="col-6 col-sm-4 col-lg-6">
                        <div class="card">
                            <div class="card__cover">
                                <img src="{$immagini[$key]->getImmagineHTML()}" alt="">
                                <a href="/Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            <div class="card__content">
                                <h3 class="card__title"><a href="/Film/show/?film={$film->getId()}&autoplay=true">{$film->getNome()}</a></h3>
                                <span class="card__category">
										<a href="/Film/show/?film={$film->getId()}&autoplay=true">{$film->getGenere()}</a>
                                    </span>
                                {if ($film->getVotoCritica() != '0')}
                                <span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()}</span>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                        {/foreach}
                    {/if}
                </div>
            </div>
            <!-- end sidebar -->
        </div>
    </div>
</section>
<!-- end content -->

<!-- footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- footer list -->
            <div class="col-12 col-md-3">
                <h6 class="footer__title">Download Our App</h6>
                <ul class="footer__app">
                    <li><a href="#"><img src="../../Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
                    <li><a href="#"><img src="../../Smarty/img/google-play-badge.png" alt=""></a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-6 col-sm-4 col-md-3">
                <h6 class="footer__title">Resources</h6>
                <ul class="footer__list">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Pricing Plan</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-6 col-sm-4 col-md-3">
                <h6 class="footer__title">Legal</h6>
                <ul class="footer__list">
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Security</a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-12 col-sm-4 col-md-3">
                <h6 class="footer__title">Contact</h6>
                <ul class="footer__list">
                    <li><a href="tel:+18002345678">+1 (800) 234-5678</a></li>
                    <li><a href="mailto:support@moviego.com">support@flixgo.com</a></li>
                </ul>
                <ul class="footer__social">
                    <li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
                    <li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
                    <li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
                    <li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer copyright -->
            <div class="col-12">
                <div class="footer__copyright">
                    <small><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></small>

                    <ul>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <!-- end footer copyright -->
        </div>
    </div>
</footer>
<!-- end footer -->

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

<script>
    function getVal() {
        document.getElementById("punteggio").value = document.getElementById("form__slider-value").outerHTML;
    }

    let bookedSeat = [];
    let proiezione;
    let libera = "../../Smarty/img/cinema/sedia_libera.png";
    let occupazione = "../../Smarty/img/cinema/sedia_in_occupazione.png";

    function acquista() {
        if (bookedSeat.length > 0) {
            $("#book").append(
                "<input type='hidden' name='proiezione' value='" + proiezione + "' />",
                "<input type='hidden' name='posti' value='" + bookedSeat.join(';') + "' />"
            );
            document.getElementById('book').submit()

        } else {
            alert("Selezionare almeno un posto prima di acquistare");
        }
    }

    function book (value) {
        let id = value.getAttribute("id");
        proiezione = value.getAttribute("name");

        if (bookedSeat.includes(id)) {
            bookedSeat.splice(bookedSeat.indexOf(id), 1);
            value.setAttribute("src", libera);
        } else {
            bookedSeat.push(id);
            value.setAttribute("src", occupazione);
        }
    }
</script>

</body>

</html>
