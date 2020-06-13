<!-- header -->
<header class="header">
    <div class="header__wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header__content">
                        <!-- header logo -->
                        <a href="/MagicBoulevardCinema/" class="header__logo">
                            <img src="{$path}Smarty/img/logo.svg" alt="">
                        </a>
                        <!-- end header logo -->

                        <!-- header nav -->
                        <ul class="header__nav">
                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="header__nav-link" href="/MagicBoulevardCinema/index.php">Home</a>
                            </li>
                            <!-- end dropdown -->

                            <!-- dropdown -->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalogo</a>

                                <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                    <li><a href="{$path}Catalogo/prossimeUscite/">Prossime uscite</a></li>
                                    <li><a href="{$path}Catalogo/programmazioniPassate/">Programmazioni</a></li>
                                    <li><a href="{$path}Catalogo/piuApprezzati/">Film più apprezzati</a></li>
                                </ul>
                            </li>
                            <!-- end dropdown -->

                            <li class="header__nav-item">
                                <a href="{$path}Informazioni/getCosti/" class="header__nav-link">Prezzi</a>
                            </li>

                            <li class="header__nav-item">
                                <a href="{$path}Informazioni/getHelp/" class="header__nav-link">Aiuto</a>
                            </li>

                            <!-- dropdown -->
                            <li class="dropdown header__nav-item">
                                <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
                                {if ($utente->isVisitatore())}
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="{$path}Informazioni/getAbout/">Su di noi</a></li>
                                        <li><a href="{$path}Utente/signup">Registrati</a></li>
                                        <li><a href="{$path}Utente/controlloBigliettiNonRegistrato/?">I miei biglietti</a></li>
                                    </ul>
                                {else}
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="{$path}Informazioni/getAbout/">Su di noi</a></li>
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

                            {if ($utente->isVisitatore())}
                                <a href="{$path}Utente/login" methods="GET" class="header__sign-in">
                                    <i class="icon ion-ios-log-in"></i>
                                    <span>Login</span>
                                </a>
                            {elseif $utente->isRegistrato()}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="{$path}Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
                                        <li><a href="{$path}Utente/bigliettiAcquistati">I miei acquisti</a></li>
                                        <li><a href="{$path}Utente/showCommenti/">I miei giudizi</a></li>
                                        <li><a href="{$path}Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
                                    </ul>
                                </li>
                            {elseif $utente->isAdmin()}
                                <li class="header__nav-item">
                                    <a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>@{$utente->getUsername()}</span>
                                    </a>
                                    <ul class="dropdown-menu header__dropdown-menu" style="width: 230px" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="{$path}Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
                                        <li><a href="{$path}Admin/addFilm">Aggiungi film</a></li>
                                        <li><a href="{$path}Admin/gestioneProgrammazione/?">Gestione programmazione</a></li>
                                        <li><a href="{$path}Admin/gestioneUtenti">Gestione utenti</a></li>
                                        <li><a href="{$path}Admin/modificaPrezzi">Gestione prezzi</a></li>
                                        <li><a href="{$path}Admin/gestioneSale/?">Gestione sale</a></li>
                                        <li><a href="{$path}Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
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
                        </button>§
                        <!-- end header menu btn -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header search -->
    <form action="{$path}Ricerca/cercaFilm" method= "POST" class="header__search">
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