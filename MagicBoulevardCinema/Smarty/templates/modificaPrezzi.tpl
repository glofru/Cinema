<!doctype html>
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
    <title>Installazione</title>

</head>
<body onload="setcookie()" class="body">

<div class="sign section--bg" data-bg="{$path}../../Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form id="form" action="{$path}/MagicBoulevardCinema/Admin/modificaPrezzi" class="sign__form" method="POST">
                        {*                        <a href="index.html" class="sign__logo">*}
                        <img src="Smarty/img/logo.svg" alt="">
                        {*                        </a>*}

                        <!-- Lunedì -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Lunedì: </p>
                            </div>
                            <input id="Mon" type="number" min="0" class="sign__input" placeholder="Prezzo lunedì" name="Mon" value="{$price["Mon"]}">
                        </div>

                        <!-- Martedì -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Martedì: </p>
                            </div>
                            <input id="Tue" type="number" min="0" class="sign__input" placeholder="Prezzo martedì" name="Tue" value="{$price["Tue"]}">
                        </div>

                        <!-- Mercoledì -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Mercoledì: </p>
                            </div>
                            <input id="Wed" type="number" min="0" class="sign__input" placeholder="Prezzo mercoledì" name="Wed" value="{$price["Wed"]}">
                        </div>

                        <!-- Giovedì -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Giovedì: </p>
                            </div>
                            <input id="Thu" type="number" min="0" class="sign__input" placeholder="Prezzo giovedì" name="Thu" value="{$price["Thu"]}">
                        </div>

                        <!-- Venerdì -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Venerdì: </p>
                            </div>
                            <input id="Fri" type="number" min="0" class="sign__input" placeholder="Prezzo venerdì" name="Fri" value="{$price["Fri"]}">
                        </div>

                        <!-- Sabato -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Sabato: </p>
                            </div>
                            <input id="Sat" type="number" min="0" class="sign__input" placeholder="Prezzo sabato" name="Sat" value="{$price["Sat"]}">
                        </div>

                        <!-- Domenica -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Domenica: </p>
                            </div>
                            <input id="Sun" type="number" min="0" class="sign__input" placeholder="Prezzo domenica" name="Sun" value="{$price["Sun"]}">
                        </div>

                        <!-- Sovrapprezzo prenotazione -->
                        <div class="sign__group">
                            <div class="col-12">
                                <p class="section__text">Sovrapprezzo: </p>
                            </div>
                            <input id="extra" type="number" min="0" class="sign__input" placeholder="Sovrapprezzo prenotazione" name="extra" value="{$extra}">
                        </div>

                        <button id="install" class="sign__btn" type="button">Installa</button>
                        <form action="/MagicBoulevardCinema/">
                            <button class="sign__btn" type="submit">Annulla</button>
                        </form>
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

<script>

    {if isset($error)}
        alert("{$error}");
    {/if}

    $("#install").click(function (e) {
        if ($("#Mon").val() === "" ||
            $("#Tue").val() === "" ||
            $("#Wed").val() === "" ||
            $("#Thu").val() === "" ||
            $("#Fri").val() === "" ||
            $("#Sat").val() === "" ||
            $("#Sun").val() === "" ||
            $("#extra").val() === "") {
            alert("Compila tutti i campi");
        } else {
            $("#form").submit();
        }
    });

</script>
<script>
    function setcookie(){
        document.cookie= "js_enabled=true"
    }
</script>
</body>
