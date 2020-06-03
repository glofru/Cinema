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
                                    <li><a href="../../Catalogo/prossimeUscite/">Prossime uscite</a></li>
                                    <li><a href="../../Catalogo/programmazioniPassate/">Programmazioni</a></li>
                                    <li><a href="../../Catalogo/piuApprezzati/">Film più apprezzati</a></li>
                                </ul>
                            </li>
                            <!-- end dropdown -->

                            <li class="header__nav-item">
                                <a href="../../Informazioni/getCosti/" class="header__nav-link">Prezzi</a>
                            </li>

                            <li class="header__nav-item">
                                <a href="../../Informazioni/getHelp/" class="header__nav-link">Aiuto</a>
                            </li>

                            <!-- dropdown -->
                            <li class="dropdown header__nav-item">
                                <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="../../Informazioni/getAbout/">Su di noi</a></li>
                                    </ul>
                            </li>
                            <!-- end dropdown -->
                        </ul>
                        <!-- end header nav -->

                        <!-- header auth -->
                        <div class="header__auth">
                            <button class="header__search-btn" type="button">
                                <i class="icon ion-ios-search"></i>
                            </button>
                            {if (isset($utente) && !$admin)}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="/Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
                                        <li><a href="../../Utente/bigliettiAcquistati">I miei acquisti</a></li>
                                        <li><a href="../../Utente/showCommenti/">I miei giudizi</a></li>
                                        <li><a href="../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
                                    </ul>
                                </li>
                            {elseif (isset($utente) && $admin)}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="/Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
                                        <li><a href="">Gestione film</a></li>
                                        <li><a href="">Gestione Proiezioni</a></li>
                                        <li><a href="../../Admin/gestioneUtenti/?">Gestione Utenti</a></li>
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
                                                <img class="reviews__avatar" src="{$propic->getImmagine()}" alt="">
                                                <span class="reviews__name" style="display: inline-block">{$rev->getTitle()}</span>
                                                <span class="reviews__name" style="display: inline-block; position: relative; float: right; bottom: -7px">
                                                    <a style="line-height: normal" class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
                                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                                        <li><a onclick="erase({$rev->getFilm()->getId()}, {$rev->getUtente()->getId()})" href="#null">Cancella</a></li>
                                                        <form id="form" action="" method="POST"></form>
                                                    </ul>
                                                </span>
                                                <span class="reviews__time">da @{$rev->getUtente()->getUsername()} il {$rev->getDataPubblicazioneString()} nel film <a href="/Film/show/?film={$rev->getFilm()->getId()}&autoplay=true" target="_blank">{$rev->getFilm()->getNome()}</a></span>
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

<!-- footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- footer list -->
            <div class="col-12 col-md-3">
                <h6 class="footer__title">Scarica la nostra App</h6>
                <ul class="footer__app">
                    <li><a href="https://play.google.com/store?hl=it"><img src="../../Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
                    <li><a href="https://www.apple.com/it/ios/app-store/"><img src="../../Smarty/img/google-play-badge.png" alt=""></a></li>
                </ul>
            </div>
            <!-- end footer list -->

            <!-- footer list -->
            <div class="col-6 col-sm-4 col-md-3">
                <h6 class="footer__title">Informazioni</h6>
                <ul class="footer__list">
                    <li><a href="../../Informazioni/getAbout/">Su di noi</a></li>
                    <li><a href="../../Informazioni/getCosti/">Costi</a></li>
                    <li><a href="../../Informazioni/getHelp/">Aiuto</a></li>
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