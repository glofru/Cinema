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

<!-- header -->
<header class="header">
    <div class="header__wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__content">
                        <!-- header logo -->
                        <a href="{$path}../../index.php" class="header__logo">
                            <img src="{$path}../../Smarty/img/logo.svg" alt="">
                        </a>
                        <!-- end header logo -->

                        <!-- header nav -->
                        <ul class="header__nav">
                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="{$path}../../index.php" role="button" >Home</a>


                            </li>
                            <!-- end dropdown -->

                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalogo</a>

                                <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                    <li><a href="{$path}../../Catalogo/prossimeUscite/">Prossime uscite</a></li>
                                    <li><a href="{$path}../../Catalogo/programmazioniPassate/">Programmazioni</a></li>
                                    <li><a href="{$path}../../Catalogo/piuApprezzati/">Film più apprezzati</a></li>
                                </ul>
                            </li>
                            <!-- end dropdown -->

                            <li class="header__nav-item">
                                <a href="{$path}../../Informazioni/getCosti/" class="header__nav-link">Prezzi</a>
                            </li>

                            <li class="header__nav-item">
                                <a href="{$path}../../Informazioni/getHelp/" class="header__nav-link">Aiuto</a>
                            </li>

                            <!-- dropdown -->
                            <li class="dropdown header__nav-item">
                                <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
                                {if (!isset($utente))}
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="{$path}../../Informazioni/getAbout/">Su di noi</a></li>
                                        <li><a href="{$path}../../Utente/signup">Registrati</a></li>
                                        <li><a href="{$path}../../Utente/controlloBigliettiNonRegistrato/?">I miei biglietti</a></li>
                                    </ul>
                                {else}
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="{$path}../../Informazioni/getAbout/">Su di noi</a></li>
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
                                <a href="{$path}../../Utente/login" methods="GET" class="header__sign-in">
                                    <i class="icon ion-ios-log-in"></i>
                                    <span>Login</span>
                                </a>
                            {elseif (isset($utente) && !$admin)}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="{$path}../../Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
                                        <li><a href="{$path}../../Utente/bigliettiAcquistati">I miei acquisti</a></li>
                                        <li><a href="{$path}../../Utente/showCommenti/">I miei giudizi</a></li>
                                        <li><a href="{$path}../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
                                    </ul>
                                </li>
                            {elseif (isset($utente) && $admin)}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="{$path}../../Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
                                        <li><a href="{$path}../../Admin/addFilm/?">Aggiungi film</a></li>
                                        <li><a href="">Gestione Proiezioni</a></li>
                                        <li><a href="{$path}../../Admin/gestioneUtenti/?">Gestione Utenti</a></li>
                                        <li><a href="{$path}../../Admin/modificaPrezzi/?">Gestione Prezzi</a></li>
                                        <li><a href="{$path}../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
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
    <form action="{$path}../../Ricerca/cercaFilm" method= "POST" class="header__search">
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
        <div class="details__bg" data-bg="{$path}../../Smarty/img/home/home__bg.jpg"></div>
        <!-- end details background -->

        <!-- details content -->
        <div class="container">
            <div class="row">
                <!-- title -->
                <div class="col-12">
                    <h1 class="details__title">@{$utente->getUsername()}{if ($admin)} [ADMIN]{/if}</h1>
                </div>
                <!-- end title -->

                <!-- content -->
                <div class="col-10">
                    <div class="card card--details card--series">
                        <div class="row">
                            <!-- card cover -->
                            <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                                <div class="card__cover">
                                    <img src="{$propic->getImmagine()}" alt="">
                                </div>
                            </div>
                            <!-- end card cover -->

                            <!-- card content -->
                            <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
                                <div class="card__content">


                                    <ul class="card__meta">
                                        <li><span>Nome:</span>{$utente->getNome()}</li>
                                        <li><span>Cognome:</span>{$utente->getCognome()}</li>
                                        {if ($canModify)}
                                            <li><span>Email:</span> <a style="cursor: default">{$utente->getEmail()}</a> </li>
                                        {/if}
                                    </ul>
                                </div>
                            </div>
                            <!-- end card content -->
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {if ($canModify)}
                        <a href="../../Utente/modifica/?id={$utente->getId()}" class="section__btn align-content-center">Modifica</a>
                    {/if}
                </div>
                <div class="col-12">
                    <h2 class="section__title"></h2>
                </div>
                {if !$admin}
                    <div class="col-12">
                        <h2 class="section__title section__title--center">Alcuni dei giudizi espressi dall'utente</h2>
                    </div>
                    {if sizeof($giudizi) === 0}
                    <div class="col-12">
                        <h2 class="section__title section__title--center">{if (!$admin)}L'utente non ha ancora espresso giudizi...{else}Un amministratore non può esprimere giudizi!{/if}</h2>
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
                                                    <img class="reviews__avatar" src="{$propic->getImmagine()}" alt="">
                                                    <span class="reviews__name" style="display: inline-block">{$rev->getTitle()}</span>
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
                {/if}
            </div>
        </div>
    </section>

<!-- footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- footer list -->
            <div class="col-12 col-md-3">
                <h6 class="footer__title">Scarica la nostra App</h6>
                <ul class="footer__app">
                    <li><a href="https://play.google.com/store?hl=it"><img src="{$path}../../Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
                    <li><a href="https://www.apple.com/it/ios/app-store/"><img src="{$path}../../Smarty/img/google-play-badge.png" alt=""></a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-6 col-sm-4 col-md-3">
                <h6 class="footer__title">Informazioni</h6>
                <ul class="footer__list">
                    <li><a href="{$path}../../Informazioni/getAbout/">Su di noi</a></li>
                    <li><a href="{$path}../../Informazioni/getCosti/">Costi</a></li>
                    <li><a href="{$path}../../Informazioni/getHelp/">Aiuto</a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-6 col-sm-4 col-md-3">
                <h6 class="footer__title">Termini legali</h6>
                <ul class="footer__list">
                    <li><a href="#">Termini d'uso</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Sicurezza</a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-12 col-sm-4 col-md-3">
                <h6 class="footer__title">Contatti</h6>
                <ul class="footer__list">
                    <li><a href="tel:+393357852000">+39 3357852000</a></li>
                    <li><a href="mailto:support@magicboulevardcinema.com">support@magicboulevardcinema.com</a></li>
                </ul>
                <ul class="footer__social">
                    <li class="facebook"><a href="https://facebook.com" target="_blank"><i class="icon ion-logo-facebook"></i></a></li>
                    <li class="instagram"><a href="https://instagram.com" target="_blank"><i class="icon ion-logo-instagram"></i></a></li>
                    <li class="twitter"><a href="https://twitter.com" target="_blank"><i class="icon ion-logo-twitter"></i></a></li>
                    <li class="vk"><a href="https://vk.com" target="_blank"><i class="icon ion-logo-vk"></i></a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer copyright -->
            <div class="col-12">
                <div class="footer__copyright">
                    <small><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></small>

                    <ul>
                        <li><a href="#">Termini d'uso</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <!-- end footer copyright -->
        </div>
    </div>
</footer>
<!-- end footer -->
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