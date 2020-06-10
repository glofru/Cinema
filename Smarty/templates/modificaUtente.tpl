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

                            {if (isset($utente) && !$admin)}
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
                                    <li><a href="{$path}../../Admin/gestioneSale/?">Gestione sale</a></li>
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
            <!-- content -->
            <form class="form" method="POST" action="{$path}../../Utente/modifica" onsubmit="return validate()" style="width: 1000px" enctype="multipart/form-data">
                <div class="col-10">
                    <div class="card card--details card--series">
                        <div class="row">

                            <input type="hidden" name="utente" value="{$utente->getId()}">

                            {if isset($error)}
                                <script>alert({$error})</script>
                            {/if}

                            <!-- card cover -->
                            <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                                <div class="card__cover">
                                    <img id="mypropic" src="{$propic->getImmagineHTML()}" alt="">
                                    <button id="insert_image" class="sign__btn" type="button" style="width: 200px" onclick="document.getElementById('choose_image').click()">Carica foto profilo</button>
                                    <input id="choose_image" type="file" name="propic" onchange="validateImage()" style="display: none" accept=".jpg, .jpeg, .gif, .png">
                                    <br>
                                    <b><p id="image_name" class="faq__text" style="text-align: center; max-width: 300px">Nessuna immagine caricata (MAX 2MB)</p></b>
                                </div>
                            </div>
                            <!-- end card cover -->

                            <!-- card content -->
                            <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
                                <div class="card__content">

                                    <div class="col-8">
                                        <h1 class="details__title">Dati utente</h1>
                                    </div>

                                    <ul class="card__meta">
                                        <li><input class="form__input" type="text" id="username" name="username" value="{$utente->getUsername()}" placeholder="Username"></li>
                                        <li><input class="form__input" type="text" id="nome" name="nome" value="{$utente->getNome()}" placeholder="Nome"></li>
                                        <li><input class="form__input" type="text" id="cognome" name="cognome" value="{$utente->getCognome()}" placeholder="Cognome"></li>
                                        <li><input class="form__input" type="text" id="email" name="email" value="{$utente->getEmail()}" placeholder="Email"></li>
                                    </ul>
                                </div>

                                <div class="card__content">

                                    <div class="col-8">
                                        <h1 class="details__title">Cambio password</h1>
                                    </div>

                                    <ul class="card__meta">
                                        <li><input class="form__input" type="password" id="oldPwd" name="vecchiaPassword" placeholder="Vecchia password"></li>
                                        <li><input class="form__input" type="password" id="pw1" name="nuovaPassword" placeholder="Nuova password"></li>
                                        <li><input class="form__input" type="password" id="pw2" placeholder="Reinserisci nuova password"></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end card content -->
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="section__btn align-content-center">Applica modifiche</button>
                </div>
            </form>
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

<script>
    $(document).ready(function() {
        // Aggiorna nome copertina
        $('#choose_image').change(function (e) {
            document.getElementById("image_name").innerText = e.target.files[0].name;
        });
    })
    function nameIsValid(name) {
        let exp = /^[a-zA-Z\-]+$/;

        return name.match(exp) != null;
    }

    function usernameIsValid(username) {
        let exp = /^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/;

        return username.match(exp) != null;
    }

    function emailIsValid(email) {
        let exp = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;

        return email.match(exp) != null;
    }

    function passwordIsValid(password) {
        return password.length > 5;
    }

    function checkPwd(pw1, pw2) {
        return pw1 === pw2;
    }

    function validate() {
        if (nameIsValid($("#nome").val())) {
            if (nameIsValid($("#cognome").val())) {
                if (usernameIsValid($("#username").val())) {
                    if (emailIsValid($("#email").val())) {
                        if ($("#oldPwd").val().length > 0) {
                            if (passwordIsValid($("#oldPwd").val())) {
                                if (passwordIsValid($("#pw1").val())) {
                                    if (checkPwd($("#pw1").val(), $("#pw2").val())) {
                                        return true;
                                    } else {
                                        alert("Le nuove password non combaciano!");
                                    }
                                } else {
                                    alert("La nuova password deve avere almeno 6 caratteri")
                                }
                            } else {
                                alert("Vecchia password non valida, dev'essere almeno di 6 caratteri")
                            }
                        } else {
                            return true;
                        }
                    } else {
                        alert("Email non valida")
                    }
                } else {
                    alert("Username non valido!");
                }
            } else {
                alert("Cognome non valido");
            }
        } else {
            alert("Nome non valido");
        }

        return false;
    }

    function validateImage() {
        var formData = new FormData();

        var file = document.getElementById("choose_image").files[0];

        formData.append("Filedata", file);
        var t = file.type.split('/').pop().toLowerCase();
        if (t != "jpeg" && t != "jpg" && t != "png" && t != "gif") {
            alert('Inserire un file di immagine valido!');
            document.getElementById("choose_image").value = '';
            return false;
        }
        if (file.size > 2048000) {
            alert('Non puoi caricare file più grandi di 2 MB');
            document.getElementById("choose_image").value = '';
            return false;
        }
        return true;
    }
</script>

</body>