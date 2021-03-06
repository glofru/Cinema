<!doctype html>
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
    <link rel="apple-touch-icon" sizes="114x114" href={$path}Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href={$path}Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Installazione</title>

</head>
<body class="body">

<div class="sign section--bg" data-bg="{$path}Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form id="form" action="/MagicBoulevardCinema/" onsubmit="return validate()" class="sign__form" method="POST">
                        <!-- Logo -->
                        <a href="/MagicBoulevardCinema/" class="sign__logo">
                            <img src="{$path}Smarty/img/logo.svg" alt="">
                        </a>

                        <!-- Lunedì -->
                        <div class="sign__group">
                            <input id="Mon" type="number" min="0" class="sign__input" placeholder="Prezzo lunedì" name="Mon">
                        </div>

                        <!-- Martedì -->
                        <div class="sign__group">
                            <input id="Tue" type="number" min="0" class="sign__input" placeholder="Prezzo martedì" name="Tue">
                        </div>

                        <!-- Mercoledì -->
                        <div class="sign__group">
                            <input id="Wed" type="number" min="0" class="sign__input" placeholder="Prezzo mercoledì" name="Wed">
                        </div>

                        <!-- Giovedì -->
                        <div class="sign__group">
                            <input id="Thu" type="number" min="0" class="sign__input" placeholder="Prezzo giovedì" name="Thu">
                        </div>

                        <!-- Venerdì -->
                        <div class="sign__group">
                            <input id="Fri" type="number" min="0" class="sign__input" placeholder="Prezzo venerdì" name="Fri">
                        </div>

                        <!-- Sabato -->
                        <div class="sign__group">
                            <input id="Sat" type="number" min="0" class="sign__input" placeholder="Prezzo sabato" name="Sat">
                        </div>

                        <!-- Domenica -->
                        <div class="sign__group">
                            <input id="Sun" type="number" min="0" class="sign__input" placeholder="Prezzo domenica" name="Sun">
                        </div>

                        <!-- Sovrapprezzo prenotazione -->
                        <div class="sign__group">
                            <input id="extra" type="number" min="0" step="any" class="sign__input" placeholder="Sovrapprezzo prenotazione" name="extra">
                        </div>

                        <button id="install" class="sign__btn">Installa</button>

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

    {if isset($error)}
        alert("{$error}");
    {/if}

    function validate() {
        if ($("#Mon").val() === "" ||
            $("#Tue").val() === "" ||
            $("#Wed").val() === "" ||
            $("#Thu").val() === "" ||
            $("#Fri").val() === "" ||
            $("#Sat").val() === "" ||
            $("#Sun").val() === "" ||
            $("#extra").val() === "") {
            alert("Compila tutti i campi");
            return false;
        }

        return true;
    }

</script>
</body>
