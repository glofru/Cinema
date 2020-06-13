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
    <title>Registrati</title>

</head>

<body class="body" {if isset($e)}onload="alert('{$e}')"{/if}>

<div class="sign section--bg" data-bg="{$path}../../Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- registration form -->
                    <form id="form" action="/MagicBoulevardCinema/" onsubmit="return validate()" method="POST" class="sign__form">
                        <a href="/MagicBoulevardCinema/" class="sign__logo">
                            <img src="{$path}../../Smarty/img/logo.svg" alt="">
                        </a>
                        <div class="col-12">
                            <h2 class="section__title section__title--center">Crea l'account dell'admin</h2>
                        </div>
                        <!-- Nome -->
                        <div class="sign__group">
                            <input id="nome" type="text" name="nome" value="" class="sign__input" placeholder="Nome">
                        </div>

                        <!-- Cognome -->
                        <div class="sign__group">
                            <input id="cognome" type="text" name="cognome" value="" class="sign__input" placeholder="Cognome">
                        </div>

                        <!-- Username -->
                        <div class="sign__group">
                            <input id="username" type="text" name="username" value="" class="sign__input" placeholder="Username">
                        </div>

                        <!-- Email -->
                        <div class="sign__group">
                            <input id="email" type="email" name="email" value="" class="sign__input" placeholder="Email">
                        </div>


                        <!-- Password -->
                        <div class="sign__group">
                            <input id="pw1" type="password" name="password" class="sign__input" placeholder="Password">
                        </div>

                        <!-- Reinserisci password -->
                        <div class="sign__group">
                            <input id="pw2" type="password" class="sign__input" placeholder="Reinserisci la password">
                        </div>

                        <button class="sign__btn">Registrati</button>
                    </form>
                    <!-- registration form -->
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
        return password.length > 6;
    }

    function checkPwd(pw1, pw2) {
        return pw1 === pw2;
    }

    function validate() {
        if (nameIsValid($("#nome").val())) {
            if (nameIsValid($("#cognome").val())) {
                if (usernameIsValid($("#username").val())) {
                    if (emailIsValid($("#email").val())) {
                        if (passwordIsValid($("#pw1").val())) {
                            if (checkPwd($("#pw1").val(), $("#pw2").val())) {
                                return true;
                            } else {
                                alert("Le password non combaciano!");
                            }
                        } else {
                            alert("La password deve avere almeno 6 caratteri")
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
</script>

</body>

</html>