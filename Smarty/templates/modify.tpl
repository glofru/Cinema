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
    <title>Modifica profilo</title>

</head>
<body class="body">

<!-- header -->
<header class="header">
    <div class="header__wrap">
        <div class="container">
            <form class="row">
                <form class="col-12">
                    <!-- authorization form -->
                    <form action="/Admin/addFilm" method="POST" class="sign__form" enctype="multipart/form-data">
                        <div class="header__content">
                            <!-- header logo -->
                            <a href="../../index.php" class="header__logo">
                                <img src="../../Smarty/img/logo.svg" alt="">
                            </a>
                            <!-- end header logo -->
                            <!-- header apply modify-->
                            <div class="header__auth">
                                {if ($canModify)}
                                    <a href="#" class="section__btn align-content-center">Applica Modifiche</a>
                                {/if}
                            </div>
                            <!-- end header apply modify-->
                        </div>
                    </form>
                </form>
            </form>
        </div>
    </div>
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
            <!-- title -->
            <div class="col-12">
                <h1 class="details__title">Modifica Profilo</h1>
            </div>
            <!-- end title -->
            <!-- content -->
            <!-- username -->
            <div class="sign__group">
                <h1 class="details__title">@{$utente->getUsername()}{if ($admin)} [ADMIN]{/if}</h1>
                <input type="text" class="sign__input" placeholder="Username" name="Username">
            </div>
            <!-- end username -->
            <!-- card cover -->
            <div class="col-10">
                <div class="propic">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                            <div class="card__cover">
                                <img src="{$propic->getImmagine()}" alt="">
                                <button id="insert_image" class="sign__btn" type="button" style="width: 200px" onclick="document.getElementById('choose_image').click()">Carica immagine di profilo</button>
                                <input id="choose_image" type="file" name="propic" style="display: none" accept=".jpg, .jpeg, .gif, .png">
                                <br>
                                <b><p id="image_name" class="faq__text" style="text-align: center; max-width: 300px">Nessuna immagine caricata</p></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card cover -->
            <!-- nome -->
            <div class="sign__group">
                <h1 class="details__title">@{$utente->getNome()}{if ($admin)} [ADMIN]{/if}</h1>
                <input type="text" class="sign__input" placeholder="Nome" name="Nome">
            </div>
            <!-- end nome -->
            <!-- cognome -->
            <div class="sign__group">
                <h1 class="details__title">@{$utente->getCognome()}{if ($admin)} [ADMIN]{/if}</h1>
                <input type="text" class="sign__input" placeholder="Cognome" name="Cognome">
            </div>
            <!-- end cognome -->
            <!-- email -->
            <div class="sign__group">
                <h1 class="details__title">@{$utente->getEmail()}{if ($admin)} [ADMIN]{/if}</h1>
                <input type="text" class="sign__input" placeholder="Email" name="Email">
            </div>
            <!-- end email -->
            <!-- password -->
            <input type="hidden" name="token" value="{$token}" />

            {if $error}
                <div class="sign__group">
                    <span class="sign__text" style="color: red">Password non valida</span>
                </div>
            {/if}

            <!-- Pw1 -->
            <div class="sign__group">
                <input id="pw1" name="password" type="password" class="sign__input" placeholder="Nuova password">
            </div>

            <!-- Pw2 -->
            <div class="sign__group">
                <input id="pw2" type="password" class="sign__input" placeholder="Reinserisci password">
            </div>

            <!-- end password -->
            <!-- end content -->
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
    function passwordIsValid(password) {
        return password.length > 5;
    }

    function validate() {
        if ($("#pw1").val() === $("#pw2").val()) {
            if (passwordIsValid($("#pw1").val())) {
                return true;
            } else {
                alert("La password deve contenere almeno 6 caratteri");
            }
        } else {
            alert("Le password devono combaciare");
        }

        return false;
    }
</script>

</body>




