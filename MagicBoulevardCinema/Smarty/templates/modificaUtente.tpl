<!DOCTYPE html>
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
    <link rel="apple-touch-icon" sizes="114x114" href="{$path}Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$path}Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body" {if (!$utente->isAdmin())}onload="changing(document.getElementById('newsletter').checked)"{/if}>

{include file="{$path}Smarty/templates/header.tpl"}


<!-- details -->
<section class="section details">
    <!-- details background -->
    <div class="details__bg" data-bg="{$path}Smarty/img/home/home__bg.jpg"></div>
    <!-- end details background -->

    <!-- details content -->
    <div class="container">
        <div class="row">
            <!-- content -->
            <form class="form" method="POST" action="{$path}Utente/modifica" onsubmit="return validate()" style="width: 1000px" enctype="multipart/form-data">
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
                            <!-- News Letter --->
                            <div class="sign__group sign__group--checkbox">
                                <input id="newsletter" name="newsletter" type="checkbox" {if !$utente->isAdmin()}{if $isASub === true}checked="checked" {else}{/if}onchange="changing(this.checked)"{/if} >
                                <label for="newsletter">Iscrivimi alla newsletter</label>
                            </div>
                            <div id="content"></div>
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

{include file="{$path}Smarty/templates/footer.tpl"}
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
    function changing(me){
        if(me === true){
            document.querySelector('#content').insertAdjacentHTML(
                'beforebegin',
                `<br/>
                 <div class="container" id="checklist">
                    <div class="row">
                    <h2 class="faq__text" style="margin: auto">Scegli i tuoi generi preferiti</h2>
                         <div class="col-lg-12">
                          {foreach $genere as $item}
                         <div class="sign__group sign__group--checkbox">
                            <input id="{$item}" name="{$item}" type="checkbox" {foreach $prefs as $p}{if $p == $item}checked="checked"{break}{/if}{/foreach} >
                            <label for="{$item}">{$item}</label>
                        </div>
                         {/foreach}
                            </div>
                         </div>
                    </div>
                 </div>`
            )
        } else {
            document.getElementById("checklist").remove();
        }
    }
    $(document).ready(function() {
        // Aggiorna nome copertina
        $('#choose_image').change(function (e) {
            document.getElementById("image_name").innerText = e.target.files[0].name;
        });
    })
    function nameIsValid(name) {
        let exp = /^([a-zA-Z '-]*)$/;

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